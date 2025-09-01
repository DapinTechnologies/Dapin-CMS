

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;"><?php echo e($title); ?></h1>
    
    <!-- Filter/Search Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter/Search Payments</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route($route.'.index')); ?>" method="GET" id="filterForm">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="faculty">Faculty</label>
                            <select name="faculty" id="faculty" class="form-control">
                                <option value="">All Faculties</option>
                                <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($faculty->id); ?>" <?php echo e($selected_faculty == $faculty->id ? 'selected' : ''); ?>>
                                        <?php echo e($faculty->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="program">Program</label>
                            <select name="program" id="program" class="form-control">
                                <option value="">All Programs</option>
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program->id); ?>" <?php echo e($selected_program == $program->id ? 'selected' : ''); ?>>
                                        <?php echo e($program->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="">All Semesters</option>
                                <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($semester->id); ?>" <?php echo e($selected_semester == $semester->id ? 'selected' : ''); ?>>
                                        <?php echo e($semester->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select name="payment_method" id="payment_method" class="form-control">
                                <option value="">All Methods</option>
                                <option value="mpesa" <?php echo e($selected_payment_method == 'mpesa' ? 'selected' : ''); ?>>M-Pesa</option>
                                <option value="bank" <?php echo e($selected_payment_method == 'bank' ? 'selected' : ''); ?>>Bank</option>
                                <option value="cash" <?php echo e($selected_payment_method == 'cash' ? 'selected' : ''); ?>>Cash</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="status">Payment Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="">All Statuses</option>
                                <option value="pending" <?php echo e($selected_status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                                <option value="completed" <?php echo e($selected_status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                                <option value="failed" <?php echo e($selected_status == 'failed' ? 'selected' : ''); ?>>Failed</option>
                                <option value="partial" <?php echo e($selected_status == 'partial' ? 'selected' : ''); ?>>Partial</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="reconciled">Reconciliation Status</label>
                            <select name="reconciled" id="reconciled" class="form-control">
                                <option value="">All</option>
                                <option value="yes" <?php echo e($selected_reconciled == 'yes' ? 'selected' : ''); ?>>Reconciled</option>
                                <option value="no" <?php echo e($selected_reconciled == 'no' ? 'selected' : ''); ?>>Not Reconciled</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo e($start_date); ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo e($end_date); ?>">
                        </div>
                    </div>
                    <!-- 
<div class="col-md-3">
    <div class="form-group">
        <label for="search">Search (ID/Name/Reference)</label>
        <input type="text" name="search" id="search" class="form-control" value="<?php echo e($search_term); ?>" placeholder="Student ID/Name/Reference">
    </div>
</div>
-->

                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary mr-2" id="filterButton">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            
             <!-- Left side - Summary Stats -->
        <div class="d-flex align-items-center mb-2 mb-md-0">
            <h5 class="mb-0 me-3">Real-Time Payment Records</h5>
            
            <!-- Summary Cards - Horizontal Layout -->
            <div class="d-flex reconciliation-stats">
                <!-- Completed -->
                <div class="stat-card me-3">
                    <div class="stat-content bg-success bg-opacity-10 p-2 rounded-3 border-start border-4 border-success">
                        <div class="stat-title text-muted small">Completed</div>
                        <div class="stat-value text-black fw-bold"><?php echo e($payments->where('is_reconciled', 1)->count()); ?></div>
                    </div>
                </div>
                
                <!-- Not Reconciled -->
                <div class="stat-card me-3">
                    <div class="stat-content bg-warning bg-opacity-10 p-2 rounded-3 border-start border-4 border-warning">
                        <div class="stat-title text-muted small">Pending</div>
                        <div class="stat-value text-black fw-bold"><?php echo e($payments->where('is_reconciled', 0)->count()); ?></div>
                    </div>
                </div>
                
                <!-- To Check -->
                <div class="stat-card">
                    <div class="stat-content bg-danger bg-opacity-10 p-2 rounded-3 border-start border-4 border-danger">
                        <div class="stat-title text-muted small">To Check</div>
                        <div class="stat-value text-dark fw-bold"><?php echo e($payments->where('is_reconciled', 2)->count()); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 relative">
    <input 
        type="text" 
        class="form-control search-input ps-5 rounded-pill shadow-sm border-0" 
        placeholder="🔍 Quick Search..."
        style="max-width: 300px;"
    >
</div>

            <div>
                <button type="button" class="btn btn-primary btn-sm" id="batchReconcileBtn" data-bs-toggle="modal" data-bs-target="#batchReconcileModal">
                    <i class="fas fa-check-double"></i> Batch Reconcile
                </button>
                 
                 <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('export fee reconciliation')): ?>
                        <a href="<?php echo e(route($route.'.export')); ?>?<?php echo e(http_build_query(request()->query())); ?>" class="btn btn-info ml-2">
                            <i class="fas fa-file-export"></i> Export
                        </a>
                        <?php endif; ?>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="paymentsTable">
                    <thead class="thead-light blue">
                        <tr>
                            <th width="3%">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th width="5%">#</th>
                            <th>Student Name</th>
                            <th>Course / Faculty</th>
                            <th>Semester</th>
                            <th>Amount</th>
                            <th>Method</th>
                            <th>Reference Code</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Reconciled</th>
                           
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="payment-checkbox" value="<?php echo e($payment->id); ?>" <?php echo e($payment->is_reconciled ? 'disabled' : ''); ?>>
                                </td>
                                <td><?php echo e($key + 1); ?></td>
                                <td>
                                    <?php echo e($payment->studentEnroll->student->full_name ?? 'N/A'); ?>

                                    <br>
                                    <small class="text-muted">ID: <?php echo e($payment->studentEnroll->student->student_id ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <?php echo e($payment->studentEnroll->program->title ?? 'N/A'); ?>

                                    <br>
                                    <small class="text-muted"><?php echo e($payment->studentEnroll->program->faculty->title ?? ''); ?></small>
                                </td>
                                <td><?php echo e($payment->studentEnroll->semester_id ?? 'N/A'); ?></td>
                                <td><?php echo e(number_format($payment->amount, 2)); ?></td>
                                <td>
                                
    <?php if($payment->is_bursary): ?>
        <span class="badge bg-info">BURSARY</span>
        <?php if($payment->bursary_type): ?>
            <br><small class="text-muted"><?php echo e($payment->bursary_type); ?></small>
        <?php endif; ?>
    <?php else: ?>
        <span class="badge bg-<?php echo e($payment->payment_method == 'mpesa' ? 'success' : ($payment->payment_method == 'bank' ? 'primary' : 'warning')); ?>">
            <?php echo e(strtoupper($payment->payment_method)); ?>

        </span>
    <?php endif; ?>

                                </td>
                                <td>
                                    <?php if($payment->payment_method == 'mpesa'): ?>
                                        <?php echo e($payment->transaction_id); ?>

                                    <?php else: ?>
                                        <?php echo e($payment->reference_number); ?>

                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($payment->payment_date): ?>
                                        <?php echo e($payment->payment_date->format('d M Y')); ?><br>
                                        <?php echo e($payment->payment_date->format('h:i A')); ?>

                                    <?php elseif($payment->created_at): ?>
                                        <?php echo e($payment->created_at->format('d M Y')); ?><br>
                                        <?php echo e($payment->created_at->format('h:i A')); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($payment->is_installment): ?>
                                        <span class="badge bg-info">Partial - <?php echo e($payment->installment_number); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-primary">Full Payment</span>
                                    <?php endif; ?>
                                </td>
                                <td>
    <?php if($payment->is_reconciled === 1): ?>
        <span class="badge bg-success">Completed</span>
        <br>
        
        <br>
        <small>
            <?php if($payment->reconciled_at): ?>
                <?php echo e(\Carbon\Carbon::parse($payment->reconciled_at)->format('d M Y H:i')); ?>

            <?php else: ?>
                N/A
            <?php endif; ?>
        </small>
    <?php elseif($payment->is_reconciled === 2): ?>
        <span class="badge bg-danger">To Check</span>
        <br>
        
        <br>
        <small>
            <?php if($payment->reconciled_at): ?>
                <?php echo e(\Carbon\Carbon::parse($payment->reconciled_at)->format('d M Y H:i')); ?>

            <?php else: ?>
                N/A
            <?php endif; ?>
        </small>
    <?php else: ?>
        <span class="badge bg-warning">Not Reconciled</span>
    <?php endif; ?>
</td>
                                
<td>
    <?php if(!$payment->is_reconciled || $payment->is_reconciled === 2): ?>
        <button type="button" 
                class="btn btn-success btn-sm reconcile-btn" 
                data-bs-toggle="modal" 
                data-bs-target="#reconcileModal-<?php echo e($payment->id); ?>"
                title="Reconcile Payment">
            <i class="fas fa-check-circle"></i> Reconcile
        </button>
    <?php else: ?>
        <span class="text-muted"><i class="fas fa-check-circle"></i> Reconciled</span>
        <br>
        
    <?php endif; ?>
</td>
                            </tr>

                            <!-- Reconcile Modal -->
                            <div class="modal fade" id="reconcileModal-<?php echo e($payment->id); ?>" tabindex="-1" aria-labelledby="reconcileModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="reconcileModalLabel">
                                                <i class="fas fa-check-circle me-2"></i> Reconcile Payment
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="<?php echo e(route($route.'.reconcile', $payment->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <h6>Received Payment Details Overview</h6>
                                                    <hr>
                                                    <p><strong>Student Name:</strong> <?php echo e($payment->studentEnroll->student->full_name ?? 'N/A'); ?></p>
                                                    <p><strong>Amount Paid:</strong> <?php echo e(number_format($payment->amount, 2)); ?></p>
                                                    <p><strong>Payment Method:</strong> <p><strong>Payment Method:</strong> 
    <?php if($payment->is_bursary): ?>
        BURSARY
        <?php if($payment->bursary_type): ?>
            (<?php echo e($payment->bursary_type); ?>)
        <?php endif; ?>
    <?php else: ?>
        <?php echo e(strtoupper($payment->payment_method)); ?>

    <?php endif; ?>
</p>
                                                    <p><strong>Payment Reference Number:</strong> 
                                                        <?php if($payment->payment_method == 'mpesa'): ?>
                                        <?php echo e($payment->transaction_id); ?>

                                    <?php else: ?>
                                        <?php echo e($payment->reference_number); ?>

                                    <?php endif; ?>
                                                    </p>
                                                    <p><strong>Payment Receipt Code:</strong> <?php echo e($payment->transaction_id ?? $payment->reference_number ?? 'N/A'); ?></p>
                                                    <p><strong>Date of Payment:</strong> <?php if($payment->payment_date): ?>
        <?php echo e($payment->payment_date->format('d M Y')); ?>

    <?php elseif($payment->created_at): ?>
        <?php echo e($payment->created_at->format('d M Y')); ?> 
    <?php else: ?>
        N/A
    <?php endif; ?></p>
                                                </div>

                                                <div class="form-group mb-3">
    <label for="reconciliation_status-<?php echo e($payment->id); ?>" class="fw-bold">Reconciliation Status</label>
    <select name="reconciliation_status" id="reconciliation_status-<?php echo e($payment->id); ?>" class="form-control" required>
        <option value="1">Completed</option>
        <option value="2">To Check</option>
    </select>
</div>

                                                <div class="form-group mb-3">
                                                    <label for="confirmation_date-<?php echo e($payment->id); ?>" class="fw-bold">Confirmation Date</label>
                                                    <input type="date" 
                                                           name="confirmation_date" 
                                                           id="confirmation_date-<?php echo e($payment->id); ?>" 
                                                           class="form-control" 
                                                           value="<?php echo e(date('Y-m-d')); ?>" 
                                                           max="<?php echo e(date('Y-m-d')); ?>"
                                                           required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="confirmation_time-<?php echo e($payment->id); ?>" class="fw-bold">Confirmation Time</label>
                                                    <input type="time" 
                                                           name="confirmation_time" 
                                                           id="confirmation_time-<?php echo e($payment->id); ?>" 
                                                           class="form-control" 
                                                           value="<?php echo e(date('H:i')); ?>"
                                                           required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="reconciliation_notes-<?php echo e($payment->id); ?>" class="fw-bold">Reconciliation Notes</label>
                                                    <textarea name="reconciliation_notes" 
                                                              id="reconciliation_notes-<?php echo e($payment->id); ?>" 
                                                              class="form-control" 
                                                              rows="3" 
                                                              placeholder="Any notes about this reconciliation"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i> Cancel
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-check-circle me-1"></i> Confirm Reconciliation
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="14" class="text-center">No payment records found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($payments->hasPages()): ?>
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($payments->appends(request()->query())->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Batch Reconcile Modal -->
<div class="modal fade" id="batchReconcileModal" tabindex="-1" aria-labelledby="batchReconcileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="batchReconcileModalLabel">
                    <i class="fas fa-check-double me-2"></i> Batch Reconcile Payments
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route($route.'.batch-reconcile')); ?>" method="POST" id="batchReconcileForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> You are about to reconcile <span id="selectedCount">0</span> payments.
                    </div>

                    <div class="mb-3">
                        <label for="batch_status" class="fw-bold">Reconciliation Status</label>
                        <select name="status" id="batch_status" class="form-control" required>
                            <option value="completed">Completed</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="batch_confirmation_date" class="fw-bold">Confirmation Date</label>
                        <input type="date" 
                               name="confirmation_date" 
                               id="batch_confirmation_date" 
                               class="form-control" 
                               value="<?php echo e(date('Y-m-d')); ?>" 
                               max="<?php echo e(date('Y-m-d')); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="batch_confirmation_time" class="fw-bold">Confirmation Time</label>
                        <input type="time" 
                               name="confirmation_time" 
                               id="batch_confirmation_time" 
                               class="form-control" 
                               value="<?php echo e(date('H:i')); ?>"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="batch_reconciliation_notes" class="fw-bold">Reconciliation Notes</label>
                        <textarea name="reconciliation_notes" 
                                id="batch_reconciliation_notes" 
                                class="form-control" 
                                rows="3" 
                                placeholder="Any notes about this reconciliation"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check-double me-1"></i> Confirm Batch Reconciliation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('scripts'); ?>
<script>
$(document).ready(function() {
    // Faculty-Program dependency
    $('#faculty').change(function() {
        var facultyId = $(this).val();
        if(facultyId) {
            $.ajax({
                url: '/admin/get-programs/' + facultyId,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#program').empty();
                    $('#program').append('<option value="">All Programs</option>');
                    $.each(data, function(key, value) {
                        $('#program').append('<option value="'+ key +'">'+ value +'</option>');
                    });
                }
            });
        } else {
            $('#program').empty();
            $('#program').append('<option value="">All Programs</option>');
        }
    });

    // Ensure filter form submits correctly
    $('#filterForm').on('submit', function(e) {
        // Remove empty values to keep URL clean
        $(this).find('select, input').each(function() {
            if (!$(this).val()) {
                $(this).prop('disabled', true);
            }
        });
    });

    // Select all checkboxes
    $('#selectAll').click(function() {
        $('.payment-checkbox:not(:disabled)').prop('checked', $(this).prop('checked'));
        updateBatchReconcileButton();
    });

    // Update batch reconcile button when checkboxes change
    $(document).on('change', '.payment-checkbox', function() {
        updateBatchReconcileButton();
    });

    function updateBatchReconcileButton() {
        var checkedCount = $('.payment-checkbox:checked').length;
        $('#batchReconcileBtn').prop('disabled', checkedCount === 0);
        $('#selectedCount').text(checkedCount);
        
        // Update hidden inputs for selected payments
        $('#batchReconcileForm').find('input[name="payment_ids[]"]').remove();
        $('.payment-checkbox:checked').each(function() {
            $('#batchReconcileForm').append(
                $('<input>').attr({
                    type: 'hidden',
                    name: 'payment_ids[]',
                    value: $(this).val()
                })
            );
        });
    }

    // Initialize date pickers
    $('input[type="date"]').each(function() {
        $(this).attr('max', new Date().toISOString().split('T')[0]);
    });
});
</script>
<?php $__env->stopSection(); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.querySelector(".search-input");
    const table = document.getElementById("paymentsTable");

    if (searchInput && table) {
        searchInput.addEventListener("keyup", function () {
            const filter = this.value.toLowerCase();
            const rows = table.querySelectorAll("tbody tr");

            rows.forEach(row => {
                // Only touch display property, nothing else
                if (row.textContent.toLowerCase().includes(filter)) {
                    row.style.display = ""; // show row
                } else {
                    row.style.display = "none"; // hide row
                }
            });
        });
    }
});
</script>
<style>
#paymentsTable {
    font-size: 14px;  /* lock font size */
    font-family: Arial, sans-serif; /* optional: lock font family */
}
</style>


<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fee-reconciliation/index.blade.php ENDPATH**/ ?>