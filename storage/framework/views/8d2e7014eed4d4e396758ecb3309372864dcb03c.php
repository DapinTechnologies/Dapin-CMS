

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4">Fee Structures</h1>
    
    <!-- Filter/Search Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5>Filter/Search Fee Structures</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('fee-structures.index')); ?>" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="faculty_id">Faculty</label>
                            <select name="faculty_id" id="faculty_id" class="form-control">
                                <option value="">All Faculties</option>
                                <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($faculty->id); ?>" <?php echo e(request('faculty_id') == $faculty->id ? 'selected' : ''); ?>>
                                        <?php echo e($faculty->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="program_id">Program</label>
                            <select name="program_id" id="program_id" class="form-control">
                                <option value="">All Programs</option>
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program->id); ?>" <?php echo e(request('program_id') == $program->id ? 'selected' : ''); ?>>
                                        <?php echo e($program->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="semester">Semester</label>
                            <select name="semester" id="semester" class="form-control">
                                <option value="">All Semesters</option>
                                <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($semester); ?>" <?php echo e(request('semester') == $semester ? 'selected' : ''); ?>>
                                        <?php echo e($semester); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="fee_type">Fee Type</label>
                            <select name="fee_type" id="fee_type" class="form-control">
                                <option value="">All Types</option>
                                <option value="one_time" <?php echo e(request('fee_type') == 'one_time' ? 'selected' : ''); ?>>One Time</option>
                                <option value="recurring" <?php echo e(request('fee_type') == 'recurring' ? 'selected' : ''); ?>>Recurring</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary mr-2">Search</button>
                        <a href="<?php echo e(route('fee-structures.index')); ?>" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Fee Structures Table -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5>Fee Structures</h5>
            <div>
                <a href="<?php echo e(route('fee-structures.create')); ?>" class="btn btn-success">Create New</a>
                <a href="<?php echo e(route('fee-structures.export')); ?>" class="btn btn-info ml-2">Export</a>
                <button class="btn btn-warning ml-2" data-toggle="modal" data-target="#importModal">Import</button>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Faculty</th>
                            <th>Program</th>
                            <th>Semester</th>
                            <th>Total Fee (KES)</th>
                            <th>No. of Fee Items</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $feeStructures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $feeStructure): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($index + 1); ?></td>
                                <td><?php echo e($feeStructure->faculty->name); ?></td>
                                <td><?php echo e($feeStructure->program->name); ?></td>
                                <td><?php echo e($feeStructure->semester); ?></td>
                                <td><?php echo e(number_format($feeStructure->items->sum('amount'), 2)); ?></td>
                                <td><?php echo e($feeStructure->items->count()); ?></td>
                                <td>
                                    <span class="badge badge-<?php echo e($feeStructure->is_active ? 'success' : 'danger'); ?>">
                                        <?php echo e($feeStructure->is_active ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo e(route('fee-structures.show', $feeStructure->id)); ?>" class="btn btn-sm btn-info">View</a>
                                    <a href="<?php echo e(route('fee-structures.edit', $feeStructure->id)); ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="<?php echo e(route('fee-structures.destroy', $feeStructure->id)); ?>" method="POST" class="d-inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <?php echo e($feeStructures->links()); ?>

        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="importModalLabel">Import Fee Structures</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo e(route('fee-structures.import')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="import_file">Select File</label>
                        <input type="file" class="form-control-file" id="import_file" name="import_file" required>
                        <small class="form-text text-muted">Supported formats: CSV, Excel</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/fee-structures/index.blade.php ENDPATH**/ ?>