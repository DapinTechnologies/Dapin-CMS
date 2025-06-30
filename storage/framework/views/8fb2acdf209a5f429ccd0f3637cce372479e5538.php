

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1 class="mb-0" style="font-size: 1.5rem;">Fee Structure Details</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit fee structures')): ?>
            <a href="<?php echo e(route($route.'.edit', $feeStructure->id)); ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Fee Structure
            </a>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="row">
        <!-- Main Fee Structure Information -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" style="color: white;"><i class="fas fa-info-circle"></i> Basic Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box">
                                <span><i class="fas fa-university"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">FACULTY:</span>
                                    <span class="info-box-number"> <?php echo e($feeStructure->faculty->title ?? 'N/A'); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box">
                                <span><i class="fas fa-graduation-cap"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">COURSE:</span>
                                    <span class="info-box-number"> <?php echo e($feeStructure->program->title ?? 'N/A'); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span><i class="fas fa-calendar-alt"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">SEMESTER:</span>
                                    <span class="info-box-number"> <?php echo e($feeStructure->semester); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
    <div class="info-box">
        <span>
            <i class="fas fa-<?php echo e($feeStructure->is_active ? 'check' : 'times'); ?>"></i>
        </span>
        <div class="info-box-content">
            <span class="info-box-text">STATUS:</span>
            <span class="info-box-number <?php echo e($feeStructure->is_active ? 'text-success' : 'text-danger'); ?>">
                <?php if($feeStructure->is_active): ?>
                <span class="badge bg-success-light text-success mt-2 small"> <!-- Success hint -->
                    <i class="fas fa-check-circle me-1"></i> Currently Active
                </span>
            <?php else: ?>
                <span class="badge bg-danger-light text-danger mt-2 small"> <!-- Danger hint -->
                    <i class="fas fa-times-circle me-1"></i> Currently Inactive
                </span>
            <?php endif; ?>
            </span>
        </div>
    </div>
