

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;"><?php echo e($title); ?></h1>
    
    <!-- Filter/Search Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter/Search Fee Structures</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route($route.'.index')); ?>" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="faculty">Faculty</label>
                            <select name="faculty" id="faculty" class="form-control">
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
                                <label for="program">Course</label>
                            <select name="program" id="program" class="form-control">
                                <option value="0">All Courses</option>
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
                                <option value="0">All Semesters</option>
                                <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($semester->title); ?>" <?php echo e($selected_semester == $semester->title ? 'selected' : ''); ?>>
                                        <?php echo e($semester->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="category">Fee Types</label>
                            <select name="category" id="category" class="form-control">
                                <option value="0">All FeeTypes</option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($category->id); ?>" <?php echo e($selected_category == $category->id ? 'selected' : ''); ?>>
                                        <?php echo e($category->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12 d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-primary mr-2">
                            <i class="fas fa-search"></i> Search
                        </button>
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-sync-alt"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Fee Structures Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Fee Structures List</h5>
            <div>
                

                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create fee structures')): ?>
                <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-success btn-sm">
                    <i class="fas fa-plus"></i> Create Fee Structure
                </a>
                <?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('export fee structures')): ?>
    <a href="<?php echo e(route('admin.fee-structures.export')); ?>" class="btn btn-info btn-sm ml-2" download>
        <i class="fas fa-file-export"></i> Export
    </a>
<?php endif; ?>
                
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('import fee structures')): ?>
<button class="btn btn-warning btn-sm ms-2" data-bs-toggle="modal" data-bs-target="#importModal">
    <i class="fas fa-file-import"></i> Import
</button>
<?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th width="5%">#</th>
                            <th>Faculty</th>
                            <th>Course</th>
                            <th>Semester</th>
                            <th>Total Amount</th>
                            <th>Fee Items</th>
                            <th>Status</th>
                            <th width="20%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $feeStructures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $feeStructure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        
                            <tr>
                                <td><?php echo e($key + 1); ?></td>
                                <td><?php echo e($feeStructure->faculty->title ?? 'N/A'); ?></td>
                                <td><?php echo e($feeStructure->program->title ?? 'N/A'); ?></td>
                                <td><?php echo e($feeStructure->semester); ?></td>
                                <td><?php echo e(number_format($feeStructure->items->sum('amount'), 2)); ?></td>
                                <td>
                                    <?php $__currentLoopData = $feeStructure->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge badge-info">
                                            <?php echo e($item->fee_category_title  ?? 'Uncategorized'); ?>: 
                                            <?php echo e(number_format($item->amount, 2)); ?>

                                        </span><br>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo e($feeStructure->is_active ? 'success' : 'danger'); ?>">
                                        <?php echo e($feeStructure->is_active ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view fee structures')): ?>
                                    <a href="<?php echo e(route($route.'.show', $feeStructure->id)); ?>" class="btn btn-info btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('edit fee structures')): ?>
                                    <a href="<?php echo e(route($route.'.edit', $feeStructure->id)); ?>" class="btn btn-primary btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php endif; ?>
                                    
                                    <!-- Send Invoice Button -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('create fee structures')): ?>
<button type="button" 
        class="btn btn-warning btn-sm" 
        title="Send Invoice to all enrolled students"
        data-bs-toggle="modal" 
        data-bs-target="#sendInvoiceModal-<?php echo e($feeStructure->id); ?>">
    <i class="fas fa-paper-plane"></i> Send Invoices
</button>

<!-- Send Invoice Modal -->
<div class="modal fade" id="sendInvoiceModal-<?php echo e($feeStructure->id); ?>" tabindex="-1" aria-labelledby="sendInvoiceModalLabel-<?php echo e($feeStructure->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                
                    <h5 class="modal-title" id="sendInvoiceModalLabel-<?php echo e($feeStructure->id); ?>">
                    <i class="fas fa-paper-plane me-2"></i> Send Invoices - <?php echo e($feeStructure->program->title ?? 'N/A'); ?> (Semester <?php echo e($feeStructure->semester); ?>)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.fee-structures.sendInvoice', $feeStructure->id)); ?>" method="POST" class="send-invoice-form">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> 
                        This will create invoices for ALL students enrolled in:
                        <strong><?php echo e($feeStructure->program->title ?? 'N/A'); ?></strong> - 
                        Semester <strong><?php echo e($feeStructure->semester); ?></strong>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date-<?php echo e($feeStructure->id); ?>" class="form-label fw-bold">Due Date</label>
                                <input type="date" 
                                    class="form-control" 
                                    id="due_date-<?php echo e($feeStructure->id); ?>" 
                                    name="due_date"
                                    min="<?php echo e(date('Y-m-d')); ?>"
                                    value="<?php echo e(date('Y-m-d', strtotime('+30 days'))); ?>"
                                    required>
                                <small class="form-text text-muted">Select the payment due date</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold">Notification Options</label>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_sms-<?php echo e($feeStructure->id); ?>" 
                                        name="send_sms" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_sms-<?php echo e($feeStructure->id); ?>">
                                        Send SMS Notification
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_email-<?php echo e($feeStructure->id); ?>" 
                                        name="send_email" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_email-<?php echo e($feeStructure->id); ?>">
                                        Send Email Notification
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle me-2"></i> 
    <strong>Warning:</strong> This action cannot be undone, students will receive invoices realtime.
