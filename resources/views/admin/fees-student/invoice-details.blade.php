@extends('admin.layouts.master')
@section('title', 'Invoice Details')
@section('content')

<div class="container">
    <h1>Invoice #{{ $invoice->id }}</h1>
    
    <!-- Basic Invoice Info -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Student Information</h5>
            <p><strong>Name:</strong> {{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}</p>
            <p><strong>Program:</strong> {{ $invoice->studentEnroll->program->title ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Fees Table -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Fee Breakdown</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->fees as $index => $fee)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $fee->category->title ?? 'Fee' }}</td>
                        <td>{{ number_format($fee->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Payment Info -->
    <div class="mt-4">
        <p><strong>Total Amount:</strong> {{ number_format($invoice->total_amount, 2) }}</p>
        <p><strong>Payment Status:</strong> 
            <span class="badge badge-{{ $invoice->payment_status == 'paid' ? 'success' : 'danger' }}">
                {{ ucfirst($invoice->payment_status) }}
            </span>
        </p>
    </div>
</div>

@endsection