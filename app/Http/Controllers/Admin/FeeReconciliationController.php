<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Semester;
use App\Models\StudentEnroll;
use Illuminate\Http\Request;
use Carbon\Carbon;
use PDF;
use Excel;
use App\Exports\FeeReconciliationExport;

class FeeReconciliationController extends Controller
{
    public function index(Request $request)
    {
        // Set default filter to show only unreconciled payments
        $defaultReconciled = 'no';
        
        $payments = Payment::with(['invoice', 'studentEnroll.student', 'studentEnroll.program.faculty', 'studentEnroll.semester'])
            ->when($request->has('payment_method') && $request->payment_method != '', function($query) use ($request) {
                $query->where('payment_method', $request->payment_method);
            })
            ->when($request->has('status') && $request->status != '', function($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->has('reconciled'), function($query) use ($request) {
    if ($request->reconciled === 'yes') {
        $query->where('is_reconciled', 1);
    } elseif ($request->reconciled === 'no') {
        $query->where('is_reconciled', 0);
    }
    // if value is '', do nothing → show all
}, function($query) {
    // param not present → default to Not Reconciled
    $query->where('is_reconciled', 0);
})

            ->when($request->filled('faculty') && $request->faculty != '0', function($query) use ($request) {
                $query->whereHas('studentEnroll.program', function($q) use ($request) {
                    $q->where('faculty_id', $request->faculty);
                });
            })
            ->when($request->filled('program') && $request->program != '0', function($query) use ($request) {
                $query->whereHas('studentEnroll', function($q) use ($request) {
                    $q->where('program_id', $request->program);
                });
            })
            ->when($request->filled('semester') && $request->semester != '0', function($query) use ($request) {
                $query->whereHas('studentEnroll', function($q) use ($request) {
                    $q->where('semester_id', $request->semester);
                });
            })
            ->when($request->filled('start_date') && $request->filled('end_date'), function($query) use ($request) {
                $query->whereBetween('payment_date', [
                    Carbon::parse($request->start_date)->startOfDay(),
                    Carbon::parse($request->end_date)->endOfDay()
                ]);
            })
            ->when($request->filled('search'), function($query) use ($request) {
                $query->where(function($q) use ($request) {
                    $q->where('reference_number', 'like', '%'.$request->search.'%')
                      ->orWhere('transaction_id', 'like', '%'.$request->search.'%')
                      ->orWhereHas('studentEnroll.student', function($q) use ($request) {
                          $q->where('name', 'like', '%'.$request->search.'%')
                            ->orWhere('student_id', 'like', '%'.$request->search.'%')
                            ->orWhere('email', 'like', '%'.$request->search.'%');
                      });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->appends($request->except('page'));

        $faculties = Faculty::all();
        $programs = Program::all();
        $semesters = Semester::all();

        return view('admin.fee-reconciliation.index', [
            'payments' => $payments,
            'faculties' => $faculties,
            'programs' => $programs,
            'semesters' => $semesters,
            'selected_faculty' => $request->faculty ?? '0',
            'selected_program' => $request->program ?? '0',
            'selected_semester' => $request->semester ?? '0',
            'selected_payment_method' => $request->payment_method ?? '',
            'selected_status' => $request->status ?? '',
            'selected_reconciled' => $request->reconciled ?? $defaultReconciled,
            'start_date' => $request->start_date ?? '',
            'end_date' => $request->end_date ?? '',
            'search_term' => $request->search ?? '',
            'title' => 'Fee Reconciliation',
            'route' => 'admin.fee-reconciliation'
        ]);
    }

    

public function reconcile(Request $request, Payment $payment)
{
    $request->validate([
        'reconciliation_notes' => 'nullable|string|max:500',
        'confirmation_date' => 'required|date',
        'confirmation_time' => 'required',
        'reconciliation_status' => 'required|in:1,2' // 1=completed, 2=to check
    ]);

    // Combine date and time
    $confirmationDateTime = Carbon::parse($request->confirmation_date . ' ' . $request->confirmation_time);

    $updateData = [
        'is_reconciled' => $request->reconciliation_status, // 1 or 2
        'reconciled_by' => auth()->user()->name,
        'reconciled_at' => now(),
        'reconciliation_notes' => $request->reconciliation_notes,
        'confirmed_by' => auth()->user()->name,
        'confirmation_date' => $confirmationDateTime
    ];

    $payment->update($updateData);

    return redirect()->back()->with('success', 'Payment has been successfully reconciled.');
}

public function batchReconcile(Request $request)
{
    $request->validate([
        'payment_ids' => 'required|array',
        'payment_ids.*' => 'exists:payments,id',
        'reconciliation_notes' => 'nullable|string|max:500',
        'confirmation_date' => 'required|date',
        'confirmation_time' => 'required',
        'reconciliation_status' => 'required|in:1,2' // 1=completed, 2=to check/failed
    ]);

    // Combine date and time
    $confirmationDateTime = Carbon::parse($request->confirmation_date . ' ' . $request->confirmation_time);

    $updateData = [
        'is_reconciled' => $request->reconciliation_status, // 1 or 2
        'reconciled_by' => auth()->user()->name,
        'reconciled_at' => now(),
        'reconciliation_notes' => $request->reconciliation_notes,
        'confirmed_by' => auth()->user()->name,
        'confirmation_date' => $confirmationDateTime
    ];

    Payment::whereIn('id', $request->payment_ids)->update($updateData);

    return redirect()->back()->with('success', 'Selected payments have been successfully reconciled.');
}

    public function export(Request $request)
    {
        return Excel::download(new FeeReconciliationExport($request), 'fee-reconciliation-'.now()->format('Y-m-d').'.xlsx');
    }
}