

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;"><?php echo e($title); ?> - <?php echo e(isset($feeStructure) ? 'Edit' : 'Create'); ?></h1>
    
    <div class="card">
        <div class="card-header">
            <h5>Fee Structure Details</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(isset($feeStructure) ? route($route.'.update', $feeStructure->id) : route($route.'.store')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php if(isset($feeStructure)): ?>
                    <?php echo method_field('PUT'); ?>
                <?php endif; ?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="faculty_id">Faculty *</label>
                            <select name="faculty_id" id="faculty_id" class="form-control select2" required>
                                <option value="">Select Faculty</option>
                                <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($faculty->id); ?>" 
                                        <?php echo e((isset($feeStructure) && $feeStructure->faculty_id == $faculty->id) ? 'selected' : (old('faculty_id') == $faculty->id ? 'selected' : '')); ?>>
                                        <?php echo e($faculty->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="program_id">Course *</label>
                            <select name="program_id" id="program_id" class="form-control select2" required>
                                <option value="">Select Course</option>
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program->id); ?>" 
                                        <?php echo e((isset($feeStructure) && $feeStructure->program_id == $program->id) ? 'selected' : (old('program_id') == $program->id ? 'selected' : '')); ?>>
                                        <?php echo e($program->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="semester">Semester *</label>
                            <select name="semester" id="semester" class="form-control" required>
                                <option value="">Select Semester</option>
                                <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($semester->title); ?>" 
                                        <?php echo e((isset($feeStructure) && $feeStructure->semester == $semester->title) ? 'selected' : (old('semester') == $semester->title ? 'selected' : '')); ?>>
                                        <?php echo e($semester->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                
                <div class="form-group">
                    <label>Select Fee Types *</label>
                    <?php $__errorArgs = ['fee_categories'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="alert alert-danger"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="5%" class="text-center">Select</th>
                                    <th width="10%">Fees Type</th>

                                    <th width="15%" class="text-center">Fee Amount</th>
                                    <th width="10%" class="text-center">One-Time Fee</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td class="text-center">
                                        <input 
                                            type="checkbox" 
                                            name="fee_categories[]" 
                                            value="<?php echo e($category->id); ?>"
                                            id="category_<?php echo e($category->id); ?>"
                                            <?php if(isset($selectedCategories) && in_array($category->id, $selectedCategories)): echo 'checked'; endif; ?>
                                            class="fee-category-checkbox"
                                            data-amount="<?php echo e($category->amount); ?>"
                                        >
                                    </td>
                                    <td>
                                        <label for="category_<?php echo e($category->id); ?>"><?php echo e($category->title); ?></label>
                                    </td>
                                    
                                    
                                    <td class="text-center">KES <?php echo e(number_format($category->amount, 2)); ?></td>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
    <input 
        type="checkbox" 
        name="one_time[<?php echo e($category->id); ?>]"
        class="form-check-input one-time-checkbox"
        value="1"
        <?php if(isset($feeStructure)): ?>
            <?php
                $item = $feeStructure->items->where('fees_category_id', $category->id)->first();
            ?>
            <?php if($item && $item->is_one_time): ?> checked <?php endif; ?>
        <?php endif; ?>
    >
</div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center">No fee categories available</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> <?php echo e(isset($feeStructure) ? 'Update' : 'Save'); ?>

                    </button>
                    <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-secondary mr-2">
                        <i class="fas fa-times"></i> Back to List
                    </a>
                    
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
$(document).ready(function () {
    // Initialize select2
    $('.select2').select2({ 
        width: '100%',
        placeholder: "Select an option",
        allowClear: true
    });

    // Faculty-Program dependency
    $('#faculty_id').change(function () {
        let facultyId = $(this).val();
        let programSelect = $('#program_id');
        
        programSelect.prop('disabled', true).empty().append('<option value="">Loading...</option>');
        
        if (facultyId) {
            $.ajax({
                url: '/admin/get-programs/' + facultyId,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    programSelect.empty().append('<option value="">Select Program</option>');
                    $.each(data, function (key, value) {
                        programSelect.append($('<option>', {
                            value: key,
                            text: value
                        }));
                    });
                    programSelect.prop('disabled', false);
                    
                    // Restore selected value if editing
                    <?php if(isset($feeStructure)): ?>
                        programSelect.val('<?php echo e($feeStructure->program_id); ?>').trigger('change');
                    <?php endif; ?>
                },
                error: function() {
                    programSelect.empty().append('<option value="">Error loading programs</option>');
                }
            });
        } else {
            programSelect.empty().append('<option value="">Select Program</option>').prop('disabled', false);
        }
    });

    // Trigger initial calculation
    calculateTotals();

    // Calculate totals when checkboxes change
    $(document).on('change', '.fee-category-checkbox', calculateTotals);

    // Calculation function
    function calculateTotals() {
        let grandTotal = 0;
        let selectedCount = 0;

        $('.fee-category-checkbox:checked').each(function() {
            const amount = parseFloat($(this).data('amount')) || 0;
            grandTotal += amount;
            selectedCount++;
        });

        // Update the displayed total
        $('#total-amount').text('KES ' + grandTotal.toFixed(2));
        
        // Highlight if no categories selected
        if (selectedCount === 0) {
            $('#total-amount').addClass('text-danger');
        } else {
            $('#total-amount').removeClass('text-danger');
        }
    }

    // Form validation
    $('form').submit(function(e) {
        if ($('.fee-category-checkbox:checked').length === 0) {
            e.preventDefault();
            alert('Please select at least one fee category.');
            return false;
        }
    });
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fee-structures/edit.blade.php ENDPATH**/ ?>