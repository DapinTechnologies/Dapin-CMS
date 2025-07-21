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
Use Auth;
use Toastr;
use Illuminate\Support\Facades\DB;
use Str;
use Illuminate\Support\Facades\Http;
use Log;
use Carbon\Carbon;
use App\Models\Stkrequest;
use App\Models\PaymentTransaction;


class PesaController extends Controller
{


    protected $app_url;

    public function __construct()
    {
        $this->app_url = config('app.url');
    }


    private function token()
    {
        $mpesaSettings = MpesaSetting::first();
        if (!$mpesaSettings) {
            throw new \Exception('M-Pesa settings not configured.');
        }

        $consumerKey = $mpesaSettings->consumer_key;
        $consumerSecret = $mpesaSettings->consumer_secret;

        $credentials = base64_encode("$consumerKey:$consumerSecret");

       // dd($credentials);
        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->withOptions(['verify' => false]) // Disable SSL verification (or use CA bundle)
        ->get("https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");

        if (!$response->successful() || !isset($response->json()['access_token'])) {
            throw new \Exception('Failed to get M-Pesa access token.');
        }

        return $response->json()['access_token'];
     
    }

    // Process payment
    public function process($id, Request $request)
    {
        // Find the fee record
        $fee = Fee::find($id);

        // If fee not found, redirect with error
        if (!$fee) {
            return redirect()->route('student.fees.index')->with('error', 'Fee record not found.');
        }

        // Fetch bank and PayBill details
        $bankDetails = BankMpesaDetails::first();
        $paybill = PaybillDetail::first();

        // Calculate balance
        $balance = max(0, $fee->fee_amount - $fee->paid_amount);

        // Data for M-Pesa payment page
        return view('student.fees.mpesa_payment', [
            'fee' => $fee,
            'balance' => $balance,
            'bankDetails' => $bankDetails,
            'paybill' => $paybill
        ]);
    }


    public function getMpesaAccessToken($consumerKey, $consumerSecret)
{
    $tokenUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $tokenUrl);
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
    curl_close($curl);

    $data = json_decode($response, true);
    
    return $data['access_token'] ?? null; // Return access token if available
}

public function sendStkPush($token, $businessShortCode, $password, $timestamp, $transactionType, $amount, $phone, $callbackUrl)
{
    $onlinePaymentUrl = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';

    // Prepare STK Push data
    $stkPushData = [
        'BusinessShortCode' => $businessShortCode,
        'Password' => $password,
        'Timestamp' => $timestamp,
        'TransactionType' => $transactionType,
        'Amount' => $amount,
        'PartyA' => $phone,
        'PartyB' => $businessShortCode,
        'PhoneNumber' => $phone,
        'CallBackURL' => $callbackUrl,
        'AccountReference' => 'Fee Payment',
        'TransactionDesc' => 'Fee Payment',
    ];

    // Send STK Push request
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $onlinePaymentUrl);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json', 'Authorization: Bearer ' . $token]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($stkPushData));
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($curl);
    curl_close($curl);

    return json_decode($response); // Return the response as a decoded JSON object
}


