<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>
<style>
    /* Select2 - Keep dropdown within bounds and scrollable */
.select2-container--default .select2-results__options {
    max-height: 200px;
    overflow-y: auto;
}

/* Ensure the input box accommodates multiple selections */
.select2-container--default .select2-selection--multiple {
    min-height: 38px;
    padding: 6px;
    overflow: hidden;
    box-sizing: border-box;
    white-space: normal;
}

/* Make Select2 fully responsive */
.select2-container {
    width: 100% !important;
}

/* Prevent wrapping issues */
.select2-selection__choice {
    white-space: normal !important;
    word-break: break-word !important;
}

</style>



<!-- Start Content -->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.quick.assign.store')); ?>" method="post" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <div class="card-block">
                            <div class="row">

                              <!-- Student select -->
                                <div class="form-group col-md-6">
                                    <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="students[]" id="student" multiple required>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($student->id); ?>" <?php echo e(in_array($student->id, old('students', [])) ? 'selected' : ''); ?>>
                                                <?php echo e($student->student->student_id ?? ''); ?> - <?php echo e($student->student->first_name ?? ''); ?> <?php echo e($student->student->last_name ?? ''); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                                    </div>
                                </div>

                                <!-- Categories select -->
                                <div class="form-group col-md-6">
                                    <label for="categories"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="categories[]" id="categories" multiple required>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($category->id); ?>">
                                                <?php echo e($category->title); ?> (<?php echo e(number_format($category->amount, 2)); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                                    </div>
                                </div>

                                <!-- Total Amount Display -->
                                <div class="form-group col-md-6" id="total-amount-container" style="display:none;">
                                    <label><strong>Total Amount:</strong></label>
                                    <div id="total-amount" style="font-size: 1.2rem; font-weight: bold;">0.00</div>
                                </div>

                                <!-- Assign date -->
                                <div class="form-group col-md-6">
                                    <label for="assign_date" class="form-label"><?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control" name="assign_date" id="assign_date" value="<?php echo e(date('Y-m-d')); ?>" readonly required>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_assign')); ?> <?php echo e(__('field_date')); ?>

                                    </div>
                                </div>

                                <!-- Due date -->
                                <div class="form-group col-md-6">
                                    <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                                    <input type="date" class="form-control" name="due_date" id="due_date" value="<?php echo e(old('due_date', date('Y-m-d'))); ?>" required>
                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                                    </div>
                                </div>

                                <!-- Amount Type -->
                                

                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?>

                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS/JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {
    $('#student').select2({
        placeholder: 'Select student(s)',
        width: '100%'
    });

    $('#categories').select2({
        placeholder: 'Select one or more fee categories',
        width: '100%'
    });

    // Clean and simple amount calculation
    function updateTotalAmount() {
        let total = 0;

        $('#categories option:selected').each(function () {
            let text = $(this).text();
            let match = text.match(/\(([\d,\.]+)\)/); // Extract amount inside parentheses

            if (match && match[1]) {
                let amount = parseFloat(match[1].replace(/,/g, ''));
                if (!isNaN(amount)) {
                    total += amount;
                }
            }
        });

        if (total > 0) {
            $('#total-amount-container').show();
            $('#total-amount').text(total.toFixed(2));
        } else {
            $('#total-amount-container').hide();
            $('#total-amount').text('0.00');
        }
    }

    $('#categories').on('change', updateTotalAmount);
    updateTotalAmount(); // Initialize on page load
});
</script>



<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views/admin/fees-student/quick-assign.blade.php ENDPATH**/ ?>