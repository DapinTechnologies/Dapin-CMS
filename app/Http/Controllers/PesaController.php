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
use Auth;
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

public function Feepaymentmpesa(Request $request, $feeId)
{
    try {
        // Get all parameters from query string
        $queryData = [
            'student_id' => $request->get('student_id'),
            'fee_category_id' => $request->get('fee_category_id'),
            'due_date' => $request->get('due_date'),
            'fee_amount' => $request->get('fee_amount'),
            'paid_amount' => $request->get('paid_amount'),
            'phone_number' => $request->get('phone_number'),
        ];

        // Validate required parameters
        if (!$feeId || !$queryData['student_id']) {
            return redirect()->route('student.fees.index')->with('error', 'Required payment data is missing');
        }

        // Verify the fee exists
        $fee = Fee::find($feeId);
        if (!$fee) {
            return redirect()->route('student.fees.index')->with('error', 'Fee not found');
        }

        // Get fee category title
        $feeCategory = FeesCategory::find($queryData['fee_category_id']);
        $feeCategoryTitle = $feeCategory ? $feeCategory->title : '';

        // Calculate balance
        $balance = max(0, $queryData['fee_amount'] - $queryData['paid_amount']);

        // Fetch bank and PayBill details
        $bankDetails = BankMpesaDetails::first();
        $paybill = PaybillDetail::first();

        // Pass all data to the view
        return view('student.fees.mpesa_payment', [
            'feeId' => $feeId,
            'studentId' => $queryData['student_id'],
            'feeCategoryId' => $queryData['fee_category_id'],
            'dueDate' => $queryData['due_date'],
            'feeAmount' => $queryData['fee_amount'],
            'paidAmount' => $queryData['paid_amount'],
            'phoneNumber' => $queryData['phone_number'],
            'fee' => $fee,
            'balance' => $balance,
            'feeCategoryTitle' => $feeCategoryTitle,
            'formData' => $queryData,
            'bankDetails' => $bankDetails,
            'paybill' => $paybill
        ]);

    } catch (\Exception $e) {
        Log::error('Feepaymentmpesa error: ' . $e->getMessage());
        return redirect()->route('student.fees.index')->with('error', 'Error loading payment page: ' . $e->getMessage());
    }
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

        $response = Http::withHeaders([
            'Authorization' => 'Basic ' . $credentials,
        ])->withOptions(['verify' => false])
        ->get("https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials");

        if (!$response->successful() || !isset($response->json()['access_token'])) {
            throw new \Exception('Failed to get M-Pesa access token.');
        }

        return $response->json()['access_token'];
    }

    public function process($id, Request $request)
{
    // Determine if this is a fee ID or invoice ID
    $fee = Fee::with('category')->find($id);
    $invoice = null;
    
    if ($fee) {
        // It's a fee ID
        if ($fee->fee_amount == 0) {
            // Try to find related invoice
            $invoice = \App\Models\Invoice::where('student_enroll_id', $fee->student_enroll_id)
                ->whereHas('fees', function($q) use ($fee) {
                    $q->where('fees.id', $fee->id);
                })->first();
        }
    } else {
        // It's an invoice ID
        $invoice = \App\Models\Invoice::with('fees.category')->find($id);
        if ($invoice) {
            // Use the first fee for category info
            $fee = $invoice->fees->first() ?? new Fee();
            $fee->category = $fee->category ?? (object)['title' => 'Invoice Payment'];
        }
    }

    if (!$fee && !$invoice) {
        return redirect()->route('student.fees.index')->with('error', 'Record not found.');
    }

    // Calculate amounts
    if ($invoice) {
        $feeAmount = $invoice->total_fee;
        $paidAmount = $invoice->payments->sum('amount') ?? 0;
    } else {
        $feeAmount = $fee->fee_amount;
        $paidAmount = $fee->paid_amount;
        
        // If fee amounts are 0 but we have a category with amount
        if ($feeAmount == 0 && $fee->category && $fee->category->amount > 0) {
            $feeAmount = $fee->category->amount;
        }
    }

    $balance = max(0, $feeAmount - $paidAmount);

    return view('student.fees.mpesa_payment', [
        'fee' => $fee,
        'feeAmount' => $feeAmount,
        'paidAmount' => $paidAmount,
        'balance' => $balance,
        'bankDetails' => BankMpesaDetails::first(),
        'paybill' => PaybillDetail::first(),
        'setting' => \App\Models\Setting::first(),
        'isInvoice' => !is_null($invoice)
    ]);
}


public function getMpesaAccessToken($consumerKey, $consumerSecret)
{
    \Log::info('=== ACCESS TOKEN DEBUG START ===');
    \Log::info('Attempting to get access token with:', [
        'consumer_key' => $consumerKey ? 'SET' : 'MISSING',
        'consumer_secret' => $consumerSecret ? 'SET' : 'MISSING',
        'token_url' => 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials'
    ]);

    $tokenUrl = 'https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials';
    
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $tokenUrl);
    $credentials = base64_encode($consumerKey . ':' . $consumerSecret);
    
    \Log::info('Base64 credentials length:', ['length' => strlen($credentials)]);
    
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Authorization: Basic ' . $credentials]);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
    curl_setopt($curl, CURLOPT_VERBOSE, true); // Enable verbose output

    $response = curl_exec($curl);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $curlError = curl_error($curl);
    
    curl_close($curl);

    \Log::info('Access token response:', [
        'http_code' => $httpCode,
        'curl_error' => $curlError,
        'response' => $response
    ]);

    $data = json_decode($response, true);
    
    \Log::info('Parsed response data:', ['data' => $data]);
    \Log::info('=== ACCESS TOKEN DEBUG END ===');

    return $data['access_token'] ?? null;
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

        return json_decode($response);
    }

   public function initiatePush(Request $request)
{
    \Log::info('=== INITIATE PUSH DEBUG START ===');
    
    $request->validate([
        'phone_number' => 'required|numeric',
        'payment_amount' => 'required|numeric|min:1',
        'fee_id' => 'required|exists:fees,id',
    ]);

    \Log::info('Form validation passed', $request->all());

    $fee = Fee::with('studentEnroll.student')->findOrFail($request->fee_id);
    $phone = $this->formatPhoneNumber($request->phone_number);
    $amount = $request->payment_amount;

    if (!$phone) {
        \Log::error('Invalid phone format', ['phone' => $request->phone_number]);
        return redirect()->route('student.fees.index')->with('error', 'Invalid phone format. Use 2547XXXXXXXX');
    }

    // Get M-Pesa credentials
    $mpesaSettings = MpesaSetting::first();
    
    $consumerKey = null;
    $consumerSecret = null;
    $businessShortCode = null;
    $passkey = null;

    if ($mpesaSettings && 
        !empty($mpesaSettings->consumer_key) && 
        !empty($mpesaSettings->consumer_secret) &&
        !empty($mpesaSettings->shortcode) &&
        !empty($mpesaSettings->passkey)) {
        
        $consumerKey = $mpesaSettings->consumer_key;
        $consumerSecret = $mpesaSettings->consumer_secret;
        $businessShortCode = $mpesaSettings->shortcode;
        $passkey = $mpesaSettings->passkey;
        
        \Log::info('Using M-Pesa credentials from database');
        
    } else {
        $consumerKey = env('MPESA_CONSUMER_KEY_SANDBOX');
        $consumerSecret = env('MPESA_CONSUMER_SECRET_SANDBOX');
        $businessShortCode = env('MPESA_SHORT_CODE_SANDBOX', '174379');
        $passkey = env('MPESA_PASS_KEY_SANDBOX');
        
        \Log::info('Using M-Pesa credentials from environment variables');
    }

    if (empty($consumerKey) || empty($consumerSecret) || empty($businessShortCode) || empty($passkey)) {
        \Log::error('M-Pesa credentials missing');
        return redirect()->route('student.fees.index')->with('error', 'M-Pesa credentials not configured. Please contact administrator.');
    }

    \Log::info('M-Pesa credentials obtained');
    
    $timestamp = Carbon::now()->format('YmdHis');
    $password = base64_encode($businessShortCode . $passkey . $timestamp);
    $callbackUrl = $this->app_url . '/mpesa/callback';

    \Log::info('STK Push parameters:', [
        'shortcode' => $businessShortCode,
        'amount' => $amount,
        'phone' => $phone,
        'callback_url' => $callbackUrl
    ]);

    // Get access token
    $token = $this->getMpesaAccessToken($consumerKey, $consumerSecret);
    if (!$token) {
        \Log::error('Failed to get access token');
        return redirect()->route('student.fees.index')->with('error', 'Failed to get access token. Please check your M-Pesa credentials.');
    }

    \Log::info('Access token obtained successfully');

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

    \Log::info('STK Push response:', ['response' => $stkResponse]);

    // Handle STK Push response
    if (isset($stkResponse->CheckoutRequestID)) {
        DB::beginTransaction();
        try {
            // Create Transaction record
            $transactionData = [
                'transaction_id' => Str::uuid(),
                'amount' => $amount,
                'type' => 'mpesa_stk',
                'status' => 'pending',
                'student_id' => $fee->studentEnroll->student->id,
                'fee_id' => $fee->id,
                'CheckoutRequestID' => $stkResponse->CheckoutRequestID,
                'MerchantRequestID' => $stkResponse->MerchantRequestID,
                'phone_number' => $phone,
                'created_by' => Auth::id(),
            ];

            $transaction = Transaction::create($transactionData);

            // Create STK request record
            $stkData = [
                'MerchantRequestID' => $stkResponse->MerchantRequestID,
                'CheckoutRequestID' => $stkResponse->CheckoutRequestID,
                'ResultCode' => $stkResponse->ResponseCode ?? '0',
                'ResultDesc' => $stkResponse->CustomerMessage ?? 'STK Push initiated',
                'Amount' => $amount,
                'AccountReference' => 'Fee Payment',
                'TransactionDesc' => 'Fee Payment',
                'status' => 'Requested',
                'phone_number' => $phone,
                'student_id' => $fee->studentEnroll->student->id,
                'Date_payment' => now()->format('Y-m-d'),
                'fee_id' => $fee->id,
                'fee_category' => $fee->category->title ?? 'Exam Fees',
                'payment_amount' => $amount,
            ];

            // Add optional fields if they exist
            if (isset($stkResponse->MpesaReceiptNumber)) {
                $stkData['MpesaReceiptNumber'] = $stkResponse->MpesaReceiptNumber;
            }
            if (isset($stkResponse->TransactionDate)) {
                $stkData['TransactionDate'] = $stkResponse->TransactionDate;
            }

            Stkrequest::create($stkData);

            DB::commit();
            
            \Log::info('Payment initiated successfully', [
                'checkout_request_id' => $stkResponse->CheckoutRequestID,
                'transaction_id' => $transaction->id
            ]);
            
            // SUCCESS: Redirect to index page with success message
            return redirect()->route('student.fees.index')->with('success', 'Payment request sent successfully! Check your phone to complete the payment.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Payment initiation failed: ' . $e->getMessage());
            \Log::error('Error details:', [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            
            // ERROR: Redirect to index page with error message
            return redirect()->route('student.fees.index')->with('error', 'Failed to initiate payment: ' . $e->getMessage());
        }
    } else {
        \Log::error('STK Push failed', ['response' => $stkResponse]);
        $errorMessage = $stkResponse->errorMessage ?? ($stkResponse->ResponseDescription ?? 'Payment initiation failed');
        
        // STK PUSH FAILED: Redirect to index page with error message
        return redirect()->route('student.fees.index')->with('error', $errorMessage);
    }
}



public function handleMpesaCallback(Request $request)
{
    \Log::info('=== MPESA CALLBACK START ===');
    \Log::info('Callback data:', $request->all());

    $callbackData = $request->all();
    
    DB::beginTransaction();
    try {
        // Find the STK request by CheckoutRequestID
        $stkRequest = Stkrequest::where('CheckoutRequestID', $callbackData['Body']['stkCallback']['CheckoutRequestID'])->first();
        
        if (!$stkRequest) {
            \Log::error('STK request not found', ['CheckoutRequestID' => $callbackData['Body']['stkCallback']['CheckoutRequestID']]);
            DB::rollBack();
            return response()->json(['ResultCode' => 1, 'ResultDesc' => 'STK request not found']);
        }

        $callbackResult = $callbackData['Body']['stkCallback']['ResultCode'];
        
        if ($callbackResult == 0) {
            // Payment was successful
            $callbackMetadata = $callbackData['Body']['stkCallback']['CallbackMetadata']['Item'];
            
            $amount = 0;
            $mpesaReceiptNumber = '';
            $transactionDate = '';
            $phoneNumber = '';

            foreach ($callbackMetadata as $item) {
                if ($item['Name'] == 'Amount') $amount = $item['Value'];
                if ($item['Name'] == 'MpesaReceiptNumber') $mpesaReceiptNumber = $item['Value'];
                if ($item['Name'] == 'TransactionDate') $transactionDate = $item['Value'];
                if ($item['Name'] == 'PhoneNumber') $phoneNumber = $item['Value'];
            }

            // Update STK request
            $stkRequest->update([
                'ResultCode' => $callbackResult,
                'ResultDesc' => 'Payment completed successfully',
                'MpesaReceiptNumber' => $mpesaReceiptNumber,
                'TransactionDate' => $transactionDate,
                'status' => 'Completed'
            ]);

            // Update Transaction record
            $transaction = Transaction::where('CheckoutRequestID', $stkRequest->CheckoutRequestID)->first();
            if ($transaction) {
                $transaction->update([
                    'status' => 'completed',
                    'mpesa_receipt_number' => $mpesaReceiptNumber
                ]);
            }

            // CREATE PAYMENT RECORD - This is what deducts from the fee
            $this->createPaymentRecord($stkRequest, $amount, $mpesaReceiptNumber, $transactionDate);

            \Log::info('Payment processed successfully', [
                'receipt' => $mpesaReceiptNumber,
                'amount' => $amount,
                'student_id' => $stkRequest->student_id
            ]);

        } else {
            // Payment failed
            $stkRequest->update([
                'ResultCode' => $callbackResult,
                'ResultDesc' => $callbackData['Body']['stkCallback']['ResultDesc'],
                'status' => 'Failed'
            ]);

            // Update transaction status
            $transaction = Transaction::where('CheckoutRequestID', $stkRequest->CheckoutRequestID)->first();
            if ($transaction) {
                $transaction->update(['status' => 'failed']);
            }

            \Log::error('Payment failed', [
                'result_code' => $callbackResult,
                'result_desc' => $callbackData['Body']['stkCallback']['ResultDesc']
            ]);
        }

        DB::commit();
        return response()->json(['ResultCode' => 0, 'ResultDesc' => 'Success']);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Callback processing failed: ' . $e->getMessage());
        return response()->json(['ResultCode' => 1, 'ResultDesc' => 'Error processing callback']);
    }
}



private function createPaymentRecord($stkRequest, $amount, $mpesaReceiptNumber, $transactionDate)
{
    try {
        // Find the student enroll record
        $studentEnroll = StudentEnroll::where('student_id', $stkRequest->student_id)
            ->latest()
            ->first();

        if (!$studentEnroll) {
            \Log::error('Student enroll record not found', ['student_id' => $stkRequest->student_id]);
            return false;
        }

        // Find or create an invoice for this fee
        $invoice = Invoice::where('student_enroll_id', $studentEnroll->id)
            ->where('fee_id', $stkRequest->fee_id)
            ->where('status', '!=', Invoice::STATUS_PAID)
            ->first();

        if (!$invoice) {
            // Create a new invoice if one doesn't exist
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . time() . '-' . $stkRequest->student_id,
                'student_enroll_id' => $studentEnroll->id,
                'fee_id' => $stkRequest->fee_id,
                'amount' => $stkRequest->payment_amount,
                'due_date' => now()->addDays(30),
                'status' => Invoice::STATUS_PENDING,
                'created_by' => auth()->id() ?? 1,
            ]);
        }

        // Create the payment record
        $payment = Payment::create([
            'invoice_id' => $invoice->id,
            'student_enroll_id' => $studentEnroll->id,
            'amount' => $amount,
            'payment_method' => 'mpesa',
            'reference_number' => $mpesaReceiptNumber,
            'payment_date' => now(),
            'status' => Payment::STATUS_COMPLETED,
            'transaction_id' => $mpesaReceiptNumber,
            'paid_at' => now(),
            'notes' => 'M-Pesa STK Push payment - ' . $stkRequest->fee_category,
        ]);

        // Create fee payment record to track which fee was paid
        FeePayment::create([
            'payment_id' => $payment->id,
            'fee_id' => $stkRequest->fee_id,
            'amount' => $amount,
            'student_enroll_id' => $studentEnroll->id,
        ]);

        // Update invoice status based on payment
        $this->updateInvoiceStatus($invoice, $amount);

        // Update fee balance
        $this->updateFeeBalance($stkRequest->fee_id, $studentEnroll->id, $amount);

        \Log::info('Payment record created successfully', [
            'payment_id' => $payment->id,
            'invoice_id' => $invoice->id,
            'amount' => $amount
        ]);

        return true;

    } catch (\Exception $e) {
        \Log::error('Failed to create payment record: ' . $e->getMessage());
        return false;
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
    }

    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'consumer_key' => 'required|string|max:255',
            'consumer_secret' => 'required|string|max:255',
            'shortcode' => 'required|string|max:10',
            'passkey' => 'required|string|max:255',
            'bank_name' => 'required|string|max:255',
            'bank_account' => 'required|string|max:255',
            'bank_branch' => 'required|string|max:255',
            'paybill_number' => 'required|string|max:10',
            'paybill_account' => 'required|string|max:255',
        ]);

        // Update or create MpesaSetting
        MpesaSetting::updateOrCreate(
            ['id' => 1],
            [
                'consumer_key' => $validated['consumer_key'],
                'consumer_secret' => $validated['consumer_secret'],
                'shortcode' => $validated['shortcode'],
                'passkey' => $validated['passkey'],
            ]
        );

        // Update or create BankMpesaDetails
        BankMpesaDetails::updateOrCreate(
            ['id' => 1],
            [
                'bank_name' => $validated['bank_name'],
                'bank_account' => $validated['bank_account'],
                'bank_branch' => $validated['bank_branch'],
            ]
        );

        // Update or create PaybillDetail
        PaybillDetail::updateOrCreate(
            ['id' => 1],
            [
                'paybill_number' => $validated['paybill_number'],
                'paybill_account' => $validated['paybill_account'],
            ]
        );

        return redirect()->back()->with('success', 'Settings have been successfully saved!');
    }

    public function index()
    {
        $title = 'Payment Gateway';
        $access = 'sms';
        $rows= 'row';
  
        $mpesaSettings = MpesaSetting::first();
        $bankDetails = BankMpesaDetails::first();
        $paybillDetails = PaybillDetail::first();
    
        return view('admin.payment-setting.index', compact('mpesaSettings', 'bankDetails', 'paybillDetails'));
    }
}