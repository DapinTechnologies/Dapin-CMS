<?php $__env->startSection('page_css'); ?>
    <!-- Wizard css -->
    <link rel="stylesheet" href="<?php echo e(asset('dashboard/css/pages/wizard.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('modal_add')); ?> <?php echo e(__('field_student')); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'admin.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <?php echo csrf_field(); ?>

                        <input type="text" name="registration_no" value="<?php echo e($row->registration_no); ?>" hidden>

                        <h3><?php echo e(__('tab_basic_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start -->
                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="first_name"><?php echo e(__('field_first_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e($row->first_name); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_first_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name"><?php echo e(__('field_last_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e($row->last_name); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_last_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($row->phone); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email"><?php echo e(__('field_email')); ?> <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo e($row->email); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender"><?php echo e(__('field_gender')); ?> <span>*</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( $row->gender == 1 ): ?> selected <?php endif; ?>><?php echo e(__('gender_male')); ?></option>
                                    <option value="2" <?php if( $row->gender == 2 ): ?> selected <?php endif; ?>><?php echo e(__('gender_female')); ?></option>
                                    <option value="3" <?php if( $row->gender == 3 ): ?> selected <?php endif; ?>><?php echo e(__('gender_other')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_gender')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="dob"><?php echo e(__('field_dob')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="dob" id="dob" value="<?php echo e($row->dob); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_dob')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="admission_date"><?php echo e(__('field_admission_date')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="admission_date" id="admission_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_admission_date')); ?>

                                </div>
                            </div>
                            </fieldset>
                            </div>
                            </div>
                            <!-- Form End -->
                        </content>

                        <h3><?php echo e(__('tab_educational_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_academic_information')); ?></legend>
                            <div class="form-group col-md-6">
                                <label for="student_id"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="student_id" id="student_id" value="<?php echo e(old('student_id')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="batch"><?php echo e(__('field_batch')); ?> <span>*</span></label>
                                <select class="form-control batch" name="batch" id="batch" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($batch->id); ?>" <?php if(old('batch') == $batch->id): ?> selected <?php endif; ?>><?php echo e($batch->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_batch')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                            <label for="program"><?php echo e(__('field_program')); ?> <span>*</span></label>
                                <select class="form-control program" name="program" id="program" required>
                                  <option value=""><?php echo e(__('select')); ?></option>
                                </select>

                              <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                              </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="session"><?php echo e(__('field_session')); ?> <span>*</span></label>
                                <select class="form-control session" name="session" id="session" required>
                                  <option value=""><?php echo e(__('select')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="semester"><?php echo e(__('field_semester')); ?> <span>*</span></label>
                                <select class="form-control semester" name="semester" id="semester" required>
                                  <option value=""><?php echo e(__('select')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="section"><?php echo e(__('field_section')); ?> <span>*</span></label>
                                <select class="form-control section" name="section" id="section" required>
                                  <option value=""><?php echo e(__('select')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_section')); ?>

                                </div>
                            </div>
                            </fieldset>
                            <!-- Form End--->
                        </content>
                    </form>
                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
    <!-- validate Js -->
    <script src="<?php echo e(asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js')); ?>"></script>

    <!-- Wizard Js -->
    <script src="<?php echo e(asset('dashboard/js/pages/jquery.steps.js')); ?>"></script>

    <script type="text/javascript">
        "use strict";
        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            labels: 
            {
                finish: "<?php echo e(__('btn_finish')); ?>",
                next: "<?php echo e(__('btn_next')); ?>",
                previous: "<?php echo e(__('btn_previous')); ?>",
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                // Allways allow previous action even if the current form is not valid!
                if (currentIndex > newIndex)
                {
                    return true;
                }
                // Needed in some cases if the user went back (clean up)
                if (currentIndex < newIndex)
                {
                    // To remove error styles
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                $("#wizard-advanced-form").submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {

            }
        });
    </script>

<!-- Filter Search -->
<?php echo $__env->make('common.js.batch_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /opt/lampp/htdocs/Dapin-CMS/resources/views/admin/admission/edit.blade.php ENDPATH**/ ?>