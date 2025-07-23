
<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>




<form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <!-- Basic Information -->
    <h3><?php echo e(__('tab_basic_info')); ?></h3>
    <content class="form-step">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="first_name"><?php echo e(__('First Name')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e($row->first_name); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="last_name"><?php echo e(__('Last Name')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e($row->last_name); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="dob"><?php echo e(__('Date of Birth')); ?> <span>*</span></label>
                <input type="date" class="form-control" name="dob" id="dob" value="<?php echo e($row->dob); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="phone"><?php echo e(__('Phone Number')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($row->phone); ?>" required>
            </div>
<div class="form-group col-md-6">
    <label for="email"><?php echo e(__('Email')); ?> <span>*</span></label>
    <input type="email" class="form-control" name="email" id="email" value="<?php echo e($row->email); ?>" required>
</div>

            <!-- Gender Field -->
            <div class="form-group col-md-6">
                <label for="gender"><?php echo e(__('Gender')); ?> <span>*</span></label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value=""><?php echo e(__('Select Gender')); ?></option>
                    <option value="1" <?php if($row->gender == 1): ?> selected <?php endif; ?>><?php echo e(__('Male')); ?></option>
                    <option value="2" <?php if($row->gender == 2): ?> selected <?php endif; ?>><?php echo e(__('Female')); ?></option>
                    <option value="3" <?php if($row->gender == 3): ?> selected <?php endif; ?>><?php echo e(__('Other')); ?></option>
                </select>
            </div>

            <!-- Program Field -->
            <div class="form-group col-md-6">
                <label for="program"><?php echo e(__('Program')); ?> <span>*</span></label>
                <select class="form-control" name="program" id="program" required>
                    <option value=""><?php echo e(__('Select Program')); ?></option>
                    <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($program->id); ?>" <?php if($row->program_id == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </content>

    <!-- KCSE Results -->
    <h3><?php echo e(__('KCSE Results')); ?></h3>
    <content class="form-step">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="kcse_index_no"><?php echo e(__('KCSE Index Number')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" value="<?php echo e($row->kcse_index_no); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_year"><?php echo e(__('KCSE Year')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="kcse_year" id="kcse_year" value="<?php echo e($row->kcse_year); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_grade"><?php echo e(__('KCSE Grade')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="kcse_grade" id="kcse_grade" value="<?php echo e($row->kcse_grade); ?>" required>
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_certificate"><?php echo e(__('KCSE Certificate')); ?> <span>*</span></label>
                <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate">
                <?php if($row->kcse_certificate): ?>
                    <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->kcse_certificate)); ?>" target="_blank">Current KCSE Certificate</a>
                <?php endif; ?>
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_result_slip"><?php echo e(__('KCSE Result Slip')); ?> <span>*</span></label>
                <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip">
                <?php if($row->kcse_result_slip): ?>
                    <a href="<?php echo e(asset('uploads/'.$path.'/'.$row->kcse_result_slip)); ?>" target="_blank">Current KCSE Result Slip</a>
                <?php endif; ?>
            </div>
        </div>
    </content>

    <!-- County and Sub-county -->
    <h3><?php echo e(__('Location')); ?></h3>
    <content class="form-step">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="county"><?php echo e(__('County')); ?> <span>*</span></label>
                <select class="form-control" name="county" id="county" required>
                    <option value=""><?php echo e(__('Select County')); ?></option>
                    <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($county->CountyID); ?>" <?php if($row->county_id == $county->CountyID): ?> selected <?php endif; ?>><?php echo e($county->CountyName); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

           <div class="form-group col-md-6">
            <label for="sub_county"><?php echo e(__('Sub-County')); ?> <span>*</span></label>
            <select class="form-control" name="sub_county" id="sub_county" required>
                <option value=""><?php echo e(__('Select Sub-County')); ?></option>
                <?php $__currentLoopData = $sub_counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCounty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($subCounty->SubCountyID); ?>" <?php if($row->sub_county_id == $subCounty->SubCountyID): ?> selected <?php endif; ?>><?php echo e($subCounty->SubCountyName); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        </div>

        <div class="form-group col-md-6">
    <label for="mode_of_education"><?php echo e(__('Mode of Study')); ?> <span>*</span></label>
    <select class="form-control" name="mode_of_education" id="mode_of_education" required>
        <option value=""><?php echo e(__('Select Mode of Study')); ?></option>
        <option value="Physical" <?php if($row->mode_of_study == 'Physical'): ?> selected <?php endif; ?>>Physical</option>
        <option value="Online" <?php if($row->mode_of_study == 'Online'): ?> selected <?php endif; ?>>Online</option>
        <option value="Hybrid" <?php if($row->mode_of_study == 'Hybrid'): ?> selected <?php endif; ?>>Hybrid</option>
    </select>
</div>

    </content>

    <button type="submit" class="btn btn-success"><?php echo e(__('Update')); ?></button>
</form>
<script>
// Dynamic Sub-County Filtering Based on Selected County
    $(document).ready(function () {
        // Store all sub-county options in a variable
        var allSubCounties = $('#sub_county').html();

        $('#county').change(function () {
            var countyId = $(this).val();
            $('#sub_county').html('<option value=""><?php echo e(__('Select Sub-County')); ?></option>');

            // Filter sub-counties based on the selected county
            $(allSubCounties).filter('option').each(function () {
                if ($(this).data('county-id') == countyId) {
                    $('#sub_county').append($(this).clone());
                }
            });

            // Debugging: Log the selected county ID and filtered sub-counties
            console.log('Selected County ID:', countyId);
            console.log('Filtered Sub-Counties:', $('#sub_county').html());
        });
    });

</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/application/edit.blade.php ENDPATH**/ ?>