<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Invoice;
use App\Models\StudentEnroll;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\BursaryType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Excel;
use App\Exports\BursaryAllocationExport;
use DB;


class BursaryAllocationController extends Controller
{
    public function index(Request $request)
    {
        $bursaries = Payment::with(['invoice', 'studentEnroll.student', 'studentEnroll.program.faculty', 'bursaryType'])
            ->where('is_bursary', 1)
            ->when($request->filled('bursary_type'), function($query) use ($request) {
                $query->where('bursary_type', $request->bursary_type);
            })
            ->when($request->filled('faculty'), function($query) use ($request) {
                $query->whereHas('studentEnroll.program', function($q) use ($request) {
                    $q->where('faculty_id', $request->faculty);
                });
            })
            ->when($request->filled('program'), function($query) use ($request) {
                $query->whereHas('studentEnroll', function($q) use ($request) {
                    $q->where('program_id', $request->program);
                });
            })
            ->when($request->filled('search'), function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('reference_number', 'like', '%'.$request->search.'%')
                      ->orWhereHas('studentEnroll.student', function($q) use ($request) {
                          $q->where('name', 'like', '%'.$request->search.'%')
                            ->orWhere('student_id', 'like', '%'.$request->search.'%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(25);

        $faculties = Faculty::all();
        $programs = Program::all();
        $bursaryTypes = BursaryType::where('is_active', 1)->get();
        $students = StudentEnroll::with(['student', 'program.faculty'])
            ->whereHas('invoices', function($q) {
                $q->where('amount_due', '>', 0);
            })
            ->get();

        return view('admin.bursary-allocation.index', [
            'bursaries' => $bursaries,
            'faculties' => $faculties,
            'programs' => $programs,
            'bursaryTypes' => $bursaryTypes,
            'students' => $students,
            'selected_faculty' => $request->faculty ?? 0,
            'selected_program' => $request->program ?? 0,
            'selected_bursary_type' => $request->bursary_type ?? '',
            'search_term' => $request->search ?? '',
            'title' => 'Bursary Allocation Management',
            'route' => 'admin.bursary-allocation'
        ]);
    }

    public function create($student_enroll_id = null)
    {
        $studentEnroll = null;
        $invoices = collect();
        $bursaryTypes = BursaryType::where('is_active', 1)->get();

        if ($student_enroll_id) {
            $studentEnroll = StudentEnroll::with(['student', 'program.faculty', 'invoices'])->findOrFail($student_enroll_id);
            $invoices = $studentEnroll->invoices()->where('amount_due', '>', 0)->get();
        }

        return view('admin.bursary-allocation.create', [
            'studentEnroll' => $studentEnroll,
            'invoices' => $invoices,
            'bursaryTypes' => $bursaryTypes,
            'title' => 'Allocate New Bursary',
            'route' => 'admin.bursary-allocation'
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'invoice_id' => 'required|exists:invoices,id',
        'student_enroll_id' => 'required|exists:student_enrolls,id',
        'amount' => 'required|numeric|min:0.01',
        'bursary_type' => 'required|exists:bursary_types,code',
        'bursary_notes' => 'nullable|string|max:255',
        'payment_date' => 'required|date',
    ]);

    DB::beginTransaction();

    try {
        // Generate transaction IDs
        $receiptNo = 'BURS-' . strtoupper(Str::random(8));
        $transactionId = 'BTNS-' . strtoupper(Str::random(10));

        // Load invoice with all necessary relationships
        $invoice = Invoice::with(['fees.category', 'studentEnroll.student'])
                    ->lockForUpdate()
                    ->findOrFail($request->invoice_id);

        // Lock bursary type for update to prevent concurrent modifications
        $bursaryType = BursaryType::where('code', $request->bursary_type)
                         ->lockForUpdate()
                         ->firstOrFail();

        // Calculate current payment totals (both cash and bursary)
        $totalCashPaid = Payment::where('invoice_id', $invoice->id)
                         ->where('is_bursary', 0)
                         ->sum('amount');
                         
        $totalBursaryPaid = Payment::where('invoice_id', $invoice->id)
                           ->where('is_bursary', 1)
                           ->sum('amount');

        // Calculate net payable amount including discounts and fines
        $originalAmount = $invoice->total_fee;
        $discountAmount = $invoice->discount_amount ?? 0;
        $fineAmount = $invoice->fine_amount ?? 0;
        
        $netPayableAmount = $originalAmount + $fineAmount - $discountAmount;
        $remainingAmount = max(0, $netPayableAmount - $totalCashPaid - $totalBursaryPaid);

        // Validate payment amount against remaining balance
        if ($request->amount > $remainingAmount) {
            throw new \Exception("Bursary amount cannot exceed remaining balance of ".number_format($remainingAmount, 2));
        }

        // Check bursary balance after confirming the amount is valid
        if ($bursaryType->current_balance < $request->amount) {
            throw new \Exception("Insufficient bursary funds. Available: ".number_format($bursaryType->current_balance, 2));
        }

        // Create payment record with bursary details
        $payment = Payment::create([
            'receipt_no' => $receiptNo,
            'transaction_id' => $transactionId,
            'invoice_id' => $request->invoice_id,
            'student_enroll_id' => $request->student_enroll_id,
            'amount' => $request->amount,
            'payment_method' => 'bursary',
            'payment_date' => $request->payment_date,
            'status' => 'completed',
            'is_bursary' => true,
            'bursary_type' => $request->bursary_type,
            'bursary_notes' => $request->bursary_notes,
            'bursary_allocated_by' => auth()->user()->name,
            'bursary_allocated_at' => now(),
            'paid_at' => $request->payment_date,
        ]);

        // Update invoice amounts and status
        $this->updateInvoiceAfterBursary($invoice);

        // Deduct from bursary balance
        $bursaryType->decrement('current_balance', $request->amount);
        $bursaryType->increment('total_allocated', $request->amount);

        DB::commit();

        // Prepare receipt data
        $receiptData = $this->prepareReceiptData($payment, $invoice);

        return response()->json([
            'success' => true,
            'message' => 'Bursary allocated successfully',
            'receipt_data' => $receiptData,
            'redirect_url' => route('payment.receipt', $payment->id)
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json([
            'success' => false,
            'message' => 'Bursary allocation failed: ' . $e->getMessage()
        ], 500);
    }
}

/**
 * Updates invoice after bursary payment with proper amount calculations
 */
protected function updateInvoiceAfterBursary(Invoice $invoice)
{
    // Recalculate all payment totals
    $totalCashPaid = Payment::where('invoice_id', $invoice->id)
                     ->where('is_bursary', 0)
                     ->sum('amount');
                     
    $totalBursaryPaid = Payment::where('invoice_id', $invoice->id)
                       ->where('is_bursary', 1)
                       ->sum('amount');

    // Calculate net payable amount including all adjustments
    $originalAmount = $invoice->total_fee;
    $discountAmount = $invoice->discount_amount ?? 0;
    $fineAmount = $invoice->fine_amount ?? 0;
    
    $netPayableAmount = $originalAmount + $fineAmount - $discountAmount;
    $amountDue = max(0, $netPayableAmount - $totalCashPaid - $totalBursaryPaid);

    // Determine payment status
    $paymentStatus = 'pending';
    if ($amountDue <= 0) {
        $paymentStatus = 'paid';
    } elseif (($totalCashPaid + $totalBursaryPaid) > 0) {
        $paymentStatus = 'partial';
    }

    // Update invoice with all correct values
    $invoice->update([
        'amount_due' => $amountDue,
        'payment_status' => $paymentStatus,
        'amount_paid' => $totalCashPaid,
        'bursary_allocated' => $totalBursaryPaid,
        'updated_at' => now()
    ]);
}

    public function batchAllocate(Request $request)
    {
        $request->validate([
            'students' => 'required|array|min:1',
            'students.*' => 'exists:student_enrolls,id',
            'amount' => 'required|numeric|min:0.01',
            'bursary_type' => 'required|exists:bursary_types,code',
            'notes' => 'nullable|string|max:500',
        ]);

        $bursaryType = BursaryType::where('code', $request->bursary_type)->firstOrFail();
        $totalAmount = $request->amount * count($request->students);

        // Check if there's enough balance before processing
        if ($bursaryType->current_balance < $totalAmount) {
            return back()->with('error', "Insufficient bursary funds. Available: {$bursaryType->current_balance}, Required: {$totalAmount}");
        }

        $successCount = 0;
        $errors = [];

        DB::transaction(function () use ($request, $bursaryType, &$successCount, &$errors) {
            foreach ($request->students as $studentEnrollId) {
                try {
                    $studentEnroll = StudentEnroll::with('invoices')->findOrFail($studentEnrollId);
                    $invoice = $studentEnroll->invoices->where('amount_due', '>', 0)->first();

                    if (!$invoice) {
                        $errors[] = "Student ID {$studentEnroll->student->student_id} has no outstanding invoices";
                        continue;
                    }

                    $amountDue = $invoice->total_fee - $invoice->amount_paid - $invoice->bursary_allocated;
                    $excessPayment = max(0, $request->amount - $amountDue);

                    // Create the bursary payment record
                    $payment = Payment::create([
                        'student_enroll_id' => $studentEnrollId,
                        'invoice_id' => $invoice->id,
                        'amount' => $request->amount,
                        'excess_payment' => $excessPayment,
                        'payment_method' => 'bursary',
                        'payment_date' => now(),
                        'status' => 'completed',
                        'is_bursary' => true,
                        'bursary_type' => $request->bursary_type,
                        'bursary_notes' => $request->notes,
                        'bursary_allocated_by' => auth()->user()->name,
                        'bursary_allocated_at' => now(),
                        'paid_at' => now(),
                    ]);

                    // Update the invoice
                    $invoice->bursary_allocated += $request->amount;
                    $invoice->amount_due = $invoice->total_fee - $invoice->amount_paid - $invoice->bursary_allocated;
                    
                    if ($invoice->amount_due <= 0) {
                        $invoice->payment_status = 'paid';
                    }
                    
                    $invoice->save();
                    $successCount++;
                } catch (\Exception $e) {
                    $errors[] = "Error processing student ID {$studentEnroll->student->student_id}: " . $e->getMessage();
                }
            }

            // Update bursary type balance after all allocations
            $bursaryType->current_balance -= ($request->amount * $successCount);
            $bursaryType->save();
        });

        $message = "Successfully allocated bursaries to {$successCount} students.";
        if (count($errors) > 0) {
            $message .= " There were " . count($errors) . " errors.";
        }

        return redirect()->route('admin.bursary-allocation.index')
            ->with('success', $message)
            ->with('errors', $errors);
    }


    public function reconcile(Request $request, $id)
    {
        $request->validate([
            'reconciliation_status' => 'required|in:1,2',
            'confirmation_date' => 'required|date',
            'confirmation_time' => 'required',
            'reconciliation_notes' => 'nullable|string|max:500',
        ]);

        $payment = Payment::findOrFail($id);
        
        $reconciledAt = Carbon::parse($request->confirmation_date . ' ' . $request->confirmation_time);

        $payment->update([
            'is_reconciled' => $request->reconciliation_status,
            'reconciled_by' => auth()->user()->name,
            'reconciled_at' => $reconciledAt,
            'reconciliation_notes' => $request->reconciliation_notes,
        ]);

        return redirect()->route('admin.bursary-allocation.index')
            ->with('success', 'Bursary reconciliation completed successfully.');
    }

    public function batchReconcile(Request $request)
{
    $request->validate([
        'payment_ids' => 'required|string',
        'reconciliation_status' => 'required|in:1,2',
        'confirmation_date' => 'required|date',
        'confirmation_time' => 'required',
        'reconciliation_notes' => 'nullable|string|max:500',
    ]);

    // Convert comma-separated string to array of integers
    $paymentIds = array_map('intval', explode(',', $request->payment_ids));
    
    // Validate payments exist, are bursaries, and aren't already reconciled
    $existingPayments = Payment::whereIn('id', $paymentIds)
        ->where('is_bursary', 1)
        ->where('is_reconciled', 0)
        ->count();

    if ($existingPayments !== count($paymentIds)) {
        return redirect()->back()
            ->with('error', 'One or more selected payments cannot be reconciled (not bursaries, already reconciled or not found)');
    }

    $reconciledAt = Carbon::parse($request->confirmation_date . ' ' . $request->confirmation_time);

    // Perform the update
    $updated = Payment::whereIn('id', $paymentIds)
        ->update([
            'is_reconciled' => $request->reconciliation_status,
            'reconciled_by' => auth()->user()->name,
            'reconciled_at' => $reconciledAt,
            'reconciliation_notes' => $request->reconciliation_notes,
        ]);

    if ($updated) {
        return redirect()->route('admin.bursary-allocation.index')
            ->with('success', 'Successfully reconciled ' . $updated . ' bursary payments');
    }

    return redirect()->back()
        ->with('error', 'Failed to reconcile bursary payments. Please try again.');
}

public function getBursaryPayments()
{
    try {
        $bursaries = Payment::with(['studentEnroll.student'])
            ->where('is_bursary', 1)
            ->where('is_reconciled', 0)
            ->orderBy('bursary_allocated_at', 'desc')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'student_name' => $payment->studentEnroll->student->name ?? 'N/A',
                    'amount' => $payment->amount,
                    'bursary_type' => $payment->bursary_type ?? 'N/A',
                    'payment_date' => $payment->payment_date ? Carbon::parse($payment->payment_date)->format('Y-m-d') : 'N/A',
                ];
            });

        return response()->json($bursaries);

    } catch (\Exception $e) {
        return response()->json([], 500);
    }
}

    public function storeFund(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bursary_types,name',
            'code' => 'required|string|max:50|unique:bursary_types,code',
            'initial_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        BursaryType::create([
            'name' => $request->name,
            'code' => strtoupper($request->code),
            'description' => $request->description,
            'initial_amount' => $request->initial_amount,
            'current_balance' => $request->initial_amount,
            'is_active' => true,
        ]);

        return redirect()->route('admin.bursary-allocation.index')
            ->with('success', 'Bursary fund created successfully.');
    }

    public function export()
    {
        return Excel::download(new BursaryAllocationExport, 'bursary_allocations_' . date('Ymd_His') . '.xlsx');
    }

    public function getBursaryTypeDetails($code)
{
    $bursaryType = BursaryType::where('code', $code)->firstOrFail();
    
    return response()->json([
        'initial_amount' => $bursaryType->initial_amount,
        'current_balance' => $bursaryType->current_balance,
        'name' => $bursaryType->name,
        'code' => $bursaryType->code
    ]);
}

public function updateFund(Request $request)
{
    $request->validate([
        'id' => 'required|exists:bursary_types,id',
        'name' => 'required|string|max:255|unique:bursary_types,name,'.$request->id,
        'code' => 'required|string|max:50|unique:bursary_types,code,'.$request->id,
        'initial_amount' => 'required|numeric|min:0',
        'description' => 'nullable|string',
        'is_active' => 'nullable|boolean',
    ]);

    $bursaryType = BursaryType::findOrFail($request->id);
    
    // Calculate balance adjustment if initial amount changes
    $balanceAdjustment = $request->initial_amount - $bursaryType->initial_amount;
    
    $bursaryType->update([
        'name' => $request->name,
        'code' => strtoupper($request->code),
        'description' => $request->description,
        'initial_amount' => $request->initial_amount,
        'current_balance' => $bursaryType->current_balance + $balanceAdjustment,
        'is_active' => $request->is_active ?? false,
    ]);

    return redirect()->route('admin.bursary-allocation.index')
        ->with('success', 'Bursary type updated successfully.');
}

public function deleteFund(Request $request)
{
    $request->validate([
        'id' => 'required|exists:bursary_types,id'
    ]);

    try {
        $bursaryType = BursaryType::findOrFail($request->id);
        
        // Check if there are any allocations using this bursary type
        $allocationsCount = Payment::where('bursary_type', $bursaryType->code)->count();
        
        if ($allocationsCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete bursary type. There are '.$allocationsCount.' allocations using this bursary type.'
            ], 422);
        }
        
        $bursaryType->delete();

        return response()->json([
            'success' => true,
            'message' => 'Bursary type deleted successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error deleting bursary: ' . $e->getMessage()
        ], 500);
    }
}

}