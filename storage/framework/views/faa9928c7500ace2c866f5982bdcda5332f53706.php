<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?php echo e($title); ?></h1>
        <div>
            <button type="button" class="btn btn-success mr-2" data-bs-toggle="modal" data-bs-target="#bursaryFundModal">
                <i class="fas fa-plus-circle fa-sm text-white-100"></i> Create Bursary Fund
            </button>
            <button type="button" class="btn btn-info mr-2" data-bs-toggle="modal" data-bs-target="#batchBursaryModal">
                <i class="fas fa-users fa-sm text-white-100"></i> Batch / Single Allocation
            </button>
            <a href="<?php echo e(route($route.'.create')); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-plus-circle fa-sm text-white-100"></i> Category Allocation
            </a>
        </div>
    </div>

    <!-- Filter/Search Form -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold text-white">Filter/Search Bursary Allocations</h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route($route.'.index')); ?>" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="faculty">Faculty</label>
                            <select name="faculty" id="faculty" class="form-control select2">
                                <option value="0">All Faculties</option>
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
                            <select name="program" id="program" class="form-control select2">
                                <option value="0">All Programs</option>
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
                            <label for="bursary_type">Bursary Type</label>
                            <select name="bursary_type" id="bursary_type" class="form-control select2">
                                <option value="">All Types</option>
                                <?php $__currentLoopData = $bursaryTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->code); ?>" <?php echo e($selected_bursary_type == $type->code ? 'selected' : ''); ?>>
                                        <?php echo e($type->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="search">Search (ID/Name)</label>
                            <input type="text" name="search" id="search" class="form-control" value="<?php echo e($search_term); ?>" placeholder="Student ID/Name">
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('export bursary allocations')): ?>
                        <a href="<?php echo e(route($route.'.export')); ?>?<?php echo e(http_build_query(request()->query())); ?>" class="btn btn-info ml-2">
                            <i class="fas fa-file-export"></i> Export
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bursary Allocations Table -->
    <div class="card shadow">
        <div class="card-header py-3 d-flex justify-content-between align-items-center bg-primary text-white">
            <h6 class="m-0 font-weight-bold text-white">Bursary Allocation Records</h6>
            <div>
                <button type="button" class="btn btn-light btn-sm" id="batchReconcileBtn" data-bs-toggle="modal" data-bs-target="#batchReconcileModal">
                    <i class="fas fa-check-double"></i> Batch Reconcile
                </button>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="bursariesTable" width="100%" cellspacing="0">
                    <thead class="thead-light blue">
                        <tr>
                            <th width="3%">
                                <input type="checkbox" id="selectAll">
                            </th>
                            <th>#</th>
                            <th>Student Details</th>
                            <th>Program Details</th>
                            <th>Invoice No</th>
                            <th>Amount</th>
                            <th>Excess</th>
                            <th>Bursary Type</th>
                            <th>Allocated On</th>
                            
                            <th>Reconciled</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $bursaries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $bursary): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
    <input type="checkbox" 
           class="bursary-checkbox" 
           value="<?php echo e($bursary->id); ?>"
           data-student-name="<?php echo e($bursary->studentEnroll->student->full_name ?? 'N/A'); ?>"
           data-amount="<?php echo e(number_format($bursary->amount, 2)); ?>"
           data-bursary-type="<?php echo e($bursaryTypes->firstWhere('code', $bursary->bursary_type)->name ?? $bursary->bursary_type); ?>"
           <?php echo e($bursary->is_reconciled ? 'disabled' : ''); ?>>
