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
Use Auth;
use Toastr;
use Illuminate\Support\Facades\DB;
use Str;
use Illuminate\Support\Facades\Http;

use Carbon\Carbon;
use App\Models\Stkrequest;
class PesaController extends Controller
{
    
    public function process($id, Request $request)
    {
        $queryData = $request->query();
    
        // Fetch Fee Category details
        $feeCategory = FeesCategory::findOrFail($id);
    
        if (empty($queryData)) {
            return redirect()->route('paymentprocess', [
                'id' => $id,
                'fee_id' => $id, // Pass fee_id here
                'student_id' => auth()->id(),
                'fee_category_id' => $feeCategory->category_id,
                'due_date' => now()->addDays(30)->format('Y-m-d'),
                'fee_amount' => $feeCategory->amount,
                'paid_amount' => 0,
                'phone_number' => auth()->user()->phone ?? '',
               
                'fee_category_title' => $feeCategory->title,
                'pay_date' => now()->format('Y-m-d'),
            ]);
        }
    
        $formData = [
            'fee_category_id' => $feeCategory->id,
            'fee_amount' => $queryData['fee_amount'] ?? $feeCategory->amount,
            'phone_number' => $queryData['phone_number'] ?? auth()->user()->phone ?? '',
            'due_date' => $queryData['due_date'] ?? now()->addDays(30)->format('Y-m-d'),
            'fee_category_title' => $queryData['fee_category_title'] ?? $feeCategory->title,
        ];
    
        return view('student.fees.mpesa_payment', [
            'paymentId' => $id,
            'feeId' => $id, // Ensure this is passed
            'queryData' => $queryData,
            'formData' => $formData,
            'feeCategoryTitle' => $feeCategory->title,
        ]);
    }
    
    


    public function token(){
        
        $consumerKey = 'BsAU74zUN0GsLllnOfPwtitJM6p4dsxt5XDd4lErwY5eqnU4';
        $consumerSecret = 'zQyxrE8WLOjmHANwNo1G4AG19NXsphiW3LJD0osRZwRRdglhkk4s9AB5GIr29FWr';
        $url = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
 
        $response = Http::withBasicAuth($consumerKey, $consumerSecret)->get($url);
      

        return $response['access_token'];
       // dd($response['access_token']);
    }
    

    public function manualPay(Request $request)
{
    // Validate input data
    $request->validate([
        'fee_id' => 'required|exists:fees,id',
        'payment_amount' => 'required|numeric|min:1',
        'phone_number' => 'required|numeric',
    ]);

    // Retrieve the fee details
    $fee = Fee::findOrFail($request->fee_id);
    $Amount = $request->payment_amount;
    $phoneNumber = $request->phone_number;

    // Fetch the authenticated student
    $studentId = Auth::user()->id;

    // Clean the phone number (standardize it)
    if (str_starts_with($phoneNumber, '0')) {
        $phoneNumber = '254' . substr($phoneNumber, 1);
    } elseif (str_starts_with($phoneNumber, '+')) {
        $phoneNumber = substr($phoneNumber, 1);
    }

    // Validate the phone number format
    if (!preg_match('/^2547[0-9]{8}$/', $phoneNumber)) {
        return redirect()->back()->withErrors(['phone_number' => 'Invalid phone number format.']);
    }

    // Get Access Token
    $accessToken = $this->token();
    if (!$accessToken) {
        return redirect()->back()->withErrors(['payment_amount' => 'Failed to get access token.']);
    }

    // Prepare the STK Push request
    $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
    $BusinessShortCode = 174379;  // Business shortcode (replace with your shortcode)
    $Timestamp = now()->format('YmdHis');
    $PassKey = 'bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919';  // Passkey
    $password = base64_encode($BusinessShortCode . $PassKey . $Timestamp);

    // Make the STK Push request to M-Pesa API
    $response = Http::withToken($accessToken)->post($url, [
        'BusinessShortCode' => $BusinessShortCode,
        'Password' => $password,
        'Timestamp' => $Timestamp,
        'TransactionType' => 'CustomerPayBillOnline',
        'Amount' => $Amount,
        'PartyA' => $phoneNumber,
        'PartyB' => $BusinessShortCode,
        'PhoneNumber' => $phoneNumber,
        'CallBackURL' => 'https://your-ngrok-url.ngrok.io/student/stkcallback',  // Replace with your callback URL
        'AccountReference' => 'Fee Payment',
        'TransactionDesc' => 'Fee Payment',
    ]);

    $res = $response->json();

    // Check if the request was successful
    if (isset($res['ResponseCode']) && $res['ResponseCode'] == 0) {
        // Save the STK Push request data
        $payment = new Stkrequest();
        $payment->MerchantRequestID = $res['MerchantRequestID'];
        $payment->CheckoutRequestID = $res['CheckoutRequestID'];
        $payment->TransactionDesc = 'Fee Payment';
        $payment->phone_number = $phoneNumber;
        $payment->Amount = $Amount;
        $payment->fee_id = $fee->id;
        $payment->student_name = Auth::user()->name;  // Store student name
        $payment->Date_payment = now();
        $payment->status = 'Pending';
        $payment->save();

        // Redirect the user to a payment status page or the fees index with a success message
        return redirect()->route('student.fees.index')->with('message', 'Payment request sent. Please complete the payment on your phone.');
    } else {
        // If the payment initiation failed
        return redirect()->back()->withErrors(['payment_amount' => 'Failed to initiate payment. Try again later.']);
    }
}


public function StkCallback()
{
    // Get the raw data from M-Pesa's callback
    $data = file_get_contents('php://input');
    $response = json_decode($data, true);
    
    \Log::info('STK Push Callback:', $data);  // Log callback data for debugging

    if (isset($response['Body']['stkCallback'])) {
        $callback = $response['Body']['stkCallback'];
        $ResultCode = $callback['ResultCode'];
        $CheckoutRequestID = $callback['CheckoutRequestID'];

        // Find the original payment request using CheckoutRequestID
        $payment = StkRequest::where('CheckoutRequestID', $CheckoutRequestID)->first();

        if ($payment) {
            // Check if the payment was successful
            if ($ResultCode == 0) {
                // Payment was successful
                $payment->status = 'Paid';
                $payment->MpesaReceiptNumber = $callback['CallbackMetadata']['Item'][1]['Value'];  // Receipt Number
                $payment->TransactionDate = $callback['CallbackMetadata']['Item'][3]['Value'];  // Transaction Date
                $payment->save();

                // Find the corresponding fee record for the student
                $student = Student::where('phone_number', $payment->phone_number)->first();
                $fee = Fee::where('student_id', $student->id)->first();

                if ($fee) {
                    // Update the fee record
                    $fee->payment_status = 'paid';
                    $fee->paid_amount += $payment->Amount;  // Add the paid amount to the already paid amount
                    $fee->due_amount -= $payment->Amount;  // Deduct the paid amount from the due amount
                    $fee->transaction_date = $payment->TransactionDate;
                    $fee->receipt_number = $payment->MpesaReceiptNumber;
                    $fee->save();

                    // Record the transaction
                    Transaction::create([
                        'student_id' => $student->id,
                        'amount' => $payment->Amount,
                        'transaction_date' => $payment->TransactionDate,
                        'receipt_number' => $payment->MpesaReceiptNumber,
                        'payment_status' => 'successful',
                        'payment_method' => 'M-Pesa',
                    ]);

                    return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);
                }
            } else {
                // Payment failed, log the failure and update payment status
                $payment->status = 'Failed';
                $payment->ResultDesc = $callback['ResultDesc'];
                $payment->save();
            }
        }
    }

    return response()->json(['status' => 'failed', 'message' => 'Invalid callback data']);
}













                // Payment successful
                // DB::beginTransaction();
                // $fee->paid_amount += $Amount;
                // $fee->due_amount = max(0, $fee->fee_amount - $fee->paid_amount);
                // $fee->status = $fee->paid_amount >= $fee->fee_amount ? '1' : '0';
                // $fee->save();
    
                // $transaction = new Transaction();
                // $transaction->transaction_id = Str::random(16);
                // $transaction->amount = $Amount;
                // $transaction->type = '1'; // Payment type: credit
                // $transaction->created_by = Auth::id();
                // $fee->studentEnroll->student->transactions()->save($transaction);
    
                // DB::commit();
    
                //return redirect()->route('student.fees.index')->with('success', 'Payment successfully recorded.');if (isset($res['ResponseCode']) && $res['ResponseCode'] == 0) {
                    // Save the pending payment in the database
        //             DB::beginTransaction();
                
        //             $transaction = new Transaction();
        //             $transaction->transaction_id = $res['CheckoutRequestID']; // Use M-Pesa's CheckoutRequestID
        //             $transaction->fee_id = $fee->id;
        //             $transaction->amount = $Amount;
        //             $transaction->status = 'pending'; // Set initial status to pending
        //             $transaction->created_by = Auth::id();
        //             $transaction->save();
                
        //             DB::commit();
                
        //             return redirect()->route('student.fees.index')->with('success', 'Payment initiated. Please complete it on your phone.');
        //         }
               
                
        //     } elseif (isset($res['errorCode']) && $res['errorCode'] == '400.002.01') {
        //         // Payment not completed: No PIN entered or user canceled the transaction
        //         \Log::warning('Payment not completed (no PIN entered): ', $res);
        //         return redirect()->back()->withErrors(['payment_amount' => 'Payment was not completed. Please enter your PIN and try again.']);
        //     } else {
        //         // Other payment failure
        //         \Log::error('M-Pesa API Response Error: ', $res);
        //         return redirect()->back()->withErrors(['payment_amount' => 'M-Pesa payment failed.']);
        //     }
        // } catch (\Throwable $e) {
        //     \Log::error('STK Push Error: ' . $e->getMessage());
        //     return redirect()->back()->withErrors(['payment_amount' => 'Payment process failed.']);
         



        public function StkCallbackMain()
        {
            $data = file_get_contents('php://input');
            $response = json_decode($data, true);
        
            \Log::info('STK Push Callback:', $data);


            if (isset($response['Body']['stkCallback'])) {
                $callback = $response['Body']['stkCallback'];
                $ResultCode = $callback['ResultCode'];
                $CheckoutRequestID = $callback['CheckoutRequestID'];
        
                $payment = Stkrequest::where('CheckoutRequestID', $CheckoutRequestID)->first();
        
                if ($payment) {
                    if ($ResultCode == 0) {
                        // Successful payment
                        $payment->status = 'Paid';
                        $payment->MpesaReceiptNumber = $callback['CallbackMetadata']['Item'][1]['Value'];
                        $payment->TransactionDate = $callback['CallbackMetadata']['Item'][3]['Value'];
                        $payment->save();
        
                        // Update fee record
                        $student = Student::where('phone_number', $phoneNumber)->first();
                        if (!$student) {
                            \Log::error("Student not found for phone number: $phoneNumber");
                            return response()->json(['status' => 'failed', 'message' => 'Student not found']);
                        }
                        $fee = Fee::where('student_id', $student->id)->first();

                        if (!$fee) {
                            \Log::error("Fee not found for student: $student->id");
                            return response()->json(['status' => 'failed', 'message' => 'Fee record not found']);
                        }
                        $fee->payment_status = 'paid';  
                        $fee->paid_amount = $amountPaid; 
                        $fee->transaction_date = $transactionDate;
                        $fee->receipt_number = $receiptNumber; 
                        $fee->save();

                        Transaction::create([
                            'student_id' => $student->id,
                            'amount' => $amountPaid,
                            'transaction_date' => $transactionDate,
                            'receipt_number' => $receiptNumber,
                            'payment_status' => 'successful',
                            'payment_method' => 'M-Pesa', // Or whatever method you are using
                        ]);
                        return response()->json(['status' => 'success', 'message' => 'Payment processed successfully']);

                    } else {
                        // Payment failed
                        $payment->status = 'Failed';
                        $payment->ResultDesc = $callback['ResultDesc'];
                        $payment->save();
                    }
                }
            }
        }
        





            

    public function mainStkCallback()
    {
        $data=file_get_contents('php://input');
        $response=json_decode($data, true);
        $ResultCode=$response['Body']['stkCallback']['ResultCode'];
        if($ResultCode==0){
            $MerchantRequestID=$response['Body']['stkCallback']['MerchantRequestID'];
            $CheckoutRequestID=$response['Body']['stkCallback']['CheckoutRequestID'];
            $ResultDesc=$response['Body']['stkCallback']['ResultDesc'];
            $Amount=$response['Body']['stkCallback']['CallbackMetadata']['Item'][0]['Value'];
            $MpesaReceiptNumber=$response['Body']['stkCallback']['CallbackMetadata']['Item'][1]['Value'];
            //$Balance=$response['Body']['stkCallback']['CallbackMetadata']['Item'][2]['Value'];
            $TransactionDate=$response['Body']['stkCallback']['CallbackMetadata']['Item'][3]['Value'];
            $PhoneNumber=$response['Body']['stkCallback']['CallbackMetadata']['Item'][4]['Value'];
    
            $payment=Stkrequest::where('CheckoutRequestID',$CheckoutRequestID)->first();
            $payment->status='Paid';
            $payment->TransactionDate=$TransactionDate;
            $payment->MpesaReceiptNumber=$MpesaReceiptNumber;
            $payment->ResultDesc=$ResultDesc;
            $payment->save();








            
            //Database save my data and return back to  the index page






    
        }else{
    
        $CheckoutRequestID=$response['Body']['stkCallback']['CheckoutRequestID'];
        $ResultDesc=$response['Body']['stkCallback']['ResultDesc'];
        $payment=Stkrequest::where('CheckoutRequestID',$CheckoutRequestID)->first();
    
        $payment->ResultDesc=$ResultDesc;
        $payment->status='Failed';
        $payment->save();
        //Redirect to notify that payment was unsuccessful With a reason= result description;
        



        }
    }













    public function handle(Request $request)
    {
        // Log the callback data for debugging
        Log::debug('M-Pesa Callback Received:', $request->all());

        // Check the result code from the callback
        $resultCode = $request->input('Body.stkCallback.ResultCode');
        $resultDesc = $request->input('Body.stkCallback.ResultDesc');
        $metadata = $request->input('Body.stkCallback.CallbackMetadata');

        if ($resultCode == 0) {
            // Payment successful
            $amount = $metadata['Item'][0]['Value'];
            $transactionId = $metadata['Item'][1]['Value'];
            $phoneNumber = $metadata['Item'][4]['Value'];

            // Update the database
            // Implement your logic to update the fee record and log the transaction
            Log::info('Payment Successful:', compact('transactionId', 'amount', 'phoneNumber'));

            return response()->json(['success' => true]);
        } else {
            // Payment failed
            Log::error('Payment Failed:', compact('resultCode', 'resultDesc'));
            return response()->json(['success' => false, 'message' => $resultDesc]);
        }
    }






    
    private function calculateDiscount(Fee $fee)
    {
        // Add your discount logic here
        return 0; // Replace with actual logic
    }
    
    private function calculateFine(Fee $fee)
    {
        // Add your fine calculation logic here
        return 0; // Replace with actual logic
    }
    