public function initiatePush(Request $request)
{
    $request->validate([
        'phone_number' => 'required|numeric',
        'payment_amount' => 'required|numeric|min:1',
        'fee_id' => 'required|exists:fees,id',
    ]);

    $fee = Fee::with('studentEnroll.student')->findOrFail($request->fee_id);
    $phone = $this->formatPhoneNumber($request->phone_number);
    $amount = $request->payment_amount;

    if (!$phone) {
        return back()->withErrors(['phone_number' => 'Invalid phone format. Use 2547XXXXXXXX']);
    }

    // Get M-Pesa credentials
    $consumerKey = env('MPESA_CONSUMER_KEY_SANDBOX');
    $consumerSecret = env('MPESA_CONSUMER_SECRET_SANDBOX');
    $businessShortCode = env('MPESA_SHORT_CODE_SANDBOX');
    $passkey = env('MPESA_PASS_KEY_SANDBOX');
    
    $timestamp = Carbon::now()->format('YmdHis');
    $password = base64_encode($businessShortCode . $passkey . $timestamp);
    $callbackUrl = $this->app_url . '/api/mpesa/callback';

    // Get access token
    $token = $this->getMpesaAccessToken($consumerKey, $consumerSecret);
    if (!$token) {
        return back()->withErrors(['message' => 'Failed to get access token']);
    }

    // Send STK Push
    $stkResponse = $this->sendStkPush(
        $token, 
        $businessShortCode, 
        $password, 
        $timestamp, 
        'CustomerPayBillOnline', 
        $amount, 
        $phone, 
        $callbackUrl
    );

    if (isset($stkResponse->CheckoutRequestID)) {
        DB::beginTransaction();
        try {
            // Create payment record
            $payment = PaymentTransaction::create([
                'merchant_request_id' => $stkResponse->MerchantRequestID,
                'checkout_request_id' => $stkResponse->CheckoutRequestID,
                'phone_number' => $phone,
                'payment_amount' => $amount,
                'status' => 'Pending',
                'fee_id' => $fee->id,
                'student_id' => $fee->studentEnroll->student->id,
            ]);

            // Create STK request record
            Stkrequest::create([
                'merchant_request_id' => $stkResponse->MerchantRequestID,
                'checkout_request_id' => $stkResponse->CheckoutRequestID,
                'response_code' => $stkResponse->ResponseCode,
                'customer_message' => $stkResponse->CustomerMessage,
                'phone_number' => $phone,
                'amount' => $amount,
                'status' => 'Requested',
                'fee_id' => $fee->id,
            ]);

            DB::commit();
            return back()->with('success', 'Payment request sent. Check your phone to complete payment.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment initiation failed: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Failed to initiate payment']);
        }
    } else {
        Log::error('STK Push failed', ['response' => $stkResponse]);
        return back()->withErrors(['message' => $stkResponse->errorMessage ?? 'Payment initiation failed']);
    }
}

public function handleCallback(Request $request)
{
    try {
        $data = json_decode($request->getContent(), true);
        Log::info('M-Pesa Callback Received:', $data);

        if (!isset($data['Body']['stkCallback'])) {
            throw new \Exception('Invalid callback structure');
        }

        $callback = $data['Body']['stkCallback'];
        $checkoutRequestID = $callback['CheckoutRequestID'];
        $resultCode = $callback['ResultCode'];

        DB::beginTransaction();

        // Find the payment transaction
        $payment = PaymentTransaction::where('checkout_request_id', $checkoutRequestID)->first();
        
        if (!$payment) {
            throw new \Exception("Transaction not found for CheckoutRequestID: $checkoutRequestID");
        }

        // Update transaction status
        $status = ($resultCode == 0) ? 'Successful' : 'Failed';
        $updateData = ['status' => $status];

        if ($resultCode == 0 && isset($callback['CallbackMetadata']['Item'])) {
            $metadata = $callback['CallbackMetadata']['Item'];
            $updateData['mpesa_receipt_number'] = $metadata[1]['Value'] ?? null;
            $updateData['transaction_date'] = isset($metadata[3]['Value']) 
                ? Carbon::parse($metadata[3]['Value'])->toDateTimeString() 
                : now();
        }

        $payment->update($updateData);

        // If payment successful, update related records
        if ($resultCode == 0) {
            $fee = $payment->fee;
            if ($fee) {
                $creditedAmount = min($payment->amount, $fee->due_amount);
                
                $fee->update([
                    'paid_amount' => $fee->paid_amount + $creditedAmount,
                    'due_amount' => max(0, $fee->due_amount - $creditedAmount),
                    'status' => ($fee->due_amount - $creditedAmount) <= 0 ? 1 : 0,
                    'pay_date' => now(),
                ]);

                Transaction::create([
                    'transaction_id' => Str::uuid(),
                    'amount' => $creditedAmount,
                    'type' => 'credit',
                    'status' => 'approved',
                    'student_id' => $payment->student_id,
                    'fee_id' => $fee->id,
                    'CheckoutRequestID' => $checkoutRequestID,
                    'created_by' => Auth::id(),
                ]);
            }
        }

        DB::commit();
        return response()->json(['message' => 'Callback processed successfully']);

    } catch (\Exception $e) {
        DB::rollBack();
        Log::error('Callback processing error: ' . $e->getMessage());
        return response()->json(['message' => 'Error processing callback'], 500);
    }
}

