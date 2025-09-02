<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StudentEnroll;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\FeesDiscount;
use App\Models\FeesFine;
use Toastr;
use DB;

class FeesAdjustmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_fees_adjustment', 1);
        $this->route = 'admin.fees-adjustment';
        $this->view = 'admin.fees-adjustment';
        $this->path = 'fees-adjustment';
        $this->access = 'fees-adjustment';

        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
    }

    /**
     * Format phone number for SMS
     */
    private function formatPhoneNumberForSms($phone)
    {
        // Remove any non-digit characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If starts with 0, replace with country code (assuming Kenya)
        if (strlen($phone) == 9 && $phone[0] == '0') {
            $phone = '254' . substr($phone, 1);
        }
        
        // If starts with 7 or 1 and is 9 digits, add 254
        if (strlen($phone) == 9 && in_array($phone[0], ['7', '1'])) {
            $phone = '254' . $phone;
        }
        
        return $phone;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        // Get active students with their unpaid invoices
        $data['students'] = StudentEnroll::where('status', '1')
            ->with(['student', 'invoices' => function($query) {
                $query->where('payment_status', '!=', '2'); // Not fully paid
            }])
            ->whereHas('student', function ($query) {
                $query->where('status', '1');
            })
            ->orderBy('student_id', 'asc')
            ->get();

        // Get all active discounts
        $data['discounts'] = FeesDiscount::where('status', '1')
            ->where('start_date', '<=', date('Y-m-d'))
            ->where('end_date', '>=', date('Y-m-d'))
            ->get();

        // Get all active fines
        $data['fines'] = FeesFine::where('status', '1')->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Apply adjustment to student invoice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    // Convert checkbox value to proper boolean before validation
    $request->merge([
        'send_sms' => $request->has('send_sms'),
    ]);

    // Field Validation
    $request->validate([
        'student_id' => 'required|exists:student_enrolls,id',
        'invoice_id' => 'required|exists:invoices,id',
        'type' => 'required|in:discount,fine,adjustment',
        'adjustment_id' => 'nullable',
        'amount' => 'required|numeric|min:0',
        'notes' => 'nullable|string',
        'send_sms' => 'nullable|boolean',
        'adjustment_operation' => 'required_if:type,adjustment|in:add,deduct',
    ]);

    DB::beginTransaction();

    try {
        $invoice = Invoice::findOrFail($request->invoice_id);
        $student = StudentEnroll::findOrFail($request->student_id)->student;

        // Get current payment totals (including both cash and bursary payments)
        $totalCashPaid = Payment::where('invoice_id', $invoice->id)
                         ->where('is_bursary', 0)
                         ->sum('amount');
                         
        $totalBursaryPaid = Payment::where('invoice_id', $invoice->id)
                           ->where('is_bursary', 1)
                           ->sum('amount');

        // Calculate current amount due based on all payments
        $currentAmountDue = max(0, 
            $invoice->total_fee + $invoice->fine_amount - $invoice->discount_amount 
            - $totalCashPaid - $totalBursaryPaid
        );

        // Prevent adjustments if invoice is fully paid (amount due is 0)
        if ($currentAmountDue <= 0) {
            throw new \Exception("Cannot adjust invoice with zero due amount");
        }

        if ($request->type == 'discount') {
            $discount = FeesDiscount::findOrFail($request->adjustment_id);
            
            // Apply discount
            $invoice->discount_amount += $request->amount;
            $invoice->amount_due = max(0, 
                $invoice->total_fee + $invoice->fine_amount - $invoice->discount_amount 
                - $totalCashPaid - $totalBursaryPaid
            );
            $invoice->adjustment_type = 'discount';
            $invoice->adjustment_id = $discount->id;
            $invoice->adjustment_notes = $request->notes ?? "Applied discount: {$discount->title}";
            
            Toastr::success(__('Discount applied successfully'), __('msg_success'));

        } elseif ($request->type == 'fine') {
            $fine = FeesFine::findOrFail($request->adjustment_id);
            
            // Apply fine
            $invoice->fine_amount += $request->amount;
            $invoice->amount_due = max(0, 
                $invoice->total_fee + $invoice->fine_amount - $invoice->discount_amount 
                - $totalCashPaid - $totalBursaryPaid
            );
            $invoice->adjustment_type = 'fine';
            $invoice->adjustment_id = $fine->id;
            $invoice->adjustment_notes = $request->notes ?? "Applied fine: {$fine->title}";
            
            Toastr::success(__('Fine applied successfully'), __('msg_success'));
            
        } elseif ($request->type == 'adjustment') {
            // Apply manual adjustment
            if ($request->adjustment_operation == 'add') {
                $invoice->fine_amount += $request->amount;
                $invoice->adjustment_notes = $request->notes ?? "Added adjustment: {$request->amount}";
            } else {
                $invoice->discount_amount += $request->amount;
                $invoice->adjustment_notes = $request->notes ?? "Deducted adjustment: {$request->amount}";
            }
            
            $invoice->amount_due = max(0, 
                $invoice->total_fee + $invoice->fine_amount - $invoice->discount_amount 
                - $totalCashPaid - $totalBursaryPaid
            );
            $invoice->adjustment_type = 'manual';
            
            Toastr::success(__('Adjustment applied successfully'), __('msg_success'));
        }

        // Update payment status based on amount due
        if ($invoice->amount_due <= 0) {
            $invoice->payment_status = '2'; // Fully paid
        } elseif ($totalCashPaid > 0 || $totalBursaryPaid > 0) {
            $invoice->payment_status = '1'; // Partially paid
        } else {
            $invoice->payment_status = '0'; // Unpaid
        }
        
        // Update the paid amounts in the invoice from payment records
        $invoice->amount_paid = $totalCashPaid;
        $invoice->bursary_allocated = $totalBursaryPaid;
        $invoice->save();

        // Send SMS notification if enabled
        if ($request->boolean('send_sms')) {
            $this->sendSmsNotification($student, $invoice);
        }

        DB::commit();
        return redirect()->back();

    } catch (\Exception $e) {
        DB::rollBack();
        Toastr::error($e->getMessage(), __('msg_error'));
        return redirect()->back();
    }
}

    /**
     * Send SMS notification to student
     */
    private function sendSmsNotification($student, $invoice)
    {
        $apiUrl = 'https://smsportal.dapintechnologies.com/sms/v3/sendsms';
        $apiKey = '0CHxwhLRQ78MEFablqnsAtkgBNDjrJWou569KYpUd3eySPXT4ZOzv1cIiVG2mf';
        $serviceId = 0;
        $from = 'Dapin';

        if ($student && $student->phone) {
            $name = $student->first_name . ' ' . $student->last_name;
            $studentIdCode = $student->student_id;
            $totalAmount = number_format($invoice->amount_due, 2);

            $message = "Hi {$name}-{$studentIdCode}, kindly settle your outstanding fee balance of Ksh {$totalAmount}.";

            $payload = [
                'api_key' => $apiKey,
                'service_id' => $serviceId,
                'mobile' => $this->formatPhoneNumberForSms($student->phone),
                'response_type' => 'json',
                'shortcode' => $from,
                'message' => $message,
                'date_send' => now()->format('Y-m-d H:i:s'),
            ];

            try {
                $response = \Illuminate\Support\Facades\Http::withOptions(['verify' => false])
                    ->post($apiUrl, $payload);

                \Log::info('SMS API Response:', ['response' => $response->json()]);
            } catch (\Exception $e) {
                \Log::error('Exception sending SMS', ['error' => $e->getMessage()]);
            }
        }
    }

    /**
     * Get student's unpaid invoices via AJAX
     */
    public function getInvoices(Request $request)
    {
        $invoices = Invoice::where('student_enroll_id', $request->student_id)
            ->where('payment_status', '!=', '2') // Not fully paid
            ->get();

        return response()->json($invoices);
    }

    /**
     * Get invoice details via AJAX
     */
    public function getInvoiceDetails(Request $request)
    {
        $invoice = Invoice::findOrFail($request->invoice_id);
        return response()->json([
            'total_fee' => $invoice->total_fee,
            'amount_paid' => $invoice->amount_paid,
            'discount_amount' => $invoice->discount_amount,
            'fine_amount' => $invoice->fine_amount,
            'amount_due' => $invoice->amount_due,
            'adjustment_notes' => $invoice->adjustment_notes
        ]);
    }
}