public function store(Request $request)
{
   // dd($request->all());

     $validated = $request->validate([
            'consumer_key' => 'required|string|max:255',
            'consumer_secret' => 'required|string|max:255',
            'shortcode' => 'required|string|max:10',
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



    public function Feepaymentmpesa(Request $request)
    {
        $request->validate([
            'fee_id' => 'required',
            'student_id' => 'required',
            'amount' => 'required|numeric',
            'phone_number' => 'required',
        ]);
    
        // Retrieve the payment data
        $fee_id = $request->input('fee_id');
        $student_id = $request->input('student_id');
        $amount = $request->input('amount');
        $phone_number = $request->input('phone_number');
    
        // Call the M-Pesa payment API or service here to initiate the payment
    
        // Example of initiating an M-Pesa payment request using a service class
        $mpesaService = new MpesaPaymentService();
        $response = $mpesaService->initiatePayment($phone_number, $amount);
    
        if ($response->isSuccessful()) {
            // Handle success (e.g., update payment status in the database)
            return redirect()->route('payment.success')->with('message', 'Payment was successful.');
        } else {
            // Handle failure
            return redirect()->route('payment.failure')->with('error', 'Payment failed. Please try again.');
        }
    }
    
    
    private function normalizePhoneNumber($phone)
    {
        // Remove non-numeric characters
        $phone = preg_replace('/\D/', '', $phone);
    
        // If the phone starts with "0", replace it with "254"
        if (strpos($phone, '0') === 0) {
            $phone = '254' . substr($phone, 1);
        }
    
        return $phone;
    }

    public function initiatePayment($phone_number, $amount)
    {
        // Setup M-Pesa API credentials, endpoint, etc.
        $apiCredentials = $this->getApiCredentials();
        $endpoint = 'https://api.safaricom.co.ke/mpesa/express/v1/';

        // Send the payment request using the API credentials and phone number
        $response = $this->sendPaymentRequest($phone_number, $amount, $apiCredentials, $endpoint);

        // Process the response from M-Pesa
        if ($response->status === 'Success') {
            return true;
        }

        return false;
    }

    private function sendPaymentRequest($phone_number, $amount, $credentials, $endpoint)
    {
        // Implement the logic to call M-Pesa API using cURL, Guzzle, or any other HTTP client
        // Return the response
    }

    private function getApiCredentials()
    {
        // Fetch and return M-Pesa API credentials (e.g., from environment variables or configuration files)
        return [
            'api_key' => env('MPESA_API_KEY'),
            'api_secret' => env('MPESA_API_SECRET'),
        ];
    }

    





    public function showPaymentForm($fee_id)
{
    // Fetch the fee details from the database
    $fee = Fee::find($fee_id);

    // If the fee doesn't exist, handle the error
    if (!$fee) {
        return redirect()->route('fees.index')->with('error', 'Fee not found');
    }

    // Calculate the discount amount
    $discount_amount = 0;
    $amount = $fee->fee_amount;
    $today = date('Y-m-d');
    
    if (isset($fee->category)) {
        foreach ($fee->category->discounts->where('status', '1') as $discount) {
            $availability = \App\Models\FeesDiscount::availability($discount->id, $fee->studentEnroll->student_id);
            if (isset($availability) && $discount->start_date <= $today && $discount->end_date >= $today) {
                if ($discount->type == '1') {
                    $discount_amount += $discount->amount;
                } else {
                    $discount_amount += ($fee->fee_amount / 100) * $discount->amount;
                }
            }
        }
    }

    // Calculate the final amount after discount
    $final_amount = $amount - $discount_amount;

    // Pass the necessary data to the view
    return view('payment.form', compact('fee', 'final_amount', 'discount_amount'));
}



public function processPayment(Request $request, $fee_id)
{
    // Validate the payment input
    $validated = $request->validate([
        'paid_amount' => 'required|numeric|min:0',
    ]);

    // Fetch the fee using the fee_id
    $fee = Fee::find($fee_id);

    if (!$fee) {
        return redirect()->route('fees.index')->with('error', 'Fee not found');
    }

    // Here, you can process the payment logic with the provided amount and fee details
    // For example, deduct the paid amount from the outstanding fee amount

    // Update the fee record with the paid amount
    $fee->paid_amount = $fee->paid_amount + $validated['paid_amount'];
    $fee->save();

    // Redirect to a success page or payment confirmation view
    return redirect()->route('payment.success', ['fee_id' => $fee_id])->with('success', 'Payment successfully processed.');
}


public function paymentSuccess($fee_id)
{
    // Retrieve the fee record to show the payment details
    $fee = Fee::find($fee_id);

    if (!$fee) {
        return redirect()->route('fees.index')->with('error', 'Fee not found');
    }

    // Return the success view with the fee data
    return view('payment.success', compact('fee'));
}


}