private function formatPhoneNumber($number)
{
    $number = preg_replace('/[^0-9]/', '', $number);
    
    if (strlen($number) === 10 && strpos($number, '0') === 0) {
        return '254' . substr($number, 1);
    }
    
    if (strlen($number) === 9 && strpos($number, '7') === 0) {
        return '254' . $number;
    }
    
    if (strlen($number) === 12 && strpos($number, '254') === 0) {
        return $number;
    }
    
    return false;


    return response()->json(['message' => 'Callback received']);
}







public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'consumer_key' => 'required|string|max:255',
        'consumer_secret' => 'required|string|max:255',
        'shortcode' => 'required|string|max:10',
        'passkey' => 'required|string|max:255', // Add passkey validation
        'bank_name' => 'required|string|max:255',
        'bank_account' => 'required|string|max:255',
        'bank_branch' => 'required|string|max:255',
        'paybill_number' => 'required|string|max:10',
        'paybill_account' => 'required|string|max:255',
    ]);

    // Update or create MpesaSetting
    MpesaSetting::updateOrCreate(
        ['id' => 1], // Assume a single record, replace with actual condition if needed
        [
            'consumer_key' => $validated['consumer_key'],
            'consumer_secret' => $validated['consumer_secret'],
            'shortcode' => $validated['shortcode'],
            'passkey' => $validated['passkey'], // Add passkey
        ]
    );

    // Update or create BankMpesaDetails
    BankMpesaDetails::updateOrCreate(
        ['id' => 1], // Assume a single record, replace with actual condition if needed
        [
            'bank_name' => $validated['bank_name'],
            'bank_account' => $validated['bank_account'],
            'bank_branch' => $validated['bank_branch'],
        ]
    );

    // Update or create PaybillDetail
    PaybillDetail::updateOrCreate(
        ['id' => 1], // Assume a single record, replace with actual condition if needed
        [
            'paybill_number' => $validated['paybill_number'],
            'paybill_account' => $validated['paybill_account'],
        ]
    );

    // Redirect or return success response
    return redirect()->back()->with('success', 'Settings have been successfully saved!');
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



    //  public function process($id, Request $request)
    // {
    //     $queryData = $request->query();
    
    //     // Fetch Fee Category details
    //     $feeCategory = FeesCategory::findOrFail($id);
    
    //     if (empty($queryData)) {
    //         return redirect()->route('paymentprocess', [
    //             'id' => $id,
    //             'fee_id' => $id, // Pass fee_id here
    //             'student_id' => auth()->id(),
    //             'fee_category_id' => $feeCategory->category_id,
    //             'due_date' => now()->addDays(30)->format('Y-m-d'),
    //             'fee_amount' => $feeCategory->amount,
    //             'paid_amount' => 0,
    //             'phone_number' => auth()->user()->phone ?? '',
               
    //             'fee_category_title' => $feeCategory->title,
    //             'pay_date' => now()->format('Y-m-d'),
    //         ]);
    //     }
    
    //     $formData = [
    //         'fee_category_id' => $feeCategory->id,
    //         'fee_amount' => $queryData['fee_amount'] ?? $feeCategory->amount,
    //         'phone_number' => $queryData['phone_number'] ?? auth()->user()->phone ?? '',
    //         'due_date' => $queryData['due_date'] ?? now()->addDays(30)->format('Y-m-d'),
    //         'fee_category_title' => $queryData['fee_category_title'] ?? $feeCategory->title,
    //     ];
    
    //     return view('student.fees.mpesa_payment', [
    //         'paymentId' => $id,
    //         'feeId' => $id, // Ensure this is passed
    //         'queryData' => $queryData,
    //         'formData' => $formData,
    //         'feeCategoryTitle' => $feeCategory->title,
    //     ]);
    // }
    
    





}
