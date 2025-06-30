@extends('admin.layouts.master')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Fee Dashboard</h1>
    
    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Filters</h5>
            
        </div>
       <div class="card-body">
    <form method="GET" action="{{ route('admin.fee-dashboard.index') }}">
        <div class="row">
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="faculty" class="form-label">Faculty</label>
                    <select class="form-control select2" id="faculty" name="faculty">
                        <option value="">All Faculties</option>
                        @foreach($faculties as $faculty)
                            <option value="{{ $faculty->id }}" {{ request('faculty') == $faculty->id ? 'selected' : '' }}>
                                {{ $faculty->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select class="form-control select2" id="semester" name="semester">
                        <option value="">All Semesters</option>
                        @foreach($semesters as $semester)
                            <option value="{{ $semester->id }}" {{ request('semester') == $semester->id ? 'selected' : '' }}>
                                {{ $semester->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="start_date" class="form-label">Start Date</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ request('start_date') }}">
                </div>
            </div>
            <div class="col-md-3">
                <div class="mb-3">
                    <label for="end_date" class="form-label">End Date</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ request('end_date') }}">
                </div>
            </div>
        </div>
        <div class="mt-3">
            <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
            <a href="{{ route('admin.fee-dashboard.index') }}" class="btn btn-outline-secondary">Reset</a>
        </div>
    </form>
</div>
</div>
    

   <!-- Summary Cards -->
