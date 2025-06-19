@extends('admin.layouts.master')
@section('title', 'Invoice Details')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">

                <h3>Invoice #{{ $invoice->invoice_no }}</h3>

                <p><strong>Student:</strong> {{ $invoice->studentEnroll->student->first_name }} {{ $invoice->studentEnroll->student->last_name }} ({{ $invoice->studentEnroll->student->student_id }})</p>
                <p><strong>Assign Date:</strong> {{ $invoice->assign_date }}</p>
                <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
                <p><strong>Payment Status:</strong> {{ $invoice->payment_status }}</p>
                <p><strong>Total Fee:</strong> Ksh {{ number_format($invoice->total_fee, 2) }}</p>
                <p><strong>Amount Paid:</strong> Ksh {{ number_format($totalPaid, 2) }}</p>
                <p><strong>Amount Due:</strong> Ksh {{ number_format($totalDue, 2) }}</p>

                <h4>Fee Breakdown</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Fee Category</th>
                            <th>Amount</th>
                            <th>Assign Date</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                     @foreach($invoice->fees as $fee)
    <tr>
        <td>{{ $fee->category ? $fee->category->title : 'Category missing' }}</td>
        <td>Ksh {{ number_format($fee->fee_amount, 2) }}</td>
        <td>{{ $fee->assign_date }}</td>
        <td>{{ $fee->due_date }}</td>
    </tr>
@endforeach

                    </tbody>
                </table>

                <a href="{{ route('fees.invoice') }}" class="btn btn-secondary">Back to Invoice List</a>

            </div>
        </div>
    </div>
</div>

@endsection
