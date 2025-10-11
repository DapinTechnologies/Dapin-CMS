<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Student;
use App\Models\Setting;
use App\Models\FeesCategory;
use App\Models\Fee;
use App\Models\MpesaSetting;
use App\Models\BankMpesaDetails;
use App\Models\PaybillDetail;
use App\Models\Transaction;
use App\Models\MpesaTrascation;
use App\Models\PaymentTransaction;
Use Auth;
use Toastr;
use Illuminate\Support\Facades\DB;
use Str;
use Illuminate\Support\Facades\Http;
use Log;
use Carbon\Carbon;
use App\Models\Stkpush;
use Storage;
class MpesaController extends Controller
{
    private $status;
    private $shortcode_type;
    private $app_url;

    public function __construct()
    {
        $this->status = config('mpesa.status');
        $this->shortcode_type = config('mpesa.shortcode_type');
        $this->app_url = config('app.url');
    }
    public function token() 
    {
        if ($this->status === 'sandbox'){
            $consumerKey = config('mpesa.consumerkey_sandbox');
            $consumerSecret = config('mpesa.consumersecret_sandbox');
            $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        } elseif ($this->status === 'live'){
            $consumerKey = config('mpesa.consumerkey');
            $consumerSecret = config('mpesa.consumersecret');
            $url = 'https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
        } else {
            return response('MPESA environment not configured', 400);
        }
    
        $response = Http::withBasicAuth($consumerKey, $consumerSecret)
                        ->withoutVerifying()
                        ->get($url);
    
        if ($response->successful()) {
            Log::info('Access Token Generated');
            return response()->json(['access_token' => $response['access_token']], 200);
        } else {
            $message = json_decode($response->body(), true);
            Log::error('Failed to generate access token', ['error' => $message]);
            return response($message['errorMessage'] ?? 'Failed to generate token', 400);
        }
    }