</div>
                    
                    <div class="alert alert-light">
                        <h6 class="fw-bold">Fee Items Summary that will be sent:</h6>
                        <ul class="mb-0">
                            <?php $__currentLoopData = $feeStructure->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <?php echo e($item->fee_category_title ?? 'Uncategorized'); ?>: 
                                    <?php echo e(number_format($item->amount, 2)); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="fw-bold mt-2">
                                Total Amount: <?php echo e(number_format($feeStructure->items->sum('amount'), 2)); ?>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Send Invoices
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>
                                    
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete fee structures')): ?>
    <!-- Delete Button Triggering Modal -->
    <button type="button" class="btn btn-danger btn-sm" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteFeeStructureModal-<?php echo e($feeStructure->id); ?>">
        <i class="fas fa-trash"></i>
    </button>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteFeeStructureModal-<?php echo e($feeStructure->id); ?>" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i> Confirm Deletion
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route($route.'.destroy', $feeStructure->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Warning:</strong> This action cannot be undone. All related data will be permanently deleted.
                        </div>
                        
                        <div class="mb-3">
                            <label for="deleteReason-<?php echo e($feeStructure->id); ?>" class="form-label required">
                                <i class="fas fa-comment-dots me-1"></i> Reason for deletion
                            </label>
                            <textarea class="form-control" id="deleteReason-<?php echo e($feeStructure->id); ?>" 
                                      name="delete_reason" rows="3" required 
                                      placeholder="Please explain why you're deleting this fee structure"></textarea>
                            <div class="invalid-feedback">
                                Please provide a reason for deletion.
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i> Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash me-1"></i> Confirm Delete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center">No fee structures found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            
            <?php if($feeStructures->hasPages()): ?>
            <div class="d-flex justify-content-center mt-3">
                <?php echo e($feeStructures->appends(request()->query())->links()); ?>

            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Import Modal -->
<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('import fee structures')): ?>
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="fas fa-file-import me-2"></i>Import Fee Structures
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route($route.'.import')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <h5 class="alert-heading"><i class="fas fa-info-circle me-2"></i>Import Guidelines</h5>
                        <hr>
                        <ol class="mb-0">
                            <li>Download our template file to ensure proper formatting</li>
                            <li>Keep the first row as header (column names)</li>
                            <li>Ensure all required fields are filled</li>
                            <li>Save your file in CSV, XLS, or XLSX format</li>
                        </ol>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <h6 class="mb-0"><i class="fas fa-table me-2"></i>File Format Requirements</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Column</th>
                                            <th>Description</th>
                                            <th>Required</th>
                                            <th>Example</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Faculty</td>
                                            <td>Name of the faculty</td>
                                            <td><span class="badge bg-success">Yes</span></td>
                                            <td>Science and Technology</td>
                                        </tr>
                                        <tr>
                                            <td>Program</td>
                                            <td>Name of the program</td>
                                            <td><span class="badge bg-success">Yes</span></td>
                                            <td>Computer Science</td>
                                        </tr>
                                        <tr>
                                            <td>Semester</td>
                                            <td>Semester name or code</td>
                                            <td><span class="badge bg-success">Yes</span></td>
                                            <td>First Semester</td>
                                        </tr>
                                        <tr>
                                            <td>Fee Categories</td>
                                            <td>Category:Amount pairs (one per column)</td>
                                            <td><span class="badge bg-success">At least one</span></td>
                                            <td>Tuition Fee:50000</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                <a href="<?php echo e(route($route.'.import-template')); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-file-download me-2"></i>Download Template
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="import_file" class="form-label">
                            <i class="fas fa-file me-2"></i>Select File to Import
                        </label>
                        <input class="form-control" type="file" id="import_file" name="import_file" required>
                        <div class="form-text text-muted">
                            Supported formats: .csv, .xls, .xlsx (Max: 5MB)
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="header_row" name="header_row" checked>
                            <label class="form-check-label" for="header_row">
                                <i class="fas fa-check-square me-2"></i>First row contains column headers
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-upload me-2"></i>Import File
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Send Invoice Modal -->
<div class="modal fade" id="sendInvoiceModal-<?php echo e($feeStructure->id); ?>" tabindex="-1" aria-labelledby="sendInvoiceModalLabel-<?php echo e($feeStructure->id); ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                
                    <h5 class="modal-title" id="sendInvoiceModalLabel-<?php echo e($feeStructure->id); ?>">
                    <i class="fas fa-paper-plane me-2"></i> Send Invoices - <?php echo e($feeStructure->program->title ?? 'N/A'); ?> (Semester <?php echo e($feeStructure->semester); ?>)
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo e(route('admin.fee-structures.sendInvoice', $feeStructure->id)); ?>" method="POST" class="send-invoice-form">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> 
                        This will create invoices for ALL students enrolled in:
                        <strong><?php echo e($feeStructure->program->title ?? 'N/A'); ?></strong> - 
                        Semester <strong><?php echo e($feeStructure->semester); ?></strong>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="due_date-<?php echo e($feeStructure->id); ?>" class="form-label fw-bold">Due Date</label>
                                <input type="date" 
                                    class="form-control" 
                                    id="due_date-<?php echo e($feeStructure->id); ?>" 
                                    name="due_date"
                                    min="<?php echo e(date('Y-m-d')); ?>"
                                    value="<?php echo e(date('Y-m-d', strtotime('+30 days'))); ?>"
                                    required>
                                <small class="form-text text-muted">Select the payment due date</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="fw-bold">Notification Options</label>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_sms-<?php echo e($feeStructure->id); ?>" 
                                        name="send_sms" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_sms-<?php echo e($feeStructure->id); ?>">
                                        Send SMS Notification
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" 
                                        type="checkbox" 
                                        id="send_email-<?php echo e($feeStructure->id); ?>" 
                                        name="send_email" 
                                        value="1"
                                        checked>
                                    <label class="form-check-label" for="send_email-<?php echo e($feeStructure->id); ?>">
                                        Send Email Notification
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="alert alert-warning">
    <i class="fas fa-exclamation-triangle me-2"></i> 
    <strong>Warning:</strong> This action cannot be undone, students will receive invoices realtime.
