<?php
// app/Http/Controllers/Admin/ReconciliationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reconciliation;
use App\Models\Income;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Toastr;
use Auth;
use DB;

class ReconciliationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('Reconciliation', 1);
        $this->route = 'admin.reconciliation';
        $this->view = 'admin.reconciliation';
        $this->path = 'reconciliation';
        $this->access = 'reconciliation';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','reconcile']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        // Filter parameters
        $data['selected_type'] = $request->type ?? 'all';
        $data['selected_status'] = $request->status ?? 'all';
        $data['selected_start_date'] = $start_date = $request->start_date ?? date('Y-m-d', strtotime(Carbon::now()->subMonth()));
        $data['selected_end_date'] = $end_date = $request->end_date ?? date('Y-m-d', strtotime(Carbon::today()));

        // Query
        $rows = Reconciliation::with(['transaction', 'reconciledBy', 'createdBy'])
            ->dateRange($start_date, $end_date);

        if ($data['selected_type'] != 'all') {
            $rows->where('type', $data['selected_type']);
        }

        if ($data['selected_status'] != 'all') {
            $rows->where('status', $data['selected_status']);
        }

        $data['rows'] = $rows->orderBy('reconciliation_date', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        // Get unreconciled transactions for the reconciliation panel
        $data['unreconciled_incomes'] = Income::whereDoesntHave('reconciliations', function($query) {
            $query->where('status', 'reconciled');
        })->get();

        $data['unreconciled_expenses'] = Expense::whereDoesntHave('reconciliations', function($query) {
            $query->where('status', 'reconciled');
        })->get();

        // Statistics
        $data['total_pending'] = Reconciliation::pending()->count();
        $data['total_reconciled'] = Reconciliation::reconciled()->count();
        $data['total_discrepancy'] = Reconciliation::discrepancy()->count();
        $data['total_income'] = Reconciliation::income()->reconciled()->sum('amount');
        $data['total_expense'] = Reconciliation::expense()->reconciled()->sum('amount');

        return view($this->view.'.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
 * Store a newly created resource in storage.
 */
public function store(Request $request)
{
    $request->validate([
        'transaction_id' => 'required',
        'transaction_type' => 'required|in:income,expense',
        'bank_amount' => 'required|numeric',
        'bank_reference' => 'required|string',
        'value_date' => 'required|date',
        'notes' => 'nullable|string'
    ]);

    try {
        DB::beginTransaction();

        // Get the transaction
        if ($request->transaction_type == 'income') {
            $transaction = Income::findOrFail($request->transaction_id);
        } else {
            $transaction = Expense::findOrFail($request->transaction_id);
        }

        // Check if transaction is already reconciled
        $existingReconciliation = Reconciliation::where('transaction_id', $transaction->id)
            ->where('transaction_type', $request->transaction_type == 'income' ? 'App\Models\Income' : 'App\Models\Expense')
            ->where('status', 'reconciled')
            ->first();

        if ($existingReconciliation) {
            Toastr::error('This transaction has already been reconciled.', __('msg_error'));
            return redirect()->back();
        }

        // Process reference codes - split by commas and clean up
        $referenceCodes = $request->bank_reference;
        $cleanedReferences = $this->cleanReferenceCodes($referenceCodes);

        // Create reconciliation
        $reconciliation = new Reconciliation();
        $reconciliation->reconciliation_no = Reconciliation::generateReconciliationNo();
        $reconciliation->reconciliation_date = now();
        $reconciliation->type = $request->transaction_type;
        $reconciliation->transaction_id = $transaction->id;
        $reconciliation->transaction_type = $request->transaction_type == 'income' ? 'App\Models\Income' : 'App\Models\Expense';
        $reconciliation->amount = $transaction->amount;
        $reconciliation->bank_amount = $request->bank_amount;
        $reconciliation->bank_reference = $cleanedReferences; // Save processed references
        $reconciliation->value_date = $request->value_date;
        $reconciliation->notes = $request->notes;
        $reconciliation->created_by = Auth::id();
        
        // Calculate difference
        $reconciliation->difference = $reconciliation->amount - $reconciliation->bank_amount;
        
        // Auto-match if amounts are close (within 1 KES)
        if (abs($reconciliation->difference) <= 1) {
            $reconciliation->status = 'reconciled';
            $reconciliation->reconciled_by = Auth::id();
            $reconciliation->reconciled_at = now();
            $reconciliation->is_auto_matched = true;
        } else {
            $reconciliation->status = 'pending';
        }

        $reconciliation->save();

        DB::commit();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

    } catch (\Exception $e) {
        DB::rollBack();
        Toastr::error(__('msg_created_error'), __('msg_error'));
    }

    return redirect()->route($this->route.'.index');
}

/**
 * Clean and format reference codes
 */
private function cleanReferenceCodes($references)
{
    // Split by commas and clean each reference
    $codes = explode(',', $references);
    $cleanedCodes = [];
    
    foreach ($codes as $code) {
        $cleanedCode = trim($code);
        if (!empty($cleanedCode)) {
            $cleanedCodes[] = $cleanedCode;
        }
    }
    
    // Return as comma-separated string
    return implode(', ', $cleanedCodes);
}

    /**
     * Mark as reconciled
     */
    public function reconcile(Request $request, $id)
    {
        $request->validate([
            'notes' => 'nullable|string'
        ]);

        try {
            $reconciliation = Reconciliation::findOrFail($id);
            $reconciliation->status = 'reconciled';
            $reconciliation->reconciled_by = Auth::id();
            $reconciliation->reconciled_at = now();
            if ($request->notes) {
                $reconciliation->notes = $request->notes;
            }
            $reconciliation->save();

            Toastr::success(__('Transaction reconciled successfully'), __('msg_success'));

        } catch (\Exception $e) {
            Toastr::error(__('msg_error'), __('msg_error'));
        }

        return redirect()->back();
    }

    /**
     * Mark as discrepancy
     */
    public function markDiscrepancy(Request $request, $id)
    {
        $request->validate([
            'discrepancy_reason' => 'required|string'
        ]);

        try {
            $reconciliation = Reconciliation::findOrFail($id);
            $reconciliation->status = 'discrepancy';
            $reconciliation->discrepancy_reason = $request->discrepancy_reason;
            $reconciliation->save();

            Toastr::warning(__('Transaction marked with discrepancy'), __('msg_success'));

        } catch (\Exception $e) {
            Toastr::error(__('msg_error'), __('msg_error'));
        }

        return redirect()->back();
    }

    /**
     * Bulk reconciliation
     */
    public function bulkReconcile(Request $request)
    {
        $request->validate([
            'reconciliations' => 'required|array',
            'reconciliations.*' => 'exists:reconciliations,id'
        ]);

        $count = 0;
        foreach ($request->reconciliations as $id) {
            $reconciliation = Reconciliation::find($id);
            if ($reconciliation && $reconciliation->status == 'pending') {
                $reconciliation->status = 'reconciled';
                $reconciliation->reconciled_by = Auth::id();
                $reconciliation->reconciled_at = now();
                $reconciliation->save();
                $count++;
            }
        }

        Toastr::success(__('msg_updated_successfully', ['count' => $count]), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Quick reconciliation from unreconciled transactions
     */
    /**
 * Quick reconciliation from unreconciled transactions
 */
public function quickReconcile(Request $request)
{
    $request->validate([
        'transaction_ids' => 'required|array',
        'transaction_type' => 'required|in:income,expense',
        'bank_amounts' => 'required|array',
        'bank_references' => 'required|array'
    ]);

    $count = 0;
    foreach ($request->transaction_ids as $key => $transaction_id) {
        try {
            // Get the transaction
            if ($request->transaction_type == 'income') {
                $transaction = Income::find($transaction_id);
            } else {
                $transaction = Expense::find($transaction_id);
            }

            if ($transaction) {
                // Process reference codes
                $referenceCodes = $request->bank_references[$key] ?? 'QR-' . time();
                $cleanedReferences = $this->cleanReferenceCodes($referenceCodes);

                $reconciliation = new Reconciliation();
                $reconciliation->reconciliation_no = Reconciliation::generateReconciliationNo();
                $reconciliation->reconciliation_date = now();
                $reconciliation->type = $request->transaction_type;
                $reconciliation->transaction_id = $transaction->id;
                $reconciliation->transaction_type = $request->transaction_type == 'income' ? 'App\Models\Income' : 'App\Models\Expense';
                $reconciliation->amount = $transaction->amount;
                $reconciliation->bank_amount = $request->bank_amounts[$key] ?? $transaction->amount;
                $reconciliation->bank_reference = $cleanedReferences; // Save processed references
                $reconciliation->value_date = now();
                $reconciliation->created_by = Auth::id();
                
                // Calculate difference
                $reconciliation->difference = $reconciliation->amount - $reconciliation->bank_amount;
                
                // Auto-reconcile if amounts match exactly
                if ($reconciliation->difference == 0) {
                    $reconciliation->status = 'reconciled';
                    $reconciliation->reconciled_by = Auth::id();
                    $reconciliation->reconciled_at = now();
                    $reconciliation->is_auto_matched = true;
                } else {
                    $reconciliation->status = 'pending';
                }

                $reconciliation->save();
                $count++;
            }
        } catch (\Exception $e) {
            continue;
        }
    }

    Toastr::success(__('msg_created_successfully', ['count' => $count]), __('msg_success'));

    return redirect()->route($this->route.'.index');
}
}