    public function initiatePush(Request $request)
    {
        Log::info('MPESA Environment', ['status' => $this->status]);
    
        // Validate input
        $request->validate([
            'fee_id' => 'required|exists:fees,id',
            'phone_number' => 'required|string',
            'payment_amount' => 'required|numeric|min:1'
        ]);
    
        // Generate access token
        $getAccessToken = $this->token();
        if ($getAccessToken->getStatusCode() !== 200) {
            return response()->json(['message' => 'Failed to generate access token'], 400);
        }
    
        $accessToken = $getAccessToken->getData(true)['access_token'];
    
        // Set sandbox-specific parameters
        if ($this->status === 'sandbox') {
            $passKey = config('mpesa.passkey_sandbox');
            $businessShortCode = config('mpesa.shortcode_sandbox');
            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            
            // Force PayBill for sandbox
            $transactionType = 'CustomerPayBillOnline';
            $partyB = $businessShortCode;
            
            // Validate and format phone number for sandbox
            $phoneNumber = $this->formatPhoneNumber($request->phone_number);
            if (!$phoneNumber) {
                return response()->json(['message' => 'Invalid phone number. Use format 2547XXXXXXXX'], 400);
            }
            
            // Validate amount for sandbox
            if ($request->payment_amount < 1 || $request->payment_amount > 100) {
                return response()->json(['message' => 'For sandbox testing, amount must be between 1 and 100 KES'], 400);
            }
        } else {
            // Live environment parameters
            $passKey = config('mpesa.passkey');
            $businessShortCode = config('mpesa.shortcode');
            $url = 'https://api.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            
            $transactionType = $this->shortcode_type === 'till' 
                ? 'CustomerBuyGoodsOnline' 
                : 'CustomerPayBillOnline';
            
            $partyB = $this->shortcode_type === 'till'
                ? config('mpesa.till')
                : $businessShortCode;
                
            $phoneNumber = $this->formatPhoneNumber($request->phone_number);
            if (!$phoneNumber) {
                return response()->json(['message' => 'Invalid phone number. Use format 2547XXXXXXXX'], 400);
            }
        }
    
        $timestamp = Carbon::now()->format('YmdHis');
        $password = base64_encode($businessShortCode . $passKey . $timestamp);
        $amount = round($request->payment_amount, 2); // Ensure proper amount format
        $callbackUrl = $this->app_url . '/stkcallback';
    
        // Send STK Push request
        $response = Http::withToken($accessToken)
                        ->withoutVerifying()
                        ->post($url, [
                            'BusinessShortCode' => $businessShortCode,
                            'Password' => $password,
                            'Timestamp' => $timestamp,
                            'TransactionType' => $transactionType,
                            'Amount' => $amount,
                            'PartyA' => $phoneNumber,
                            'PartyB' => $partyB,
                            'PhoneNumber' => $phoneNumber,
                            'CallBackURL' => $callbackUrl,
                            'AccountReference' => 'Fee Payment',
                            'TransactionDesc' => 'Student Fee Payment'
                        ]);
    
        Log::info('STK Push request sent', ['response' => $response->body()]);
    
        if ($response->successful()) {
            $res = json_decode($response->body());
            if ($res->ResponseCode == 0) {
                $fee = Fee::findOrFail($request->fee_id);
    
                $stkpush = new Stkpush();
                $stkpush->MerchantRequestID = $res->MerchantRequestID;
                $stkpush->CheckoutRequestID = $res->CheckoutRequestID;
                $stkpush->CustomerMessage = $res->CustomerMessage;
                $stkpush->amount = $amount;
                $stkpush->PhoneNumber = $phoneNumber;
                $stkpush->status = 'Requested';
                $stkpush->ResponseCode = $res->ResponseCode;
                $stkpush->AccountReference = 'Fee Payment';
                $stkpush->TransactionDesc = 'Student Fee Payment';
                $stkpush->fee_id = $fee->id;
                $stkpush->original_paid_amount = $fee->paid_amount;
                $stkpush->original_due_amount = $fee->due_amount;
                $stkpush->save();
    
                return response()->json([
                    'message' => 'Check your phone to enter PIN to complete payment',
                    'is_sandbox' => $this->status === 'sandbox'
                ]);
            }
        }
    
        // Handle API error
        $message = json_decode($response->body(), true);
        $errorText = $message['errorMessage'] ?? 'MPESA Request Failed';
    
        // Custom error messaging
        if (str_contains(strtolower($errorText), 'invalid phonenumber')) {
            $errorText = 'Invalid phone number. Use format 2547XXXXXXXX.';
        } elseif (str_contains(strtolower($errorText), 'insufficient funds')) {
            $errorText = 'Transaction failed. Insufficient funds in the M-Pesa account.';
        } elseif (str_contains(strtolower($errorText), 'system is busy')) {
            $errorText = 'Safaricom system is busy. Please try again in a few minutes.';
        }
    
        Log::error('STK Push request failed', ['error' => $errorText]);
        return response()->json(['message' => $errorText], 400);
    }
    
    
    
    
    public function StkCallBack(Request $request)
    {
   
        $data = file_get_contents('php://input');
        $response = json_decode($data);
        Log::info('Callback Response:', ['response' => $response]);
    
        $ResultCode = $response->Body->stkCallback->ResultCode;
        $CheckoutRequestID = $response->Body->stkCallback->CheckoutRequestID;
    
        $payment = Stkpush::where('CheckoutRequestID', $CheckoutRequestID)->firstOrFail();
    
        if ($ResultCode == 0) {
            $ResultDesc = $response->Body->stkCallback->ResultDesc;
            $Amount = $response->Body->stkCallback->CallbackMetadata->Item[0]->Value;
            $MpesaReceiptNumber = $response->Body->stkCallback->CallbackMetadata->Item[1]->Value;
            $TransactionDate = $response->Body->stkCallback->CallbackMetadata->Item[3]->Value;
            $PhoneNumber = $response->Body->stkCallback->CallbackMetadata->Item[4]->Value;
    
            // Update stkpush record
            $payment->update([
                'status' => 'Paid',
                'TransactionDate' => $TransactionDate,
                'MpesaReceiptNumber' => $MpesaReceiptNumber,
                'ResultDesc' => $ResultDesc,
                'amount' => $Amount
            ]);
    
            // Update the Fee model safely
            $fee = Fee::find($payment->fee_id);
            if ($fee) {
                $creditedAmount = min($Amount, $fee->due_amount);
                $fee->update([
                    'paid_amount' => $fee->paid_amount + $creditedAmount,
                    'due_amount' => max(0, $fee->due_amount - $creditedAmount),
                    'status' => ($fee->due_amount - $creditedAmount) <= 0 ? 1 : 0,
                    'pay_date' => now(),
                ]);
            }
    
            return response()->json(['message' => 'Payment Successful']);
        } else {
            $ResultDesc = $response->Body->stkCallback->ResultDesc;
            $payment->update([
                'status' => 'Failed',
                'ResultDesc' => $ResultDesc
            ]);
    
            // Revert original fee values
            $fee = Fee::find($payment->fee_id);
            if ($fee) {
                $fee->update([
                    'paid_amount' => $payment->original_paid_amount,
                    'due_amount' => $payment->original_due_amount,
                    'status' => ($payment->original_due_amount <= 0) ? 1 : 0,
                ]);
            }
    
            return response()->json(['message' => 'Payment Failed']);
        }
    }
    
    
    public function checkPaymentStatus($id)
    {
        $fee = Fee::findOrFail($id);
        $stk = Stkpush::where('fee_id', $fee->id)->latest()->first();
    
        if ($fee->status == 1) {
            return response()->json(['status' => 'Paid']);
        }
    
        if ($stk && $stk->status == 'Failed') {
            return response()->json(['status' => 'Failed']);
        }
    
        return response()->json(['status' => 'Pending']);
    }
    

    
public function StudentProcess($id, Request $request)
{
    $fee = Fee::findOrFail($id);

    // Retrieve student information (assuming there's a relationship between Fee and Student)
    $student = $fee->studentEnroll->student;  // Adjust this based on your model relationships
    $phoneNumber = $student->phone ?? '';  // Assuming 'phone' is the phone number field

    // Calculate the payment amount and balance
    $paymentAmount = $request->get('payment_amount', max(0, $fee->fee_amount - $fee->paid_amount));
    $balance = $fee->fee_amount - $fee->paid_amount;
    
    $bankDetails = BankMpesaDetails::first();
    $paybill = PaybillDetail::first(); // or PaybillDetails::first()

    // Pass all relevant data to the view
    return view('student.fees.student_mpesa', compact('fee', 'bankDetails', 'paybill', 'balance', 'paymentAmount', 'phoneNumber'));
}


private function formatPhoneNumber($number)
{
    $number = preg_replace('/[^0-9]/', '', $number);
    
    // Convert 07... to 2547...
    if (strlen($number) === 10 && substr($number, 0, 1) === '0') {
        return '254' . substr($number, 1);
    }
    
    // Convert 7... to 2547...
    if (strlen($number) === 9 && substr($number, 0, 1) === '7') {
        return '254' . $number;
    }
    
    // Check if already in 254 format
    if (strlen($number) === 12 && substr($number, 0, 3) === '254') {
        return $number;
    }
    
    return false;
}
public function index()
{
    $title = 'Payment Gateway';
    $access = 'sms';
    $rows= 'row';

    $mpesaSettings = MpesaSetting::first(); // Assuming a single record
    $bankDetails = BankMpesaDetails::first(); // Assuming a single record
    $paybillDetails = PaybillDetail::first(); // Assuming a single record

    return view('admin.payment-setting.index', compact('mpesaSettings', 'bankDetails', 'paybillDetails'));

}




public function myMpesaStatement()
{
   // $user = Auth::user();
   //$studentId = session('student_id'); 
   //Auth::guard('student')->login($student);

   $student = Auth::guard('student')->user();
    //dd($student);

    if (!$student) {
        return redirect()->route('login')->with('error', 'Please log in again.');
    }

    $enrollIds = \App\Models\StudentEnroll::where('student_id', $student->id)->pluck('id');

    $feeIds = \App\Models\Fee::whereIn('student_enroll_id', $enrollIds)->pluck('id');

    $transactions = \App\Models\Stkpush::with('fee.category')
        ->whereIn('fee_id', $feeIds)
        ->orderByDesc('created_at')
        ->get();

       // dd($transactions);
    return view('student.fees.my_statement', compact('transactions', 'student'));
}






    // public function StudentProcess($id)
    // {
    //     //dd($id); 
    //     $fee = Fee::findOrFail($id);

    //     // Retrieve the bank details and Paybill information if available
    //     $bankDetails = BankDetails::first(); // Modify this based on your actual database structure
    //     $paybill = PaybillDetails::first();  // Modify this based on your actual database structure

    //     // Calculate the balance or any other data you need to display
    //     $balance = $fee->fee_amount - $fee->amount_paid; // Adjust this calculation based on your fee structure

    //     // Pass the data to the view
    //     return view('student.mpesa_payment', compact('fee', 'bankDetails', 'paybill', 'balance'));
    // }


}
