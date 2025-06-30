@extends('admin.layouts.master')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-graduate text-primary me-2"></i> 
                        Student Details: {{ $student->name }}
                    </h4>
                    <div>
                        @php
                            $status = $invoices->where('payment_status', 'pending')->count() > 0 ? 'pending' : 
                                     ($invoices->where('payment_status', 'partial')->count() > 0 ? 'partial' : 'paid');
                        @endphp
                        <span class="badge bg-{{ 
                            $status === 'paid' ? 'success' : 
                            ($status === 'partial' ? 'warning' : 'danger') 
                        }} fs-6">
                            {{ strtoupper($status) }}
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="text-center">
                                <img src="{{ asset('storage/'.$student->photo) }}" alt="Student Photo" class="img-thumbnail mb-3" style="max-height: 200px;">
                                <h5>{{ $student->student_id }}</h5>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <p><strong>Program:</strong> {{ $program->name }}</p>
                                    <p><strong>Academic Year:</strong> {{ $student->enrollment->academic_year }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Email:</strong> {{ $student->email }}</p>
                                    <p><strong>Phone:</strong> {{ $student->phone }}</p>
                                </div>
                                <div class="col-md-4">
                                    <p><strong>Total Invoiced:</strong> ${{ number_format($invoices->sum('total_fee'), 2) }}</p>
                                    <p><strong>Total Paid:</strong> ${{ number_format($invoices->sum('amount_paid'), 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <ul class="nav nav-tabs" id="studentTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab">
                                        <i class="fas fa-file-invoice me-1"></i> Invoices
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                                        <i class="fas fa-history me-1"></i> Invoice History
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="notify-tab" data-bs-toggle="tab" data-bs-target="#notify" type="button" role="tab">
                                        <i class="fas fa-bell me-1"></i> Send Notification
                                    </button>
                                </li>
                            </ul>
                            <div class="tab-content p-3 border border-top-0 rounded-bottom" id="studentTabsContent">
                                <div class="tab-pane fade show active" id="invoices" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
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
                                                        <a href="#" class="btn btn-sm btn-outline-info" title="View">
                                                            <i class="fas fa-eye"></i>
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
                                </div>

                                <div class="tab-pane fade" id="history" role="tabpanel">
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Invoice No.</th>
                                                    <th>Assigned Date</th>
                                                    <th>Due Date</th>
                                                    <th>Total Amount</th>
                                                    <th>Amount Paid</th>
                                                    <th>Status</th>
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
                                                    <td>
                                                        <span class="badge bg-{{ 
                                                            $invoice->payment_status === 'paid' ? 'success' : 
                                                            ($invoice->payment_status === 'partial' ? 'warning' : 'danger') 
                                                        }}">
                                                            {{ strtoupper($invoice->payment_status) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <a href="{{ route($route.'.history', $student->enrollment->id) }}" class="btn btn-outline-primary">
                                        <i class="fas fa-external-link-alt me-1"></i> View Full History
                                    </a>
                                </div>

                                <div class="tab-pane fade" id="notify" role="tabpanel">
                                    <form action="{{ route($route.'.notify', $student->enrollment->id) }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="notificationMethod" class="form-label">Notification Method</label>
                                            <select class="form-select" id="notificationMethod" name="method" required>
                                                <option value="">Select method...</option>
                                                <option value="email">Email</option>
                                                <option value="sms">SMS</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="notificationMessage" class="form-label">Message</label>
                                            <textarea class="form-control" id="notificationMessage" name="message" rows="5" required>Dear {{ $student->name }},

Your current outstanding balance is ${{ number_format($invoices->sum('amount_due'), 2) }} from {{ $invoices->count() }} invoice(s).

Please clear your fees to avoid inconveniences.</textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane me-1"></i> Send Notification
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection