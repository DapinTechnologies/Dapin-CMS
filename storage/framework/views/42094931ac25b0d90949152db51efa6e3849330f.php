

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4"><?php echo e(isset($feeStructure) ? 'Edit' : 'Create'); ?> Fee Structure</h1>
    
    <div class="card">
        <div class="card-header">
            <h5>Fee Structure Details</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(isset($feeStructure) ? route('fee-structures.update', $feeStructure->id) : route('fee-structures.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if(isset($feeStructure)): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="faculty_id">Faculty *</label>
                            <select name="faculty_id" id="faculty_id" class="form-control" required>
                                <option value="">Select Faculty</option>
                                <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($faculty->id); ?>" 
                                        <?php echo e((isset($feeStructure) && $feeStructure->faculty_id == $faculty->id) ? 'selected' : ''); ?>>
                                        <?php echo e($faculty->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="program_id">Program *</label>
                            <select name="program_id" id="program_id" class="form-control" required>
                                <option value="">Select Program</option>
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program->id); ?>" 
                                        <?php echo e((isset($feeStructure) && $feeStructure->program_id == $program->id) ? 'selected' : ''); ?>>
                                        <?php echo e($program->name); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="semester">Semester *</label>
                            <input type="text" name="semester" id="semester" class="form-control" 
                                value="<?php echo e($feeStructure->semester ?? old('semester')); ?>" required>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <h5>Fee Items</h5>
                <div id="fee-items-container">
                    <?php if(isset($feeStructure) && $feeStructure->items->count() > 0): ?>
                        <?php $__currentLoopData = $feeStructure->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="row fee-item mb-3">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label>Fee Head *</label>
                                        <input type="text" name="fee_heads[<?php echo e($index); ?>][name]" class="form-control" 
                                            value="<?php echo e($item->fee_head); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Amount (KES) *</label>
                                        <input type="number" step="0.01" name="fee_heads[<?php echo e($index); ?>][amount]" 
                                            class="form-control" value="<?php echo e($item->amount); ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>One Time?</label>
                                        <div class="form-check mt-2">
                                            <input type="checkbox" name="fee_heads[<?php echo e($index); ?>][is_one_time]" 
                                                class="form-check-input" value="1" <?php echo e($item->is_one_time ? 'checked' : ''); ?>>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-1 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger remove-item">Remove</button>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <div class="row fee-item mb-3">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label>Fee Head *</label>
                                    <input type="text" name="fee_heads[0][name]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Amount (KES) *</label>
                                    <input type="number" step="0.01" name="fee_heads[0][amount]" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>One Time?</label>
                                    <div class="form-check mt-2">
                                        <input type="checkbox" name="fee_heads[0][is_one_time]" class="form-check-input" value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 d-flex align-items-end">
                                <button type="button" class="btn btn-danger remove-item">Remove</button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <button type="button" id="add-fee-item" class="btn btn-secondary mb-3">Add Fee Item</button>
                
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <a href="<?php echo e(route('fee-structures.index')); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    $(document).ready(function() {
        let itemIndex = <?php echo e(isset($feeStructure) ? $feeStructure->items->count() : 1); ?>;
        
        $('#add-fee-item').click(function() {
            const newItem = `
                <div class="row fee-item mb-3">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>Fee Head *</label>
                            <input type="text" name="fee_heads[${itemIndex}][name]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Amount (KES) *</label>
                            <input type="number" step="0.01" name="fee_heads[${itemIndex}][amount]" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>One Time?</label>
                            <div class="form-check mt-2">
                                <input type="checkbox" name="fee_heads[${itemIndex}][is_one_time]" class="form-check-input" value="1">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-item">Remove</button>
                    </div>
                </div>
            `;
            
            $('#fee-items-container').append(newItem);
            itemIndex++;
        });
        
        $(document).on('click', '.remove-item', function() {
            if ($('.fee-item').length > 1) {
                $(this).closest('.fee-item').remove();
            } else {
                alert('At least one fee item is required.');
            }
        });
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/fee-structures/create.blade.php ENDPATH**/ ?>