</div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-purple"><i class="fas fa-money-bill-wave"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">TOTAL FEE:</span>
                                    <span class="info-box-number"> Ksh <?php echo e(number_format($feeStructure->items->sum('amount'), 2)); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0" style="color: white;"><i class="fas fa-list"></i> Fee Items Breakdown</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="40%">Fees Type</th>
                                    <th width="25%">Amount (Ksh)</th>
                                    <th width="20%">Type</th>
                                    <th width="10%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $feeStructure->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($index + 1); ?></td>
                                        <td>
                                            <strong><?php echo e($item->fee_category_title); ?></strong>
                                            
                                        </td>
                                        <td><?php echo e(number_format($item->amount, 2)); ?></td>
                                        <td>
                                            <span class="badge badge-<?php echo e($item->is_one_time ? 'info' : 'warning'); ?>">
                                                <?php echo e($item->is_one_time ? 'One Time' : 'Recurring'); ?>

                                            </span>
                                        </td>
                                        <td>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('manage fee items')): ?>
                                            <button class="btn btn-sm btn-danger remove-item" data-id="<?php echo e($item->id); ?>">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <tr class="bg-light">
                                    <td colspan="2" class="text-right"><strong>Total</strong></td>
                                    <td><strong>Ksh <?php echo e(number_format($feeStructure->items->sum('amount'), 2)); ?></strong></td>
                                    <td colspan="2"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Summary and Statistics -->
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0" style="color: white;"><i class="fas fa-chart-pie"></i> Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="small-box bg-gradient-success mb-3">
                        <div class="inner">
                            <h3><?php echo e($studentCount); ?></h3>
                            <p>Students in <?php echo e($feeStructure->program->title ?? 'N/A'); ?>/<?php echo e($feeStructure->semester ?? 'N/A'); ?></p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-bs-toggle="modal" data-bs-target="#studentsModal">
                            View Students <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                    
                    <div class="small-box bg-gradient-primary mb-3">
                        <div class="inner">
                            <h3><?php echo e($invoiceCount); ?></h3>
                            <p>Invoices Sent</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-file-invoice-dollar"></i>
                        </div>
                        <a href="#" class="small-box-footer" data-bs-toggle="modal" data-bs-target="#invoicesModal">
                            View Invoices <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="small-box bg-gradient-danger">
                                <div class="inner">
                                    <h3><?php echo e($pendingPaymentCount); ?></h3>
                                    <p>Pending</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-exclamation-circle"></i>
                                </div>
                                <a href="#" class="small-box-footer" data-bs-toggle="modal" data-bs-target="#pendingInvoicesModal">
                                    View <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-gradient-warning">
                                <div class="inner">
                                    <h3><?php echo e($partialPaymentCount); ?></h3>
                                    <p>Partial Paid</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-money-bill-wave"></i>
                                </div>
                                <a href="#" class="small-box-footer" data-bs-toggle="modal" data-bs-target="#partialInvoicesModal">
                                    View <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="small-box bg-gradient-teal">
                                <div class="inner">
                                    <h3><?php echo e($paidCount); ?></h3>
                                    <p>Paid</p>
                                </div>
                                <div class="icon">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <a href="#" class="small-box-footer" data-bs-toggle="modal" data-bs-target="#paidInvoicesModal">
                                    View <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card mb-4">
    <div class="card-header bg-info text-white">
        <h5 class="mb-0" style="color: white;"><i class="fas fa-paper-plane"></i> Communication Summary</h5>
    </div>
    <div class="card-body">
        <div class="callout callout-info mb-3">
            <h5><i class="fas fa-sms"></i> SMS Notifications</h5>
            <p><?php echo e($smsCount); ?> messages sent to students</p>
            <small class="text-muted">Last sent: <?php echo e($lastSmsDate ? $lastSmsDate->format('d M Y H:i') : 'Never'); ?></small>
            <?php if($invoiceCount > 0): ?>
            <div class="mt-2">
                <button class="btn btn-sm btn-outline-primary send-bulk-sms" data-bs-toggle="modal" data-bs-target="#smsConfirmationModal" data-structure="<?php echo e($feeStructure->id); ?>">
                    <i class="fas fa-paper-plane"></i> Resend Bulk SMS
                </button>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="callout callout-success">
            <h5><i class="fas fa-envelope"></i> Email Notifications</h5>
            <p><?php echo e($emailCount); ?> emails sent to students</p>
            <small class="text-muted">Last sent: <?php echo e($lastEmailDate ? $lastEmailDate->format('d M Y H:i') : 'Never'); ?></small>
            <?php if($invoiceCount > 0): ?>
            <div class="mt-2">
                <button class="btn btn-sm btn-outline-success send-bulk-email" data-bs-toggle="modal" data-bs-target="#emailConfirmationModal" data-structure="<?php echo e($feeStructure->id); ?>">
                    <i class="fas fa-paper-plane"></i> Send Bulk Email Reminder
                </button>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
            
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0" style="color: white;"><i class="fas fa-history"></i> System Information</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Fee Structure Created
                            <span class="badge badge-primary badge-pill">
                                <?php echo e($feeStructure->created_at->format('d M Y, H:i')); ?>

                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Fee Structure Updated
                            <span class="badge badge-primary badge-pill">
                                <?php echo e($feeStructure->updated_at->format('d M Y, H:i')); ?>

                            </span>
                        </li>
                        <?php if($invoiceCount > 0): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            First Invoice Created
                            <span class="badge badge-primary badge-pill">
                                <?php echo e($firstInvoiceDate ? $firstInvoiceDate->format('d M Y, H:i') : 'N/A'); ?>

                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Last Invoice Created
                            <span class="badge badge-primary badge-pill">
                                <?php echo e($lastInvoiceDate ? $lastInvoiceDate->format('d M Y, H:i') : 'N/A'); ?>

                            </span>
                        </li>
                        <?php endif; ?>
                    </ul>
                    
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete fee structures')): ?>
<div class="mt-3 text-center">
    <!-- Button trigger modal (changed from direct form to modal trigger) -->
    <button type="button" class="btn btn-danger btn-block" data-bs-toggle="modal" data-bs-target="#deleteFeeStructureModal-<?php echo e($feeStructure->id); ?>">
        <i class="fas fa-trash"></i> Delete This Fee Structure
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteFeeStructureModal-<?php echo e($feeStructure->id); ?>" tabindex="-1" aria-labelledby="deleteFeeStructureModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteFeeStructureModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route($route.'.destroy', $feeStructure->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <div class="modal-body">
                    <p class="fw-bold">Are you sure you want to delete this fee structure?</p>
                    <p class="text-muted">This action cannot be undone. All related data will be permanently removed.</p>
                    
                    <div class="mb-3">
                        <label for="deleteReason-<?php echo e($feeStructure->id); ?>" class="form-label">
                            <i class="fas fa-comment-dots me-1"></i> Reason for deletion <span class="text-danger">*</span>
                        </label>
                        <textarea 
                            class="form-control" 
                            id="deleteReason-<?php echo e($feeStructure->id); ?>" 
                            name="delete_reason" 
                            rows="3" 
                            placeholder="Enter the reason for deletion (required)" 
                            required
                        ></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Confirm Delete
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Students Modal -->
<div class="modal fade" id="studentsModal" tabindex="-1" aria-labelledby="studentsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="studentsModalLabel">Students in <?php echo e($feeStructure->program->title ?? 'N/A'); ?>/<?php echo e($feeStructure->semester ?? 'N/A'); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($student->student_id); ?></td>
                                <td><?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></td>
                                <td><?php echo e($student->email); ?></td>
                                <td><?php echo e($student->phone); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- All Invoices Modal -->
<div class="modal fade" id="invoicesModal" tabindex="-1" aria-labelledby="invoicesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="invoicesModalLabel">All Invoices Issued</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Total Amount</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <a href="<?php echo e(route('fees.invoice.show', $invoice->id)); ?>" target="_blank">
                                        <?php echo e($invoice->invoice_no); ?>

                                    </a>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->first_name); ?> 
                                        <?php echo e($invoice->studentEnroll->student->last_name); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->student_id); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>Ksh <?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                <td>Ksh <?php echo e(number_format($invoice->amount_paid, 2)); ?></td>
                                <td>Ksh <?php echo e(number_format($invoice->total_fee - $invoice->amount_paid, 2)); ?></td>
                                <td><?php echo e($invoice->due_date ? $invoice->due_date : 'N/A'); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo e($invoice->payment_status == 'paid' ? 'success' : ($invoice->payment_status == 'partial' ? 'warning' : 'danger')); ?>">
                                        <?php echo e(ucfirst($invoice->payment_status)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($invoice->created_at->format('d M Y, H:i')); ?></td>
                                <td>
                                    <a href="<?php echo e(route('fees.invoice.show', $invoice->id)); ?>" class="btn btn-sm btn-info" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Paid Invoices Modal -->
<div class="modal fade" id="paidInvoicesModal" tabindex="-1" aria-labelledby="paidInvoicesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="paidInvoicesModalLabel">Fully Paid Invoices</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Total Amount</th>
                                <th>Amount Paid</th>
                                <th>Paid Date</th>
                                <th>Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $paidInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <a href="<?php echo e(route('fees.invoice.show', $invoice->id)); ?>" target="_blank">
                                        <?php echo e($invoice->invoice_no); ?>

                                    </a>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->first_name); ?> 
                                        <?php echo e($invoice->studentEnroll->student->last_name); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->student_id); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>Ksh <?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                <td>Ksh <?php echo e(number_format($invoice->amount_paid, 2)); ?></td>
                                <td><?php echo e($invoice->payment_date ? $invoice->payment_date->format('d M Y, H:i') : 'N/A'); ?></td>
                                <td><?php echo e($invoice->created_at->format('d M Y, H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Partial Paid Invoices Modal -->
<div class="modal fade" id="partialInvoicesModal" tabindex="-1" aria-labelledby="partialInvoicesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="partialInvoicesModalLabel">Partially Paid Invoices</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Total Amount</th>
                                <th>Amount Paid</th>
                                <th>Balance</th>
                                <th>Due Date</th>
                                <th>Last Payment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $partialInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <a href="<?php echo e(route('fees.invoice.show', $invoice->id)); ?>" target="_blank">
                                        <?php echo e($invoice->invoice_no); ?>

                                    </a>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->first_name); ?> 
                                        <?php echo e($invoice->studentEnroll->student->last_name); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->student_id); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>Ksh <?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                <td>Ksh <?php echo e(number_format($invoice->amount_paid, 2)); ?></td>
                                <td>Ksh <?php echo e(number_format($invoice->total_fee - $invoice->amount_paid, 2)); ?></td>
                                <td><?php echo e($invoice->due_date ? $invoice->due_date : 'N/A'); ?></td>
                                <td><?php echo e($invoice->payment_date ? $invoice->payment_date->format('d M Y, H:i') : 'N/A'); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Pending Invoices Modal -->