<div class="row mb-3">
    <div class="col-md-3">
        <div class="card text-white bg-primary">
            <div class="card-body">
                <h6 class="card-title mb-2" style="color: #fff; font-size: 0.9rem;">TOTAL BILLED FEES</h6>
                <h4 class="card-text" style="color: #fff; font-size: 1.25rem;">KSh {{ number_format($totalBilled, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success">
            <div class="card-body">
                <h6 class="card-title mb-2" style="color: #fff; font-size: 0.9rem;">TOTAL COLLECTED FEES</h6>
                <h4 class="card-text" style="color: #fff; font-size: 1.25rem;">KSh {{ number_format($totalPaid, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <h6 class="card-title m-0" style="color: #fff; font-size: 0.9rem;">OUTSTANDING FEES</h6>
                    @can('send fee notifications')
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#bulkSmsModal">
                            <i class="fas fa-envelope"> Remind</i>
                        </button>
                    @endcan
                </div>
                <h4 class="card-text mt-2" style="color: #fff; font-size: 1.25rem;">KSh {{ number_format($outstanding, 2) }}</h4>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info">
            <div class="card-body">
                <h6 class="card-title mb-2" style="color: #fff; font-size: 0.9rem;">BURSARYS/SPONSORSHIP</h6>
                <h4 class="card-text" style="color: #fff; font-size: 1.25rem;">KSh 0.00</h4>
            </div>
        </div>
    </div>
</div>

<!-- Discounts/Fines Card - Right Aligned -->
<div class="row mb-4">
    <div class="col-md-3 ms-auto">  <!-- ms-auto pushes it to the right -->
        <div class="card text-white bg-secondary">
            <div class="card-body">
                <h6 class="card-title mb-2" style="color: #fff; font-size: 0.9rem;">DISCOUNTS/FINES</h6>
                <h4 class="card-text" style="color: #fff; font-size: 1.25rem;">KSh 0.00</h4>
            </div>
        </div>
    </div>
</div>
    
    <!-- Charts -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Payment Status Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="paymentStatusChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Fee Collection Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="collectionTrendChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <!-- Add this to your charts section -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5>Faculty-wise Fee Collection</h5>
            </div>
            <div class="card-body">
                <canvas id="facultyInvoiceChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>
    </div>
    
    <!-- Invoice Table -->
    <div class="card">
        <div class="card-header">
            <h5>Fee Collection Details</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Inv No</th>
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Billed</th>
                        <th>Paid</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_no }}</td>
                            <td>{{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}</td>
                            <td>{{ $invoice->studentEnroll->program->title ?? 'N/A' }}</td>
                            <td>KSh {{ number_format($invoice->total_fee, 2) }}</td>
                            <td>KSh {{ number_format($invoice->amount_paid, 2) }}</td>
                            <td>
                                @if($invoice->payment_status == 'paid')
                                    <span class="badge bg-success">Paid</span>
                                @elseif($invoice->payment_status == 'partial')
                                    <span class="badge bg-warning">Partial</span>
                                @else
                                    <span class="badge bg-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>{{ $invoice->due_date }}</td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye"></i> View
                                </a>
                                @can('send fee notifications')
                                @if($invoice->payment_status != 'paid')
                                <button class="btn btn-sm btn-warning send-sms-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#singleSmsModal"
                                    data-invoice-id="{{ $invoice->id }}"
                                    data-student-name="{{ $invoice->studentEnroll->student->full_name ?? 'N/A' }}"
                                    data-student-id="{{ $invoice->studentEnroll->student->student_id ?? '' }}"
                                    data-amount-due="{{ number_format($invoice->amount_due, 2) }}"
                                    data-phone="{{ $invoice->studentEnroll->student->phone ?? '' }}">
                                    <i class="fas fa-envelope"></i> SMS
                                </button>
                                @endif
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bulk SMS Modal -->
<div class="modal fade" id="bulkSmsModal" tabindex="-1" aria-labelledby="bulkSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="bulkSmsModalLabel">Send Bulk Payment Reminders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.fee-dashboard.send-notifications') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> This will send SMS reminders to all students with outstanding fees matching your current filters.
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bulk_due_date" class="form-label">New Due Date</label>
                            <input type="date" class="form-control" id="bulk_due_date" name="due_date" required min="{{ date('Y-m-d') }}">
                            <small class="text-muted">Set a new due date for the payment</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Filters</label>
                            <div class="form-control bg-light">
                                @if(request('faculty'))
                                    Faculty: {{ $faculties->firstWhere('id', request('faculty'))->title ?? 'All' }}<br>
                                @endif
                                @if(request('semester'))
                                    Semester: {{ $semesters->firstWhere('id', request('semester'))->title ?? 'All' }}<br>
                                @endif
                                @if(request('start_date') && request('end_date'))
                                    Date Range: {{ request('start_date') }} to {{ request('end_date') }}
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="faculty" value="{{ request('faculty') }}">
                    <input type="hidden" name="semester" value="{{ request('semester') }}">
                    <input type="hidden" name="start_date" value="{{ request('start_date') }}">
                    <input type="hidden" name="end_date" value="{{ request('end_date') }}">
                    
                    <div class="mb-3">
                        <label class="form-label">Message Preview</label>
                        <div class="card bg-light p-3">
                            <p id="bulkMessagePreview">
                                Dear [Student Name], ([Student ID]), you have an outstanding fee balance of KES [Amount]. 
                                Please clear it by [Due Date] to avoid penalties. For any queries, contact the accounts office.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-paper-plane"></i> Send Bulk Reminders
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Single SMS Modal -->
<div class="modal fade" id="singleSmsModal" tabindex="-1" aria-labelledby="singleSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="singleSmsModalLabel">Send Payment Reminder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.fee-dashboard.send-single-notification') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> This will send an SMS reminder to the selected student.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Student</label>
                        <input type="text" class="form-control" id="sms_student_name" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="sms_phone" readonly>
                    </div>
                    
                    <div class="mb-3">
                        <label for="single_due_date" class="form-label">Due Date</label>
                        <input type="date" class="form-control" name="due_date" id="single_due_date" required min="{{ date('Y-m-d') }}">
                    </div>
                    
                    <div class="mb-3">
                        <label for="amount_due" class="form-label">Amount Due</label>
                        <div class="input-group">
                            <span class="input-group-text">KES</span>
                            <input type="text" class="form-control" id="amount_due" readonly>
                        </div>
                    </div>
                    
                    <input type="hidden" name="invoice_id" id="invoice_id">
                    
                    <div class="mb-3">
                        <label class="form-label">Message Preview</label>
                        <div class="card bg-light p-3">
                            <p id="singleMessagePreview"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-paper-plane"></i> Send Reminder
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Payment Status Pie Chart
        const paymentStatusData = @json($paymentStatus);
        const paymentStatusCtx = document.getElementById('paymentStatusChart').getContext('2d');
        
        if (paymentStatusCtx && Object.keys(paymentStatusData).length > 0) {
            new Chart(paymentStatusCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(paymentStatusData),
                    datasets: [{
                        data: Object.values(paymentStatusData).map(item => item.total_amount),
                        backgroundColor: [
                            '#4bc0c0', // Paid
                            '#36A2EB', // Partial
                            '#FF6384'  // Unpaid
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        } else {
            console.warn('Payment status data not available or canvas not found');
        }
        
        // Collection Trend Line Chart
        const trendData = @json($collectionTrend);
        const trendCtx = document.getElementById('collectionTrendChart').getContext('2d');
        
        if (trendCtx && trendData.length > 0) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => item.month),
                    datasets: [{
                        label: 'Amount Collected',
                        data: trendData.map(item => item.total_paid),
                        borderColor: '#4bc0c0',
                        backgroundColor: 'rgba(75, 192, 192, 0.1)',
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'KSh ' + value.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        } else {
            console.warn('Trend data not available or canvas not found');
        }

        // Bulk SMS Modal - Update message preview when due date changes
        document.getElementById('bulk_due_date')?.addEventListener('change', function() {
            const dueDate = this.value ? new Date(this.value).toLocaleDateString() : '[Due Date]';
            document.getElementById('bulkMessagePreview').textContent = 
                `Dear [Student Name] ([Student ID]), you have an outstanding fee balance of KES [Amount]. ` +
                `Please clear it by ${dueDate} to avoid penalties. For any queries, contact the accounts office.`;
        });
        
        // Faculty Invoices Bar Chart
const facultyInvoiceData = @json($facultyInvoices);
const facultyInvoiceCtx = document.getElementById('facultyInvoiceChart')?.getContext('2d');

if (facultyInvoiceCtx && facultyInvoiceData.length > 0) {
    new Chart(facultyInvoiceCtx, {
        type: 'bar',
        data: {
            labels: facultyInvoiceData.map(item => item.faculty),
            datasets: [
                {
                    label: 'Billed Amount',
                    data: facultyInvoiceData.map(item => item.billed),
                    backgroundColor: '#36A2EB'
                },
                {
                    label: 'Paid Amount',
                    data: facultyInvoiceData.map(item => item.paid),
                    backgroundColor: '#4BC0C0'
                },
                {
                    label: 'Outstanding',
                    data: facultyInvoiceData.map(item => item.outstanding),
                    backgroundColor: '#FF6384'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'KSh ' + value.toLocaleString();
                        }
                    }
                },
                x: {
                    stacked: false
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            label += 'KSh ' + context.raw.toLocaleString();
                            return label;
                        }
                    }
                }
            }
        }
    });
}
        // Single SMS Modal - Handle modal show event
const singleSmsModal = document.getElementById('singleSmsModal');
if (singleSmsModal) {
    singleSmsModal.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const invoiceId = button.getAttribute('data-invoice-id');
        const studentName = button.getAttribute('data-student-name');
        const studentId = button.getAttribute('data-student-id');
        const amountDue = button.getAttribute('data-amount-due');
        const phone = button.getAttribute('data-phone');

        document.getElementById('invoice_id').value = invoiceId;
        document.getElementById('sms_student_name').value = studentName;
        document.getElementById('sms_phone').value = phone;
        document.getElementById('amount_due').value = amountDue;

        // Initialize with current date
        const today = new Date();
        const nextWeek = new Date(today);
        nextWeek.setDate(today.getDate() + 7);
        const formattedDate = nextWeek.toISOString().split('T')[0];
        document.getElementById('single_due_date').value = formattedDate;

        updateSingleMessagePreview(studentName, studentId, amountDue, formattedDate);
    });
}

// Single SMS Modal - Update message preview when due date changes
document.getElementById('single_due_date')?.addEventListener('change', function() {
    const studentName = document.getElementById('sms_student_name').value;
    const studentId = document.querySelector('.send-sms-btn').getAttribute('data-student-id');
    const amountDue = document.getElementById('amount_due').value;
    const dueDate = this.value;
    updateSingleMessagePreview(studentName, studentId, amountDue, dueDate);
});

function updateSingleMessagePreview(studentName, studentId, amountDue, dueDate) {
    const formattedDueDate = dueDate ? new Date(dueDate).toLocaleDateString() : '[Due Date]';
    
    document.getElementById('singleMessagePreview').textContent = 
        `Dear ${studentName} (${studentId}), you have an outstanding fee balance of KES ${amountDue}. ` +
        `Please clear it by ${formattedDueDate} to avoid penalties. For any queries, contact the accounts office.`;
}
    });
</script>
@endpush