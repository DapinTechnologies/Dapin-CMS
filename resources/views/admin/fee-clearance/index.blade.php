@extends('admin.layouts.master')

@section('content')
<div class="container-fluid py-4">
    <!-- Dashboard Summary Cards -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0" style="color: white;">
                        <i class="fas fa-file-invoice-dollar me-2"></i> Student Fee Clearance Management
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card border-success mb-3">
                                <div class="card-body text-success">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Fully Paid Invoices</h5>
                                            <h2 class="mb-0">{{ $clearedStudents }}</h2>
                                        </div>
                                        <i class="fas fa-check-circle fa-3x opacity-1"></i>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route($route.'.report') }}?status=paid" class="btn btn-sm btn-outline-success">View Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning mb-3">
                                <div class="card-body text-warning">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Partially Paid</h5>
                                            <h2 class="mb-0">{{ $partialStudents }}</h2>
                                        </div>
                                        <i class="fas fa-exclamation-triangle fa-3x opacity-1"></i>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route($route.'.report') }}?status=partial" class="btn btn-sm btn-outline-warning">View Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-danger mb-3">
                                <div class="card-body text-danger">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">Pending Payment</h5>
                                            <h2 class="mb-0">{{ $pendingStudents }}</h2>
                                        </div>
                                        <i class="fas fa-times-circle fa-3x opacity-1"></i>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route($route.'.report') }}?status=pending" class="btn btn-sm btn-outline-danger">View Report</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Section -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Search Student Invoices</h5>
                        <div class="col-md-6">
                            <form action="{{ route($route.'.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search by student ID, name or email..." name="query" required>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fas fa-search me-1"></i> Search
                                    </button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> Search for students to view their invoice payment status and manage fee clearance.
                    </div>
                    
                    @if(isset($student))
                        <!-- Student Details Section (from show.blade.php) -->
                        <div class="card shadow-sm mb-4">
                            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                                <h4 class="mb-0">
                                    <i class="fas fa-user-graduate text-primary me-2"></i> 
                                    Student Details For {{ $student->first_name . ' ' . $student->last_name }}.
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
                                            <img src="{{ asset('dashboard/images/user/avatar-2.jpg') }}" alt="Student Photo" class="img-thumbnail mb-3" style="max-height: 200px;">
                                            <h5>Student ID: {{ $student->student_id }}</h5>
                                        </div>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <p><strong>Student Name:</strong> {{ $student->first_name . ' ' . $student->last_name }}</p>
                                                <p><strong>Course:</strong> {{ $program->title }}</p>
                                                
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Email:</strong> {{ $student->email }}</p>
                                                <p><strong>Phone:</strong> {{ $student->phone }}</p>
                                            </div>
                                            <div class="col-md-4">
                                                <p><strong>Total Invoiced:</strong> Ksh  {{ number_format($invoices->sum('total_fee'), 2) }}</p>
                                                <p><strong>Total Paid:</strong> Ksh {{ number_format($invoices->sum('amount_paid'), 2) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <ul class="nav nav-tabs" id="studentTabs" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="invoices-tab" data-bs-toggle="tab" data-bs-target="#invoices" type="button" role="tab">
                                                    <i class="fas fa-file-invoice me-1"></i> Current Invoices
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="history-tab" data-bs-toggle="tab" data-bs-target="#history" type="button" role="tab">
                                                    <i class="fas fa-history me-1"></i> Full Invoice History
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
                                                                <td>{{ $invoice->assign_date }}</td>
                                                                <td>{{ $invoice->due_date }}</td>
                                                                <td>Ksh {{ number_format($invoice->total_fee, 2) }}</td>
                                                                <td>Ksh {{ number_format($invoice->amount_paid, 2) }}</td>
                                                                <td>Ksh {{ number_format($invoice->amount_due, 2) }}</td>
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
                                                @if(isset($allInvoices))
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
                                                            @foreach($allInvoices as $invoice)
                                                            <tr>
                                                                <td>{{ $invoice->invoice_no }}</td>
                                                                <td>{{ $invoice->assign_date->format('d M Y') }}</td>
                                                                <td>{{ $invoice->due_date->format('d M Y') }}</td>
                                                                <td>Ksh {{ number_format($invoice->total_fee, 2) }}</td>
                                                                <td>Ksh {{ number_format($invoice->amount_paid, 2) }}</td>
                                                                <td>Ksh {{ number_format($invoice->amount_due, 2) }}</td>
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
                                                        Showing {{ $allInvoices->firstItem() }} to {{ $allInvoices->lastItem() }} of {{ $allInvoices->total() }} entries
                                                    </div>
                                                    <div>
                                                        {{ $allInvoices->links() }}
                                                    </div>
                                                </div>
                                                @else
                                                <div class="alert alert-info">
                                                    <i class="fas fa-info-circle me-2"></i> 
                                                    <a href="{{ route($route.'.history', $student->student_id) }}" class="alert-link">
                                                        Click here to view complete invoice history
                                                    </a>
                                                </div>
                                                @endif
                                            </div>

                                            <div class="tab-pane fade" id="notify" role="tabpanel">
                                                <form action="{{ route($route.'.notify', $student->student_id) }}" method="POST">
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
                                                        <textarea class="form-control" id="notificationMessage" name="message" rows="5" required>Dear {{ $student->first_name . ' ' . $student->last_name }},
Your current outstanding balance is Ksh {{ number_format($invoices->sum('amount_due'), 2) }} from {{ $invoices->count() }} invoice(s).

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
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Quick Actions For All Students</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route($route.'.report') }}" class="btn btn-outline-primary w-100 py-3">
                                <i class="fas fa-file-alt fa-2x mb-2"></i><br>
                                Generate Student Report
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-success w-100 py-3" data-bs-toggle="modal" data-bs-target="#exportModal">
                                <i class="fas fa-file-export fa-2x mb-2"></i><br>
                                Export All Data
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-info w-100 py-3" data-bs-toggle="modal" data-bs-target="#notificationModal">
                                <i class="fas fa-bell fa-2x mb-2"></i><br>
                                Bulk Messages
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="#" class="btn btn-outline-secondary w-100 py-3">
                                <i class="fas fa-cog fa-2x mb-2"></i><br>
                                Clearance Settings
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Modal -->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exportModalLabel">Export Invoice Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="exportFormat" class="form-label">Format</label>
                        <select class="form-select" id="exportFormat">
                            <option value="csv">CSV</option>
                            <option value="excel">Excel</option>
                            <option value="pdf">PDF</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exportStatus" class="form-label">Payment Status</label>
                        <select class="form-select" id="exportStatus">
                            <option value="all">All</option>
                            <option value="paid">Paid</option>
                            <option value="partial">Partial</option>
                            <option value="pending">Pending</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Export</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1" aria-labelledby="notificationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="notificationModalLabel">Send Bulk Notifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="notificationType" class="form-label">Recipient Status</label>
                        <select class="form-select" id="notificationType">
                            <option value="pending">Pending Payment</option>
                            <option value="partial">Partially Paid</option>
                            <option value="all">All Students</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notificationMethod" class="form-label">Notification Method</label>
                        <select class="form-select" id="notificationMethod">
                            <option value="email">Email</option>
                            <option value="sms">SMS</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notificationMessage" class="form-label">Message</label>
                        <textarea class="form-control" id="notificationMessage" rows="3" placeholder="Enter your notification message..."></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Send Notifications</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection