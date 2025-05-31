<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
class InvoiceController extends Controller
{
    public function show($id)
{
    $invoice = \App\Models\Invoice::with(['studentEnroll.student', 'fees'])->findOrFail($id);

    // Calculate totals, if needed
    $totalPaid = $invoice->fees->sum('paid_amount');
    $totalDue = $invoice->total_fee - $totalPaid;

    return view('admin.fees-student.invoice-show', compact('invoice', 'totalPaid', 'totalDue'));
}

}
