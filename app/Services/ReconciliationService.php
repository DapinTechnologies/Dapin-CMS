<?php
// app/Services/ReconciliationService.php

namespace App\Services;

use App\Models\Reconciliation;
use App\Models\Income;
use App\Models\Expense;

class ReconciliationService
{
    public function autoCreateForIncome(Income $income)
    {
        // Auto-create reconciliation entry for income
        $reconciliation = new Reconciliation();
        $reconciliation->reconciliation_no = Reconciliation::generateReconciliationNo();
        $reconciliation->reconciliation_date = now();
        $reconciliation->type = 'income';
        $reconciliation->transaction_id = $income->id;
        $reconciliation->transaction_type = 'App\Models\Income';
        $reconciliation->amount = $income->amount;
        $reconciliation->bank_amount = $income->amount; // Assuming bank amount matches initially
        $reconciliation->bank_reference = 'AUTO-' . $income->invoice_id;
        $reconciliation->value_date = $income->date;
        $reconciliation->notes = 'Auto-created from income payment';
        $reconciliation->created_by = 1; // System user
        
        $reconciliation->calculateDifference();
        $reconciliation->autoMatch(); // Try to auto-match
        
        $reconciliation->save();
        
        return $reconciliation;
    }

    public function autoCreateForExpense(Expense $expense)
    {
        // Auto-create reconciliation entry for expense
        $reconciliation = new Reconciliation();
        $reconciliation->reconciliation_no = Reconciliation::generateReconciliationNo();
        $reconciliation->reconciliation_date = now();
        $reconciliation->type = 'expense';
        $reconciliation->transaction_id = $expense->id;
        $reconciliation->transaction_type = 'App\Models\Expense';
        $reconciliation->amount = $expense->amount;
        $reconciliation->bank_amount = $expense->amount; // Assuming bank amount matches initially
        $reconciliation->bank_reference = 'AUTO-' . $expense->invoice_id;
        $reconciliation->value_date = $expense->date;
        $reconciliation->notes = 'Auto-created from expense payment';
        $reconciliation->created_by = 1; // System user
        
        $reconciliation->calculateDifference();
        $reconciliation->autoMatch(); // Try to auto-match
        
        $reconciliation->save();
        
        return $reconciliation;
    }
}