</td>
                                <td><?php echo e($key + 1); ?></td>
                                <td>
                                    <strong><?php echo e($bursary->studentEnroll->student->full_name ?? 'N/A'); ?></strong>
                                    <br>
                                    <small class="text-muted">ID: <?php echo e($bursary->studentEnroll->student->student_id ?? 'N/A'); ?></small>
                                </td>
                                <td>
                                    <?php echo e($bursary->studentEnroll->program->title ?? 'N/A'); ?>

                                    <br>
                                    <small class="text-muted"><?php echo e($bursary->studentEnroll->program->faculty->title ?? ''); ?></small>
                                </td>
                                <td>
                                    <?php echo e($bursary->invoice->invoice_no ?? 'N/A'); ?>

                                </td>
                                <td class="text-success font-weight-bold">
                                    <?php echo e(number_format($bursary->amount, 2)); ?>

                                </td>
                                <td class="text-danger font-weight-bold">
                                    <?php echo e(number_format($bursary->excess_payment, 2)); ?>

                                </td>
                                <td>
                                    <span class="badge bg-<?php echo e($bursary->bursary_type == 'GOVT' ? 'primary' : ($bursary->bursary_type == 'UNIV' ? 'info' : ($bursary->bursary_type == 'DONOR' ? 'success' : 'warning'))); ?>">
                                        <?php echo e($bursaryTypes->firstWhere('code', $bursary->bursary_type)->name ?? $bursary->bursary_type); ?>

                                    </span>
                                </td>
                                <td>
    <?php echo e($bursary->bursary_allocated_at ? $bursary->bursary_allocated_at->format('d M Y') : 'N/A'); ?><br>
    <?php echo e($bursary->bursary_allocated_at ? $bursary->bursary_allocated_at->format('H:i') : ''); ?>

