@extends('admin.layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-file-invoice text-primary me-2"></i> 
                        Invoice History for {{ $student->name }}
                    </h4>
                    <a href="{{ route($route.'.show', $student->enrollment->id) }}" class="btn btn-sm btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i> Back to Student
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th>Invoice No.</th>
                                    <th>Assigned Date</th>
                                    <th>Due Date</th>
                                    <th>Total Amount</th>
                                    <th>Amount Paid</th>
                                    <th>Amount Due</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->invoice_no }}</td>
                                    <td>{{ $invoice->assign_date->format('d M Y') }}</td>
                                    <td>{{ $invoice->due_date->format('d M Y') }}</td>
                                    <td>${{ number_format($invoice->total_fee, 2) }}</td>
                                    <td>${{ number_format($invoice->amount_paid, 2) }}</td>
                                    <td>${{ number_format($invoice->amount_due, 2) }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $invoice->payment_status === 'paid' ? 'success' : 
                                            ($invoice->payment_status === 'partial' ? 'warning' : 'danger') 
                                        }}">
                                            {{ strtoupper($invoice->payment_status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-outline-info" title="View Invoice">
                                            <i class="fas fa-file-invoice"></i>
                                        </a>
                                        @if($invoice->amount_due > 0)
                                        <a href="{{ route($route.'.clear', $invoice->id) }}" class="btn btn-sm btn-outline-success" title="Mark as Paid">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} entries
                        </div>
                        <div>
                            {{ $invoices->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection