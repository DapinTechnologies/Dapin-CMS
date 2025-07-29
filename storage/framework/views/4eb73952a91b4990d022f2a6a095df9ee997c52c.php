<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
<style>
    #pieChart, #paymentStatusChart, #collectionTrendChart, #facultyInvoiceChart {
        max-width: 100% !important;
        max-height: 500px !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Fee Summary Cards ] start-->
            <div class="col-sm-6 col-md-6 col-xl-3">
                <div class="card bg-c-blue bitcoin-wallet">
                    <div class="card-block">
                        <h5 class="text-white mb-2">TOTAL BILLED FEES</h5>
                        <h4 class="text-white mb-2 f-w-100">KSh <?php echo e(number_format($totalBilled, 2)); ?></h4>
                        <i class="fas fa-file-invoice-dollar f-70 text-white"></i>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card bg-c-blue bitcoin-wallet">
        <div class="card-block">
            <h5 class="text-white mb-2">TOTAL RECONCILED FEES</h5>
            <h4 class="text-white mb-2 f-w-300">KSh <?php echo e(number_format($totalReconciledFees, 2)); ?></h4>
            <i class="fas fa-hand-holding-usd f-70 text-white"></i>
        </div>
    </div>
</div>

<div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card bg-c-blue bitcoin-wallet">
        <div class="card-block">
            <h5 class="text-white mb-2">TOTAL PAID FEES</h5>
            <h4 class="text-white mb-2 f-w-300">KSh <?php echo e(number_format($totalPaidFees, 2)); ?></h4>
            <i class="fas fa-money-bill-wave f-70 text-white"></i>
        </div>
    </div>
</div>
            <div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card bg-c-blue bitcoin-wallet">
        <div class="card-block">
            <h5 class="text-white mb-2">OUTSTANDING FEES</h5>
            <h4 class="text-white mb-2 f-w-300">KSh <?php echo e(number_format($outstanding, 2)); ?></h4>
            
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send fee notifications')): ?>
            <div class="d-flex justify-content-between align-items-end">
                <i class="fas fa-exclamation-triangle f-70 text-white"></i>
                <button class="btn btn-success btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#bulkSmsModal">
                    <i class=" me-1"></i> Send SMS Reminder
                </button>
            </div>
            <?php else: ?>
            <i class="fas fa-paper-plane f-70 text-white"></i>
            <?php endif; ?>
        </div>
    </div>
</div>
            <div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card bg-c-blue bitcoin-wallet">
        <div class="card-block">
            <h5 class="text-white mb-2">RECONCILED BURSARIES</h5>
            <h4 class="text-white mb-2 f-w-300">KSh <?php echo e(number_format($totalReconciledBursaries, 2)); ?></h4>
            <i class="fas fa-gift f-70 text-white"></i>
        </div>
    </div>
</div>

<!-- Total Discounts Card -->
<div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card bg-c-blue bitcoin-wallet">
        <div class="card-block">
            <h5 class="text-white mb-2">TOTAL DISCOUNTS GIVEN</h5>
            <h4 class="text-white mb-2 f-w-300">KSh <?php echo e(number_format($totalDiscounts, 2)); ?></h4>
            <i class="fas fa-tag f-70 text-white"></i>
        </div>
    </div>
</div>

<!-- Total Fines Card -->
<div class="col-sm-6 col-md-6 col-xl-3">
    <div class="card bg-c-blue bitcoin-wallet">
        <div class="card-block">
            <h5 class="text-white mb-2">TOTAL FINES APPLIED</h5>
            <h4 class="text-white mb-2 f-w-300">KSh <?php echo e(number_format($totalFines, 2)); ?></h4>
            <i class="fas fa-exclamation-triangle f-70 text-white"></i>
        </div>
    </div>
</div>
            <!-- [ Fee Summary Cards ] end-->
        </div>

        <!-- Filters -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Filters</h5>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="<?php echo e(route('admin.fee-dashboard.index')); ?>">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="faculty" class="form-label">Faculty</label>
                                        <select class="form-control select2" id="faculty" name="faculty">
                                            <option value="">All Faculties</option>
                                            <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($faculty->id); ?>" <?php echo e(request('faculty') == $faculty->id ? 'selected' : ''); ?>>
                                                    <?php echo e($faculty->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="semester" class="form-label">Semester</label>
                                        <select class="form-control select2" id="semester" name="semester">
                                            <option value="">All Semesters</option>
                                            <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($semester->id); ?>" <?php echo e(request('semester') == $semester->id ? 'selected' : ''); ?>>
                                                    <?php echo e($semester->title); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo e(request('start_date')); ?>">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo e(request('end_date')); ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-primary me-2">Apply Filters</button>
                                <a href="<?php echo e(route('admin.fee-dashboard.index')); ?>" class="btn btn-outline-secondary">Reset</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 1 -->
        <div class="row">
            <div class="col-12 col-md-6 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Payment Status Distribution</h5>
                    </div>
                    <div class="card-block">
                        <canvas id="paymentStatusChart" height="300"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Fee Collection Trend</h5>
                    </div>
                    <div class="card-block">
                        <canvas id="collectionTrendChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row 2 -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Faculty-wise Fee Collection</h5>
                    </div>
                    <div class="card-block">
                        <canvas id="facultyInvoiceChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Invoice Table -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Fee Collection Details</h5>
                    </div>
                    <div class="card-block">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Inv No</th>
                                    <th>Student Name</th>
                                    <th>Course</th>
                                    <th>Invoiced Amount</th>
                                    <th>Paid Amount</th>
                                    <th>Status</th>
                                    <th>Due Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($invoice->invoice_no); ?></td>
                                        <td><?php echo e($invoice->studentEnroll->student->full_name ?? 'N/A'); ?></td>
                                        <td><?php echo e($invoice->studentEnroll->program->title ?? 'N/A'); ?></td>
                                        <td>KSh <?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                        <td>KSh <?php echo e($invoicePayments[$invoice->id] ?? 0); ?></td>
                                        
                                        <td>
                                            <?php if($invoice->payment_status == 'paid'): ?>
                                                <span class="badge bg-success">Paid</span>
                                            <?php elseif($invoice->payment_status == 'partial'): ?>
                                                <span class="badge bg-warning">Partial</span>
                                            <?php else: ?>
                                                <span class="badge bg-danger">Unpaid</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($invoice->due_date); ?></td>
                                        <td>
                                            
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('send fee notifications')): ?>
                                            <?php if($invoice->payment_status != 'paid'): ?>
                                            <button class="btn btn-sm btn-warning send-sms-btn" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#singleSmsModal"
                                                data-invoice-id="<?php echo e($invoice->id); ?>"
                                                data-student-name="<?php echo e($invoice->studentEnroll->student->full_name ?? 'N/A'); ?>"
                                                data-student-id="<?php echo e($invoice->studentEnroll->student->student_id ?? ''); ?>"
                                                data-amount-due="<?php echo e(number_format($invoice->amount_due, 2)); ?>"
                                                data-phone="<?php echo e($invoice->studentEnroll->student->phone ?? ''); ?>">
                                                <i class="fas fa-envelope"></i> Send SMS
                                            </button>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<!-- Bulk SMS Modal -->
<div class="modal fade" id="bulkSmsModal" tabindex="-1" aria-labelledby="bulkSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="bulkSmsModalLabel">Send Bulk Payment Reminders</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.fee-dashboard.send-notifications')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> This will send SMS reminders to all students with outstanding fees matching your current filters.
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="bulk_due_date" class="form-label">New Due Date</label>
                            <input type="date" class="form-control" id="bulk_due_date" name="due_date" required min="<?php echo e(date('Y-m-d')); ?>">
                            <small class="text-muted">Set a new due date for the payment</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Current Filters</label>
                            <div class="form-control bg-light">
                                <?php if(request('faculty')): ?>
                                    Faculty: <?php echo e($faculties->firstWhere('id', request('faculty'))->title ?? 'All'); ?><br>
                                <?php endif; ?>
                                <?php if(request('semester')): ?>
                                    Semester: <?php echo e($semesters->firstWhere('id', request('semester'))->title ?? 'All'); ?><br>
                                <?php endif; ?>
                                <?php if(request('start_date') && request('end_date')): ?>
                                    Date Range: <?php echo e(request('start_date')); ?> to <?php echo e(request('end_date')); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <input type="hidden" name="faculty" value="<?php echo e(request('faculty')); ?>">
                    <input type="hidden" name="semester" value="<?php echo e(request('semester')); ?>">
                    <input type="hidden" name="start_date" value="<?php echo e(request('start_date')); ?>">
                    <input type="hidden" name="end_date" value="<?php echo e(request('end_date')); ?>">
                    
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
            <form action="<?php echo e(route('admin.fee-dashboard.send-single-notification')); ?>" method="POST">
                <?php echo csrf_field(); ?>
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
                        <input type="date" class="form-control" name="due_date" id="single_due_date" required min="<?php echo e(date('Y-m-d')); ?>">
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
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<!-- chart Js -->
<script src="<?php echo e(asset('dashboard/plugins/chart-chartjs/js/chart.min.js')); ?>"></script>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Payment Status Pie Chart
        const paymentStatusData = <?php echo json_encode($paymentStatus, 15, 512) ?>;
        const paymentStatusCtx = document.getElementById('paymentStatusChart')?.getContext('2d');
        
        if (paymentStatusCtx && Object.keys(paymentStatusData).length > 0) {
            new Chart(paymentStatusCtx, {
                type: 'pie',
                data: {
                    labels: Object.keys(paymentStatusData),
                    datasets: [{
                        data: Object.values(paymentStatusData).map(item => item.total_amount),
                        backgroundColor: [
                            '#1de9b6', // Paid
                            '#f4c22b', // Partial
                            '#f44236'  // Unpaid
                        ],
                        borderColor: [
                            '#14cc9e',
                            '#ecb50c',
                            '#f22012'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    const label = context.label || '';
                                    const value = context.raw || 0;
                                    const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    const percentage = Math.round((value / total) * 100);
                                    return `${label}: KSh ${value.toLocaleString()} (${percentage}%)`;
                                }
                            }
                        }
                    }
                }
            });
        }

        // Collection Trend Line Chart
        const trendData = <?php echo json_encode($collectionTrend, 15, 512) ?>;
        const trendCtx = document.getElementById('collectionTrendChart')?.getContext('2d');
        
        if (trendCtx && trendData.length > 0) {
            new Chart(trendCtx, {
                type: 'line',
                data: {
                    labels: trendData.map(item => item.month),
                    datasets: [{
                        label: 'Amount Collected',
                        data: trendData.map(item => item.total_paid),
                        backgroundColor: 'rgba(4, 169, 245, 0.2)',
                        borderColor: '#04a9f5',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
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
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'KSh ' + context.raw.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Faculty Invoices Bar Chart
        const facultyInvoiceData = <?php echo json_encode($facultyInvoices, 15, 512) ?>;
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
                            backgroundColor: '#04a9f5',
                            borderColor: '#038fcf'
                        },
                        {
                            label: 'Paid Amount',
                            data: facultyInvoiceData.map(item => item.paid),
                            backgroundColor: '#1de9b6',
                            borderColor: '#14cc9e'
                        },
                        {
                            label: 'Outstanding',
                            data: facultyInvoiceData.map(item => item.outstanding),
                            backgroundColor: '#f44236',
                            borderColor: '#f22012'
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
                        }
                    },
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': KSh ' + context.raw.toLocaleString();
                                }
                            }
                        }
                    }
                }
            });
        }

        // Bulk SMS Modal - Update message preview when due date changes
        document.getElementById('bulk_due_date')?.addEventListener('change', function() {
            const dueDate = this.value ? new Date(this.value).toLocaleDateString() : '[Due Date]';
            document.getElementById('bulkMessagePreview').textContent = 
                `Dear [Student Name] ([Student ID]), you have an outstanding fee balance of KES [Amount]. ` +
                `Please clear it by ${dueDate} to avoid penalties. For any queries, contact the accounts office.`;
        });
        
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/fee-dashboard/index.blade.php ENDPATH**/ ?>