</td>
                               
                                <td>
                                    <?php if($bursary->is_reconciled === 1): ?>
                                        <span class="badge bg-success">Completed</span>
                                        <br>
                                        <small><?php echo e($bursary->reconciled_by); ?></small>
                                        <br>
                                        <small><?php echo e($bursary->reconciled_at ? $bursary->reconciled_at->format('d M Y H:i') : 'N/A'); ?></small> <br>
                                    <?php elseif($bursary->is_reconciled === 2): ?>
                                        <span class="badge bg-danger">To Check</span>
                                        <br>
                                        <small><?php echo e($bursary->reconciled_by); ?></small>
                                        <br>
                                        <small><?php echo e($bursary->reconciled_at ? $bursary->reconciled_at->format('d M Y H:i') : 'N/A'); ?></small>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Not Reconciled</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <?php if(!$bursary->is_reconciled || $bursary->is_reconciled === 2): ?>
                                            <button type="button" 
                                                    class="btn btn-success btn-sm reconcile-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#reconcileModal-<?php echo e($bursary->id); ?>"
                                                    title="Reconcile Bursary">
                                                <i class="fas fa-check-circle"></i> Reconcile
                                            </button>
                                        <?php else: ?>
        <span class="text-muted"><i class="fas fa-check-circle"></i> Reconciled</span>
        <br>
        
    <?php endif; ?>
                                        
                                
                                    </div>
                                </td>
                            </tr>

                            <!-- Reconcile Modal -->
                            <div class="modal fade" id="reconcileModal-<?php echo e($bursary->id); ?>" tabindex="-1" role="dialog" aria-labelledby="reconcileModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title" id="reconcileModalLabel">
                                                <i class="fas fa-check-circle me-2"></i> Reconcile Bursary Allocation
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?php echo e(route($route.'.reconcile', $bursary->id)); ?>" method="POST">
                                            <?php echo csrf_field(); ?>
                                            <div class="modal-body">
                                                <div class="alert alert-info">
                                                    <h6>Bursary Allocation Details</h6>
                                                    <hr>
                                                    <p><strong>Student:</strong> <?php echo e($bursary->studentEnroll->student->full_name ?? 'N/A'); ?> (ID: <?php echo e($bursary->studentEnroll->student->student_id ?? 'N/A'); ?>)</p>
                                                    <p><strong>Amount:</strong> <?php echo e(number_format($bursary->amount, 2)); ?></p>
                                                    <p><strong>Excess:</strong> <?php echo e(number_format($bursary->excess_payment, 2)); ?></p>
                                                    <p><strong>Type:</strong> <?php echo e($bursaryTypes->firstWhere('code', $bursary->bursary_type)->name ?? $bursary->bursary_type); ?></p>
                                                    <p><strong>Allocated By:</strong> <?php echo e($bursary->bursary_allocated_by); ?> on <?php echo e($bursary->bursary_allocated_at ? $bursary->bursary_allocated_at->format('d M Y H:i') : 'N/A'); ?></p>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="reconciliation_status-<?php echo e($bursary->id); ?>" class="fw-bold">Reconciliation Status</label>
                                                    <select name="reconciliation_status" id="reconciliation_status-<?php echo e($bursary->id); ?>" class="form-control" required>
                                                        <option value="1">Completed</option>
                                                        <option value="2">To Check</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="confirmation_date-<?php echo e($bursary->id); ?>" class="fw-bold">Confirmation Date</label>
                                                    <input type="date" 
                                                           name="confirmation_date" 
                                                           id="confirmation_date-<?php echo e($bursary->id); ?>" 
                                                           class="form-control" 
                                                           value="<?php echo e(date('Y-m-d')); ?>" 
                                                           max="<?php echo e(date('Y-m-d')); ?>"
                                                           required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="confirmation_time-<?php echo e($bursary->id); ?>" class="fw-bold">Confirmation Time</label>
                                                    <input type="time" 
                                                           name="confirmation_time" 
                                                           id="confirmation_time-<?php echo e($bursary->id); ?>" 
                                                           class="form-control" 
                                                           value="<?php echo e(date('H:i')); ?>"
                                                           required>
                                                </div>

                                                <div class="form-group mb-3">
                                                    <label for="reconciliation_notes-<?php echo e($bursary->id); ?>" class="fw-bold">Reconciliation Notes</label>
                                                    <textarea name="reconciliation_notes" 
                                                              id="reconciliation_notes-<?php echo e($bursary->id); ?>" 
                                                              class="form-control" 
                                                              rows="3" 
                                                              placeholder="Any notes about this reconciliation"></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
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
                                <td colspan="12" class="text-center">No bursary allocations found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($bursaries->hasPages()): ?>
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($bursaries->appends(request()->query())->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Bursary Fund Creation Modal with Bursary Types List -->
<div class="modal fade" id="bursaryFundModal" tabindex="-1" aria-labelledby="bursaryFundModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="bursaryFundModalLabel">Create New Bursary Fund</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Left Side - Creation Form -->
                    <div class="col-md-6 p-4">
                        <form id="bursaryFundForm" action="<?php echo e(route('admin.bursary-allocation.store-fund')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label for="bursary_name" class="form-label">Bursary Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="name" id="bursary_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="bursary_code" class="form-label">Bursary Code <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="code" id="bursary_code" required>
                            </div>
                            <div class="mb-3">
    <label for="bursary_amount" class="form-label">Initial Amount <span class="text-danger">*</span></label>
    <input type="number" class="form-control" name="initial_amount" id="bursary_amount" required step="0.01">
</div>
                            <div class="mb-3">
                                <label for="bursary_description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="bursary_description" rows="3"></textarea>
                            </div>
                            <div class="modal-footer px-0 pb-0">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success">Create Bursary</button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Right Side - Bursary Types List -->
                    <div class="col-md-6 bg-light p-4 border-start">
                        <h6 class="mb-3">Existing Bursary Types</h6>
                        <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th class="text-end">Balance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $bursaryTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($type->name); ?></td>
                                        <td><span class="badge bg-secondary"><?php echo e($type->code); ?></span></td>
                                        <td class="text-end <?php if($type->current_balance < ($type->initial_amount * 0.2)): ?> text-danger <?php endif; ?>">
                                            <?php echo e(number_format($type->current_balance, 2)); ?>

                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group btn-group-sm" role="group">
                                                
                                                <button type="button" class="btn btn-sm btn-outline-danger delete-bursary-btn" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#deleteBursaryModal"
                                                    data-id="<?php echo e($type->id); ?>"
                                                    data-name="<?php echo e($type->name); ?>">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 small text-muted">
                            <div><strong>Last Created:</strong> 
                                <?php if($bursaryTypes->count()): ?>
                                    <?php echo e($bursaryTypes->sortByDesc('created_at')->first()->created_at->format('M d, Y H:i')); ?>

                                <?php else: ?>
                                    No bursary types yet
                                <?php endif; ?>
                            </div>
                            <div><strong>Total Types:</strong> <?php echo e($bursaryTypes->count()); ?></div>
                            <div><strong>Total Balance:</strong> <?php echo e(number_format($bursaryTypes->sum('current_balance'), 2)); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Delete Bursary Confirmation Modal -->
<div class="modal fade" id="deleteBursaryModal" tabindex="-1" aria-labelledby="deleteBursaryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteBursaryModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteBursaryForm" action="<?php echo e(route('admin.bursary-allocation.delete-fund')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <input type="hidden" name="id" id="delete_bursary_id">
                <div class="modal-body">
                    <p>Are you sure you want to delete the bursary type <strong id="delete_bursary_name"></strong>?</p>
                    <p class="text-danger">Warning: This action cannot be undone. Any allocations using this bursary type will need to be updated.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Bursary</button>
                </div>
            </form>
        </div>
    </div>
</div>




<!-- Batch Bursary Allocation Modal -->
<div class="modal fade" id="batchBursaryModal" tabindex="-1" aria-labelledby="batchBursaryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="batchBursaryModalLabel">Batch Bursary Allocation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="batchBursaryForm" action="<?php echo e(route('admin.bursary-allocation.batch-allocate')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="batch_bursary_id" class="form-label">Bursary Type <span class="text-danger">*</span></label>
                            <select class="form-control" name="bursary_type" id="batch_bursary_id" required>
                                <option value="">Select Bursary Type</option>
                                <?php $__currentLoopData = $bursaryTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($type->code); ?>" data-balance="<?php echo e($type->current_balance); ?>">
                                        <?php echo e($type->name); ?> (<?php echo e($setting->currency_symbol); ?><?php echo e(number_format($type->current_balance, 2)); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="batch_amount" class="form-label">Amount per Student (<?php echo $setting->currency_symbol; ?>) <span class="text-danger">*</span></label>
                            <input type="text" class="form-control autonumber" name="amount" id="batch_amount" required>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="batch_students" class="form-label">Select Students <span class="text-danger">*</span></label>
                            <select class="form-control select2-multiple" name="students[]" id="batch_students" multiple required>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id); ?>">
                                        <?php echo e($student->student->student_id ?? ''); ?> - <?php echo e($student->student->first_name ?? ''); ?> <?php echo e($student->student->last_name ?? ''); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <div class="alert alert-info">
                                <strong>Important Info:</strong>
                                <div id="batchSummary">
                                You can assign bursaries to multiple students at once or a single student. It will clear any unpaid invoices for the selected students and allocate the bursary amount to their accounts.
                                </div>
                                
                            </div>
                        </div>
                        
                        <div class="col-md-12 mb-3">
                            <label for="batch_notes" class="form-label">Notes</label>
                            <textarea class="form-control" name="notes" id="batch_notes" rows="3"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info" id="submitBatchBtn">Allocate Bursary</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Batch Reconcile Modal -->
<div class="modal fade" id="batchReconcileModal" tabindex="-1" aria-labelledby="batchReconcileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="batchReconcileModalLabel">
                    <i class="fas fa-check-double me-2"></i> Batch Reconcile Bursaries
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route($route.'.batch-reconcile')); ?>" method="POST" id="batchReconcileForm">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Available Bursaries</h6>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                        <table class="table table-hover table-striped mb-0" id="bursaryTable">
                                            <thead class="sticky-top bg-white">
                                                <tr>
                                                    <th width="30"><input type="checkbox" id="selectAll"></th>
                                                    <th>Student Name</th>
                                                    <th>Amount</th>
                                                    <th>Bursary Type</th>
                                                    <th>Payment Date</th>
                                                </tr>
                                            </thead>
                                            <tbody id="bursaryTableBody">
                                                <!-- Will be populated by JavaScript -->
                                                <tr>
                                                    <td colspan="5" class="text-center">Loading bursary data...</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <!-- Hidden field for payment IDs -->
                            <input type="hidden" name="payment_ids" id="payment_ids" value="">
                            
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i> 
                                You have selected <span id="selectedCount" class="fw-bold">0</span> bursary allocations.
                            </div>

                            <!-- Payment details display -->
                            <div class="mb-3">
                                <h6>Selected Bursaries:</h6>
                                <div id="selectedPaymentsDetails" class="border p-2" style="max-height: 200px; overflow-y: auto;">
                                    <p class="text-muted">No bursaries selected</p>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="batch_status" class="fw-bold">Reconciliation Status</label>
                                <select name="reconciliation_status" id="batch_status" class="form-control" required>
                                    <option value="1">Completed</option>
                                    <option value="2">To Check</option>
                                </select>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="batch_confirmation_date" class="fw-bold">Confirmation Date</label>
                                        <input type="date" 
                                               name="confirmation_date" 
                                               id="batch_confirmation_date" 
                                               class="form-control" 
                                               value="<?php echo e(date('Y-m-d')); ?>" 
                                               max="<?php echo e(date('Y-m-d')); ?>"
                                               required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="batch_confirmation_time" class="fw-bold">Confirmation Time</label>
                                        <input type="time" 
                                               name="confirmation_time" 
                                               id="batch_confirmation_time" 
                                               class="form-control" 
                                               value="<?php echo e(date('H:i')); ?>"
                                               required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="batch_reconciliation_notes" class="fw-bold">Reconciliation Notes</label>
                                <textarea name="reconciliation_notes" 
                                          id="batch_reconciliation_notes" 
                                          class="form-control" 
                                          rows="3" 
                                          placeholder="Any notes about this reconciliation"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary" id="confirmReconcileBtn" disabled>
                        <i class="fas fa-check-double me-1"></i> Confirm Batch Reconciliation
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- Required Libraries -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/autonumeric@4.6.0/dist/autoNumeric.min.js"></script>

<script>
function loadBursaryData() {
    $.ajax({
        url: '/admin/bursary-allocation/get-bursary-payments', // Absolute path as fallback
        type: 'GET',
        success: function(response) {
            console.log(response); // Check what's being returned
            let html = '';
            if (response.length > 0) {
                response.forEach(function(bursary) {
                    html += `
                        <tr>
                            <td><input type="checkbox" class="bursary-checkbox" value="${bursary.id}"></td>
                            <td>${bursary.student_name}</td>
                            <td>${bursary.amount}</td>
                            <td>${bursary.bursary_type || 'N/A'}</td>
                            <td>${bursary.payment_date || 'N/A'}</td>
                        </tr>
                    `;
                });
                $('#bursaryTableBody').html(html);
            } else {
                $('#bursaryTableBody').html('<tr><td colspan="5" class="text-center">No unreconciled bursaries found</td></tr>');
            }
            
            $('.bursary-checkbox').change(function() {
                updateSelectedPayments();
            });
        },
        error: function(xhr) {
            console.error(xhr);
            $('#bursaryTableBody').html(
                '<tr><td colspan="5" class="text-center text-danger">Error loading data</td></tr>'
            );
        }
    });
}
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    

    // Delete Bursary Type - Populate modal with data
    document.querySelectorAll('.delete-bursary-btn').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');

            document.getElementById('delete_bursary_id').value = id;
            document.getElementById('delete_bursary_name').textContent = name;
        });
    });

    // Refresh the bursary list after form submissions
    const forms = ['#bursaryFundForm', '#deleteBursaryForm'];
    forms.forEach(formId => {
        const form = document.querySelector(formId);
        if (form) {
            form.addEventListener('submit', function(e) {
                // You can add AJAX submission here if needed
                // Or let the form submit normally and refresh the page
            });
        }
    });
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/bursary-allocation/index.blade.php ENDPATH**/ ?>