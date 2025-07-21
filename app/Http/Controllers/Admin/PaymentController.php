<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\StudentEnroll;
use App\Models\Invoice;
use App\Models\FeesCategory;
use Toastr;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_payment', 1);
        $this->route = 'admin.payments';
        $this->view = 'admin.payments';
        $this->path = 'payments';
        $this->access = 'payments';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
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
        
        $data['rows'] = Payment::with(['studentEnroll.student', 'invoice'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $data['students'] = StudentEnroll::with('student')
            ->where('status', '1')
            ->get();

        return view($this->view.'.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['students'] = StudentEnroll::with(['student', 'batch', 'program'])
            ->where('status', '1')
            ->get();
            
        $data['categories'] = FeesCategory::where('status', '1')->get();

        return view($this->view.'.create', $data);
    }

    /**
     * Get student invoices via AJAX for payment selection
     */
    public function getStudentInvoices(Request $request)
    {
        $request->validate([
            'student_enroll_id' => 'required|exists:student_enrolls,id'
        ]);

        $studentEnrollId = $request->student_enroll_id;
        
        // Get all unpaid or partially paid invoices with fee details
        $invoices = Invoice::where('student_enroll_id', $studentEnrollId)
            ->whereIn('payment_status', ['unpaid', 'partial'])
            ->with(['fees.category'])
            ->get()
            ->map(function ($invoice) {
                return [
                    'id' => $invoice->id,
                    'invoice_no' => $invoice->invoice_no,
                    'assign_date' => $invoice->assign_date,
                    'due_date' => $invoice->due_date,
                    'total_fee' => $invoice->total_fee,
                    'amount_paid' => $invoice->amount_paid,
                    'amount_due' => $invoice->amount_due,
                    'payment_status' => $invoice->payment_status,
                    'status_class' => $this->getStatusClass($invoice->payment_status),
                    'formatted_assign_date' => Carbon::parse($invoice->assign_date)->format('d M Y'),
                    'formatted_due_date' => Carbon::parse($invoice->due_date)->format('d M Y'),
                    'formatted_total_fee' => number_format($invoice->total_fee, 2),
                    'formatted_amount_paid' => number_format($invoice->amount_paid, 2),
                    'formatted_amount_due' => number_format($invoice->amount_due, 2),
                ];
            });
            
        // Calculate totals
        $totalDue = $invoices->sum('amount_due');
        $totalPaid = $invoices->sum('amount_paid');
        $totalFee = $invoices->sum('total_fee');

        return response()->json([
            'success' => true,
            'invoices' => $invoices,
            'totals' => [
                'due' => $totalDue,
                'paid' => $totalPaid,
                'fee' => $totalFee,
                'formatted_due' => number_format($totalDue, 2),
                'formatted_paid' => number_format($totalPaid, 2),
                'formatted_fee' => number_format($totalFee, 2)
            ]
        ]);
    }

    private function getStatusClass($status)
    {
        switch($status) {
            case 'paid': return 'bg-success';
            case 'partial': return 'bg-warning text-dark';
            default: return 'bg-danger';
        }
    }

    /**
     * Store a newly created payment
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'student_enroll_id' => 'required|exists:student_enrolls,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:mpesa,bank,cash,cheque',
            'reference_number' => 'required_if:payment_method,mpesa,bank,cheque',
            'notes' => 'nullable|string|max:255',
            'invoice_ids' => 'required|string', // Comma-separated string from hidden field
            'mpesa_number' => 'required_if:payment_method,mpesa|nullable|string|max:20',
            'bank_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cheque_number' => 'required_if:payment_method,cheque|nullable|string|max:50',
            'cheque_bank' => 'required_if:payment_method,cheque|nullable|string|max:100',
            'cheque_branch' => 'required_if:payment_method,cheque|nullable|string|max:100',
            'cheque_date' => 'required_if:payment_method,cheque|nullable|date',
            'cheque_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Convert comma-separated string to array
        $invoiceIds = explode(',', $request->invoice_ids);
        
        // Create transaction ID
        $transactionId = 'TXN-' . Str::upper(Str::random(10));
        
        // Process payment
        $amountToDistribute = $request->amount;
        $processedInvoices = [];
        
        foreach ($invoiceIds as $invoiceId) {
            if ($amountToDistribute <= 0) break;
            
            $invoice = Invoice::find($invoiceId);
            if (!$invoice) continue;
            
            $invoiceDue = $invoice->amount_due;
            $amountToPay = min($invoiceDue, $amountToDistribute);
            
            $payment = new Payment();
            $payment->invoice_id = $invoiceId;
            $payment->student_enroll_id = $request->student_enroll_id;
            $payment->amount = $amountToPay;
            $payment->payment_method = $request->payment_method;
            $payment->reference_number = $request->reference_number;
            
            // Store method-specific fields
            if ($request->payment_method == 'mpesa') {
                $payment->mpesa_number = $request->mpesa_number;
            } elseif ($request->payment_method == 'cheque') {
                $payment->cheque_number = $request->cheque_number;
                $payment->cheque_bank = $request->cheque_bank;
                $payment->cheque_branch = $request->cheque_branch;
                $payment->cheque_date = $request->cheque_date;
            }
            
            $payment->status = 'completed';
            $payment->transaction_id = $transactionId;
            $payment->notes = $request->notes;
            $payment->paid_at = now();
            $payment->save();
            
            // Update invoice
            $invoice->amount_paid += $amountToPay;
            $invoice->amount_due = $invoice->total_fee - $invoice->amount_paid;
            $invoice->payment_status = $invoice->amount_due <= 0 ? 'paid' : 'partial';
            $payment->invoice()->associate($invoice);
            $invoice->save();
            
            $processedInvoices[] = $invoiceId;
            $amountToDistribute -= $amountToPay;
        }
        
        // Handle remaining amount (if any)
        if ($amountToDistribute > 0) {
            $payment = new Payment();
            $payment->student_enroll_id = $request->student_enroll_id;
            $payment->amount = $amountToDistribute;
            $payment->payment_method = $request->payment_method;
            $payment->reference_number = $request->reference_number;
            $payment->status = 'completed';
            $payment->transaction_id = $transactionId;
            $payment->notes = $request->notes ? $request->notes . ' (Excess payment)' : 'Excess payment';
            $payment->paid_at = now();
            $payment->save();
        }

        // Handle file uploads
        if ($request->hasFile('bank_slip')) {
            $this->uploadBankSlip($request, $transactionId);
        }
        
        if ($request->hasFile('cheque_image')) {
            $this->uploadChequeImage($request, $transactionId);
        }

        Toastr::success(__('Payment recorded successfully'), __('Success'));

        return redirect()->route($this->route.'.receipt', Payment::where('transaction_id', $transactionId)->first()->id);
    }

    private function uploadBankSlip($request, $transactionId)
    {
        $file = $request->file('bank_slip');
        $filename = 'bank-slip-' . $transactionId . '.' . $file->getClientOriginalExtension();
        
        // Store in storage/app/public/payments/bank-slips
        $path = $file->storeAs('payments/bank-slips', $filename, 'public');
        
        // Update all payments with this transaction ID
        Payment::where('transaction_id', $transactionId)
            ->update(['bank_slip_path' => $path]);
    }

    private function uploadChequeImage($request, $transactionId)
    {
        $file = $request->file('cheque_image');
        $filename = 'cheque-' . $transactionId . '.' . $file->getClientOriginalExtension();
        
        // Store in storage/app/public/payments/cheques
        $path = $file->storeAs('payments/cheques', $filename, 'public');
        
        // Update all payments with this transaction ID
        Payment::where('transaction_id', $transactionId)
            ->update(['cheque_image_path' => $path]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['row'] = $payment->load(['studentEnroll.student', 'invoice.fees.category']);

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['students'] = StudentEnroll::with('student')->where('status', '1')->get();
        $data['invoices'] = Invoice::where('student_enroll_id', $payment->student_enroll_id)->get();
        $data['categories'] = FeesCategory::where('status', '1')->get();
        $data['row'] = $payment;

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'student_enroll_id' => 'required|exists:student_enrolls,id',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|in:mpesa,bank,cash,cheque',
            'reference_number' => 'required_if:payment_method,mpesa,bank,cheque',
            'notes' => 'nullable|string|max:255',
            'invoice_id' => 'nullable|exists:invoices,id',
            'category_id' => 'nullable|exists:fees_categories,id',
            'mpesa_number' => 'required_if:payment_method,mpesa|nullable|string|max:20',
            'bank_slip' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'cheque_number' => 'required_if:payment_method,cheque|nullable|string|max:50',
            'cheque_bank' => 'required_if:payment_method,cheque|nullable|string|max:100',
            'cheque_branch' => 'required_if:payment_method,cheque|nullable|string|max:100',
            'cheque_date' => 'required_if:payment_method,cheque|nullable|date',
            'cheque_image' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update Data
        $payment = Payment::findOrFail($id);
        
        // Calculate amount difference if invoice is changed
        $amount_diff = $request->amount - $payment->amount;
        
        $payment->invoice_id = $request->invoice_id;
        $payment->student_enroll_id = $request->student_enroll_id;
        $payment->amount = $request->amount;
        $payment->payment_method = $request->payment_method;
        $payment->reference_number = $request->reference_number;
        
        // Update method-specific fields
        if ($request->payment_method == 'mpesa') {
            $payment->mpesa_number = $request->mpesa_number;
        } elseif ($request->payment_method == 'cheque') {
            $payment->cheque_number = $request->cheque_number;
            $payment->cheque_bank = $request->cheque_bank;
            $payment->cheque_branch = $request->cheque_branch;
            $payment->cheque_date = $request->cheque_date;
        }
        
        $payment->notes = $request->notes;
        $payment->save();

        // Handle file uploads
        if ($request->hasFile('bank_slip')) {
            $this->uploadBankSlip($request, $payment->transaction_id);
        }
        
        if ($request->hasFile('cheque_image')) {
            $this->uploadChequeImage($request, $payment->transaction_id);
        }

        // Update invoice if specified
        if ($payment->invoice_id) {
            $invoice = Invoice::find($payment->invoice_id);
            $invoice->amount_paid += $amount_diff;
            $invoice->amount_due = $invoice->total_fee - $invoice->amount_paid;
            $invoice->payment_status = $invoice->amount_due <= 0 ? 'paid' : 'partial';
            $invoice->save();
        }

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Data
        $payment = Payment::findOrFail($id);
        
        // Update invoice if exists
        if ($payment->invoice_id) {
            $invoice = Invoice::find($payment->invoice_id);
            $invoice->amount_paid -= $payment->amount;
            $invoice->amount_due = $invoice->total_fee - $invoice->amount_paid;
            $invoice->payment_status = $invoice->amount_paid <= 0 ? 'unpaid' : 'partial';
            $invoice->save();
        }
        
        $payment->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the payment receipt.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function receipt($id)
    {
        $data['title'] = __('module_payment_receipt');
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['row'] = Payment::with(['studentEnroll.student', 'invoice.fees.category'])
            ->findOrFail($id);

        return view($this->view.'.receipt', $data);
    }

    public function getFeeCategories(Request $request)
{
    $invoice = Invoice::find($request->invoice_id);
    
    if (!$invoice) {
        return response()->json([
            'success' => false,
            'message' => 'Invoice not found'
        ]);
    }

    // Get fees using the same logic from your Blade template
    $fees = $invoice->fees ?? Fee::where('invoice_id', $invoice->id)->get();
    
    if ($fees->isEmpty()) {
        $fees = Fee::where('student_enroll_id', $invoice->student_enroll_id)
            ->where('assign_date', $invoice->assign_date)
            ->where('due_date', $invoice->due_date)
            ->get();
    }

    // Generate category list HTML
    $categoryList = $fees->map(function($fee) {
        $categoryTitle = $fee->category->title ?? 'Category #' . $fee->category_id;
        $amount = number_format($fee->category->amount ?? $fee->amount, 2);
        
        return sprintf(
            '<div class="mb-1"><span class="badge badge-info">%s (%s)</span></div>',
            $categoryTitle,
            $amount
        );
    })->implode('');

    if ($fees->isEmpty()) {
        $categoryList = '<span class="text-danger">No fees assigned</span>';
    }

    return response()->json([
        'success' => true,
        'categoryList' => $categoryList,
        'fees' => $fees->map(function($fee) {
            return [
                'category_id' => $fee->category_id,
                'category_title' => $fee->category->title ?? null,
                'amount' => $fee->amount,
                'paid_amount' => $fee->paid_amount
            ];
        })
    ]);
}
}