<div class="modal fade" id="pendingInvoicesModal" tabindex="-1" aria-labelledby="pendingInvoicesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="pendingInvoicesModalLabel">Pending Payment Invoices</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice No</th>
                                <th>Student</th>
                                <th>Student ID</th>
                                <th>Total Amount</th>
                                <th>Due Date</th>
                                <th>Days Overdue</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $pendingInvoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td>
                                    <a href="<?php echo e(route('fees.invoice.show', $invoice->id)); ?>" target="_blank">
                                        <?php echo e($invoice->invoice_no); ?>

                                    </a>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->first_name); ?> 
                                        <?php echo e($invoice->studentEnroll->student->last_name); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($invoice->studentEnroll && $invoice->studentEnroll->student): ?>
                                        <?php echo e($invoice->studentEnroll->student->student_id); ?>

                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td>Ksh <?php echo e(number_format($invoice->total_fee, 2)); ?></td>
                                <td><?php echo e($invoice->due_date ? $invoice->due_date : 'N/A'); ?></td>
                                <td>
                                    <?php if($invoice->due_date && $invoice->due_date < now()): ?>
                                        <span class="badge bg-danger">
                                            <?php echo e(now()->diffInDays($invoice->due_date)); ?> days
                                        </span>
                                    <?php elseif($invoice->due_date): ?>
                                        <span class="badge bg-info">
                                            Due in <?php echo e(now()->diffInDays($invoice->due_date)); ?> days
                                        </span>
                                    <?php else: ?>
                                        N/A
                                    <?php endif; ?>
                                </td>
                                <td><?php echo e($invoice->created_at->format('d M Y, H:i')); ?></td>
                                <td>
                                    <button class="btn btn-sm btn-warning send-reminder" data-invoice="<?php echo e($invoice->id); ?>" title="Send Reminder">
                                        <i class="fas fa-bell"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary send-bulk-reminders" data-structure="<?php echo e($feeStructure->id); ?>">
                    <i class="fas fa-bell"></i> Send Reminders to All
                </button>
            </div>
        </div>
    </div>
