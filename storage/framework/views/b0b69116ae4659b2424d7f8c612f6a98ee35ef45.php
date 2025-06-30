

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <h1 class="mb-4" style="font-size: 1.25rem;"><?php echo e($title); ?> - Create</h1>
    
    <div class="card">
        <div class="card-header">
            <h5>Fee Structure Details</h5>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route($route.'.store')); ?>" method="POST" id="fee-structure-form">
                <?php echo csrf_field(); ?>
                
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="faculty_id">Faculty *</label>
                            <select name="faculty_id" id="faculty_id" class="form-control select2" required>
                                <option value="">Select Faculty</option>
                                <?php $__currentLoopData = $faculties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faculty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($faculty->id); ?>" <?php echo e(old('faculty_id') == $faculty->id ? 'selected' : ''); ?>>
                                        <?php echo e($faculty->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="program_id">Program *</label>
                            <select name="program_id" id="program_id" class="form-control select2" required>
                                <option value="">Select Program</option>
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program->id); ?>" <?php echo e(old('program_id') == $program->id ? 'selected' : ''); ?>>
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
                                    <option value="<?php echo e($semester->title); ?>" <?php echo e(old('semester') == $semester->title ? 'selected' : ''); ?>>
                                        <?php echo e($semester->title); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="form-group">
                    <label>Select Fee Categories *</label>
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
                                    <th width="25%">Category</th>
                                    <th width="15%" class="text-center">Amount</th>
                                    <th width="15%" class="text-center">One-Time Fee</th>
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
                                            class="fee-category-checkbox"
                                            data-amount="<?php echo e($category->amount); ?>"
                                            <?php if(is_array(old('fee_categories')) && in_array($category->id, old('fee_categories'))): echo 'checked'; endif; ?>
                                        >
                                    </td>
                                    <td>
                                        <label for="category_<?php echo e($category->id); ?>"><?php echo e($category->title); ?></label>
                                        <?php if($category->description): ?>
                                            <p class="text-muted mb-0"><?php echo e($category->description); ?></p>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">KES <?php echo e(number_format($category->amount, 2)); ?></td>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <input 
                                                type="checkbox" 
                                                name="one_time[<?php echo e($category->id); ?>]"
                                                class="form-check-input one-time-checkbox"
                                                value="1"
                                                <?php if(old('one_time.'.$category->id)): echo 'checked'; endif; ?>
                                            >
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No fee categories available</td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                
                <!-- Bulk Assignment Section - Updated Format -->
<div class="card mt-4">
    <div class="card-header">
        <h5>Bulk Student Invoice Assignment</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="assign_to_students" 
                            id="assign_to_students" value="1" <?php echo e(old('assign_to_students') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="assign_to_students">
                            Assign to all enrolled students
                        </label>
                    </div>
                    <small class="text-muted">Will create invoices for all currently enrolled students</small>
                </div>
            </div>
        </div>

        <div id="assignment-options" style="<?php echo e(old('assign_to_students') ? '' : 'display: none;'); ?>">
           
        </div>
    </div>
</div>
 <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="due_date">Due Date *</label>
                        <input type="date" name="due_date" id="due_date" 
                            class="form-control" 
                            value="<?php echo e(old('due_date', \Carbon\Carbon::today()->addDays(30)->format('Y-m-d'))); ?>"
                            min="<?php echo e(\Carbon\Carbon::today()->format('Y-m-d')); ?>"
                            required>
                        <small class="text-muted">Date when payment is due</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Notification Options</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" name="notify_students" 
                                id="notify_students" value="1" <?php echo e(old('notify_students') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="notify_students">
                                Send SMS notifications
                            </label>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="send_invoices" 
                                id="send_invoices" value="1" <?php echo e(old('send_invoices') ? 'checked' : ''); ?>>
                            <label class="form-check-label" for="send_invoices">
                                Email invoice copies
                            </label>
                        </div>
                    </div>
                </div>
            </div>


            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i> This will create invoices for approximately 
                <span id="estimated-students-count"></span> All students, Kindly Confirm with fees due module
                
            </div>
        </div>
    </div>
</div>
                
                <div class="form-group text-right mt-4">
                    <button type="submit" class="btn btn-primary" id="submit-btn">
                        <i class="fas fa-save"></i> Create Fee Structure
                    </button>
                    <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
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
                },
                error: function() {
                    programSelect.empty().append('<option value="">Error loading programs</option>');
                }
            });
        } else {
            programSelect.empty().append('<option value="">Select Program</option>').prop('disabled', false);
        }
    });

    // Toggle assignment options
    $('#assign_to_students').change(function() {
        if ($(this).is(':checked')) {
            $('#assignment-options').slideDown();
            estimateStudents();
        } else {
            $('#assignment-options').slideUp();
        }
    });

    // Calculate totals when checkboxes change
    $(document).on('change', '.fee-category-checkbox', function() {
        calculateTotals();
        if ($('#assign_to_students').is(':checked')) {
            estimateStudents();
        }
    });

    // Calculate total amount
    function calculateTotals() {
        let total = 0;
        $('.fee-category-checkbox:checked').each(function() {
            total += parseFloat($(this).data('amount')) || 0;
        });
        $('#total-amount').text('KES ' + total.toFixed(2));
        return total;
    }

    // Estimate number of students and total value
    function estimateStudents() {
        const facultyId = $('#faculty_id').val();
        const programId = $('#program_id').val();
        const semester = $('#semester').val();
        const totalAmount = calculateTotals();

        if (facultyId && programId && semester && totalAmount > 0) {
            $.ajax({
                url: '/admin/estimate-students',
                type: "GET",
                data: {
                    faculty_id: facultyId,
                    program_id: programId,
                    semester: semester
                },
                success: function (response) {
                    $('#estimated-students-count').text(response.count);
                    $('#estimated-total').text('KES ' + (response.count * totalAmount).toFixed(2));
                },
                error: function() {
                    $('#estimated-students-count').text('N/A');
                    $('#estimated-total').text('KES N/A');
                }
            });
        } else {
            $('#estimated-students-count').text('0');
            $('#estimated-total').text('KES 0.00');
        }
    }

    // Form validation
    $('#fee-structure-form').submit(function(e) {
        const $submitBtn = $('#submit-btn');
        $submitBtn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Processing...');

        // Validate at least one category is selected
        if ($('.fee-category-checkbox:checked').length === 0) {
            e.preventDefault();
            alert('Please select at least one fee category.');
            $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Create Fee Structure');
            return false;
        }

        // Validate due date if assigning to students
        if ($('#assign_to_students').is(':checked') && !$('#due_date').val()) {
            e.preventDefault();
            alert('Please select a due date when assigning to students.');
            $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Create Fee Structure');
            return false;
        }

        // Confirm bulk operation
        if ($('#assign_to_students').is(':checked')) {
            const studentCount = parseInt($('#estimated-students-count').text()) || 0;
            if (studentCount > 50) {
                const confirmed = confirm(`You are about to create invoices for ${studentCount} students. This may take some time. Continue?`);
                if (!confirmed) {
                    e.preventDefault();
                    $submitBtn.prop('disabled', false).html('<i class="fas fa-save"></i> Create Fee Structure');
                    return false;
                }
            }
        }
    });

    // Trigger change events when page loads with old input
    <?php if(old('assign_to_students')): ?>
        $('#assign_to_students').trigger('change');
    <?php endif; ?>

    // Initial calculations
    calculateTotals();
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fee-structures/create.blade.php ENDPATH**/ ?>