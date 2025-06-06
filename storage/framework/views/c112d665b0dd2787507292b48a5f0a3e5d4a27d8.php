
<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>

    <title><?php echo e($applicationSetting->title ?? $title); ?></title>
    <?php echo $__env->make('admin.layouts.common.header_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('dashboard/css/pages/wizard.css')); ?>">
</head>
<body>

    <?php
    use App\Models\Program;
    use App\Models\County;
    use App\Models\SubCounty;

    // Fetch data directly in the view
    $programs = Program::all();
    $counties = County::all();
    $subCounties = SubCounty::all();
?>




<?php if(isset($applicationSetting)): ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="card">
            <div class="card-block">
                <div class="row mt-5 mb-5">
                    <div class="col-sm-8 text-center">
                        <h2><?php echo e($applicationSetting->title); ?></h2>
                        <p><?php echo strip_tags($applicationSetting->body, '<br><b><i><strong><u><a><span><del>'); ?></p>
                    </div>
                </div>
                <?php if(session('success')): ?>
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-double"></i> <?php echo e(trans_choice('module_application', 1)); ?> <?php echo e(session('success')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                        <!-- Basic Information -->
                        <h3><?php echo e(__('tab_basic_info')); ?></h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>Personal Information</legend>
                                
                                <div class="col-md-6">
                                    <label for="first_name"><?php echo e(__('First Name')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="last_name"><?php echo e(__('Last Name')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="dob"><?php echo e(__('Date of Birth')); ?> <span>*</span></label>
                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone"><?php echo e(__('Phone Number')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email"><?php echo e(__('Email Address')); ?> <span>*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="national_id"><?php echo e(__('National ID/Parent ID')); ?> <span>*</span></label>
                                    <input type="text" class="form-control" name="national_id" id="national_id" required>
                                </div>

                                <!-- Gender Field -->
                                <div class="col-md-6">
                                    <label for="gender"><?php echo e(__('Gender')); ?> <span>*</span></label>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value=""><?php echo e(__('Select Gender')); ?></option>
                                        <option value="1"><?php echo e(__('Male')); ?></option>
                                        <option value="2"><?php echo e(__('Female')); ?></option>
                                        <option value="3"><?php echo e(__('Other')); ?></option>
                                    </select>
                                </div>

                                <!-- Program Field (Populated from Model) -->
                                <div class="col-md-6">
                                    <label for="program"><?php echo e(__('Program')); ?> <span>*</span></label>
                                    <select class="form-control" name="program" id="program" required>
                                        <option value=""><?php echo e(__('Select Program')); ?></option>
                                        <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($program->id); ?>"><?php echo e($program->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </fieldset>
                        </content>

                        <!-- KCSE Results -->
                       <!-- KCSE Results -->
<h3><?php echo e(__('KCSE Results')); ?></h3>
<content class="form-step">
    <fieldset class="row scheduler-border">
        <legend>KCSE Results</legend>

        <div class="col-md-6">
            <label for="kcse_index_no"><?php echo e(__('KCSE Index Number')); ?> <span>*</span></label>
            <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" required>
        </div>

        <div class="col-md-6">
            <label for="kcse_year"><?php echo e(__('KCSE Year')); ?> <span>*</span></label>
            <input type="text" class="form-control" name="kcse_year" id="kcse_year" required>
        </div>

        <div class="col-md-6">
            <label for="kcse_overall_grade"><?php echo e(__('Overall KCSE Grade')); ?> <span>*</span></label>
            <input type="text" class="form-control" name="kcse_grade" id="kcse_overall_grade" required>
        </div>

        <!-- KCSE Certificate Upload -->
        <div class="col-md-6">
            <label for="kcse_certificate"><?php echo e(__('KCSE Certificate')); ?> <span>*</span></label>
            <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate" required>
        </div>

        <!-- KCSE Result Slip Upload -->
        <div class="col-md-6">
            <label for="kcse_result_slip"><?php echo e(__('KCSE Result Slip')); ?> <span>*</span></label>
            <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip" required>
        </div>
    </fieldset>
</content>

                        <!-- Location Information -->
                        <h3>Location</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>Location Details</legend>

                                <!-- County Dropdown -->
                                <div class="col-md-6">
                                    <label for="county"><?php echo e(__('County')); ?> <span>*</span></label>
                                    <select class="form-control" name="county" id="county" required>
                                        <option value=""><?php echo e(__('Select County')); ?></option>
                                        <?php $__currentLoopData = $counties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $county): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($county->CountyID); ?>"><?php echo e($county->CountyName); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <!-- Sub-County Dropdown -->
                                <div class="col-md-6">
                                    <label for="sub_county"><?php echo e(__('Sub-County')); ?> <span>*</span></label>
                                    <select class="form-control" name="sub_county" id="sub_county" required>
                                        <option value=""><?php echo e(__('Select Sub-County')); ?></option>
                                        <?php $__currentLoopData = $subCounties; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subCounty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($subCounty->SubCountyID); ?>" data-county-id="<?php echo e($subCounty->CountyID); ?>"><?php echo e($subCounty->SubCountyName); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="physical_address"><?php echo e(__('Physical Address')); ?></label>
                                    <input type="text" class="form-control" name="physical_address" id="physical_address">
                                </div>
                            </fieldset>
                        </content>

                        <!-- Mode of Study -->
                        <h3>Mode of Study</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>Preferred Mode of Study</legend>

                                <div class="col-md-6">
                                    <label for="mode_of_study"><?php echo e(__('Mode of Study')); ?> <span>*</span></label>
                                    <select class="form-control" name="mode_of_education" id="mode_of_study" required>
                                        <option value=""><?php echo e(__('Select Mode of Study')); ?></option>
                                        <option value="Physical">Physical</option>
                                        <option value="Online">Online</option>
                                        <option value="Hybrid">Hybrid</option>
                                        
                                    </select>
                                </div>
                            </fieldset>
                        </content>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<?php echo $__env->make('admin.layouts.common.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>
<script src="<?php echo e(asset('dashboard/js/pages/jquery.steps.js')); ?>"></script>

<script>
    "use strict";
    var form = $("#wizard-advanced-form").show();
    form.steps({
        headerTag: "h3",
        bodyTag: "content",
        transitionEffect: "slideLeft",
        labels: {
            finish: "<?php echo e(__('btn_finish')); ?>",
            next: "<?php echo e(__('btn_next')); ?>",
            previous: "<?php echo e(__('btn_previous')); ?>",
        },
        onFinished: function () {
            $("#wizard-advanced-form").submit();
        }
    });

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

</body>
</html><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\application\create.blade.php ENDPATH**/ ?>