</div>

<!-- SMS Confirmation Modal -->
<div class="modal fade" id="smsConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Confirm SMS Notification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send SMS notifications to all students with unpaid invoices?</p>
                <div class="form-group mb-3">
                    <label for="smsMessage">Custom Message (optional):</label>
                    <textarea class="form-control" id="smsMessage" rows="3" placeholder="Enter your custom SMS message here"></textarea>
                    <small class="text-muted">Maximum 160 characters</small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary confirm-send-sms">
                    <i class="fas fa-paper-plane me-1"></i> Send SMS
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Email Confirmation Modal -->
<div class="modal fade" id="emailConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Confirm Email Notification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to send email notifications to all students with unpaid invoices?</p>
                <div class="form-group mb-3">
                    <label for="emailSubject">Subject:</label>
                    <input type="text" class="form-control" id="emailSubject" value="Fee Payment Reminder">
                </div>
                <div class="form-group">
                    <label for="emailMessage">Message:</label>
                    <textarea class="form-control" id="emailMessage" rows="5">Dear Student,

This is a reminder that you have an outstanding fee balance. Please make payment before the due date to avoid penalties.

Thank you,
Finance Department</textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success confirm-send-email">
                    <i class="fas fa-paper-plane me-1"></i> Send Email
                </button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function() {
    // Remove fee item
    $('.remove-item').click(function() {
        if(confirm('Are you sure you want to remove this fee item?')) {
            const itemId = $(this).data('id');
            $.ajax({
                url: '<?php echo e(route("admin.fee-structures.remove-item")); ?>',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    id: itemId
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    alert('Error removing item');
                }
            });
        }
    });

    // Send reminder for single invoice
    $('.send-reminder').click(function() {
        const invoiceId = $(this).data('invoice');
        if(confirm('Send payment reminder for this invoice?')) {
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    invoice_id: invoiceId
                },
                success: function(response) {
                    alert(response.message);
                },
                error: function(xhr) {
                    alert('Error sending reminder');
                }
            });
        }
    });

    // Bulk SMS button
    $('.send-bulk-sms').click(function() {
        $('#smsConfirmationModal').modal('show');
    });

    // Confirm bulk SMS
    $('.confirm-send-sms').click(function() {
        const structureId = $('.send-bulk-sms').data('structure');
        const message = $('#smsMessage').val();
        
        $.ajax({
            url: '',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                fee_structure_id: structureId,
                message: message
            },
            beforeSend: function() {
                $('.confirm-send-sms').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
            },
            success: function(response) {
                alert(response.message);
                $('#smsConfirmationModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error sending SMS: ' + xhr.responseJSON.message);
                $('.confirm-send-sms').prop('disabled', false).text('Send SMS');
            }
        });
    });

    // Bulk Email button
    $('.send-bulk-email').click(function() {
        $('#emailConfirmationModal').modal('show');
    });

    // Confirm bulk Email
    $('.confirm-send-email').click(function() {
        const structureId = $('.send-bulk-email').data('structure');
        const subject = $('#emailSubject').val();
        const message = $('#emailMessage').val();
        
        $.ajax({
            url: '',
            method: 'POST',
            data: {
                _token: '<?php echo e(csrf_token()); ?>',
                fee_structure_id: structureId,
                subject: subject,
                message: message
            },
            beforeSend: function() {
                $('.confirm-send-email').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
            },
            success: function(response) {
                alert(response.message);
                $('#emailConfirmationModal').modal('hide');
                location.reload();
            },
            error: function(xhr) {
                alert('Error sending email: ' + xhr.responseJSON.message);
                $('.confirm-send-email').prop('disabled', false).text('Send Email');
            }
        });
    });

    // Bulk reminders for pending invoices
    $('.send-bulk-reminders').click(function() {
        const structureId = $(this).data('structure');
        if(confirm('Send payment reminders to all students with pending invoices?')) {
            $.ajax({
                url: '',
                method: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>',
                    fee_structure_id: structureId
                },
                beforeSend: function() {
                    $('.send-bulk-reminders').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Sending...');
                },
                success: function(response) {
                    alert(response.message);
                    $('.send-bulk-reminders').prop('disabled', false).html('<i class="fas fa-bell"></i> Send Reminders to All');
                },
                error: function(xhr) {
                    alert('Error sending reminders');
                    $('.send-bulk-reminders').prop('disabled', false).html('<i class="fas fa-bell"></i> Send Reminders to All');
                }
            });
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fee-structures/show.blade.php ENDPATH**/ ?>