</div>
                    
                    <div class="alert alert-light">
                        <h6 class="fw-bold">Fee Items Summary that will be sent:</h6>
                        <ul class="mb-0">
                            <?php $__currentLoopData = $feeStructure->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <?php echo e($item->fee_category_title ?? 'Uncategorized'); ?>: 
                                    <?php echo e(number_format($item->amount, 2)); ?>

                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <li class="fw-bold mt-2">
                                Total Amount: <?php echo e(number_format($feeStructure->items->sum('amount'), 2)); ?>

                            </li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-1"></i> Send Invoices
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
                        $('#program').append('<option value="0">All Programs</option>');
                        $.each(data, function(key, value) {
                            $('#program').append('<option value="'+ key +'">'+ value +'</option>');
                        });
                    }
                });
            } else {
                $('#program').empty();
                $('#program').append('<option value="0">All Programs</option>');
            }
        });
    });
</script>

<script>
    $(function() {
        // Debugging - log when button is clicked
        $('[data-target="#importModal"]').click(function() {
            console.log('Import button clicked');
            $('#importModal').modal('show');
        });
        
        // Alternative manual trigger
        $('#importModal').modal({
            show: false
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize date pickers
    document.querySelectorAll('input[type="date"]').forEach(function(input) {
        const today = new Date().toISOString().split('T')[0];
        input.min = today;
    });
    
    // Form submission confirmation
    document.querySelectorAll('.send-invoice-form').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            const dueDate = form.querySelector('input[name="due_date"]').value;
            const sendSms = form.querySelector('input[name="send_sms"]').checked;
            const sendEmail = form.querySelector('input[name="send_email"]').checked;
            const program = form.closest('.modal-content').querySelector('.modal-title').textContent.trim();
            
            const message = `You are about to send invoices for:\n${program}\n\nWith these settings:
- Due Date: ${dueDate}
- SMS Notifications: ${sendSms ? 'Yes' : 'No'}
- Email Notifications: ${sendEmail ? 'Yes' : 'No'}

This action will create invoices for all enrolled students.\n\nAre you sure you want to proceed?`;
            
            if(!confirm(message)) {
                e.preventDefault();
            }
        });
    });
});
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fee-structures/index.blade.php ENDPATH**/ ?>