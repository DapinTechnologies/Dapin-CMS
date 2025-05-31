<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>

    <title><?php echo e($applicationSetting->title ?? $title); ?></title>
    
    <?php echo $__env->make('admin.layouts.common.header_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Wizard css -->
    <link rel="stylesheet" href="<?php echo e(asset('dashboard/css/pages/wizard.css')); ?>">

    <style type="text/css" media="screen">
        .inner {
            margin: 0 auto;
            width: 100%;
            height: auto;
            overflow: hidden;
            clear: both;
        }
        .inner img {
            margin: 0 auto;
            max-width: 100%;
            width: auto;
            height: auto;
            overflow: hidden;
        }
    </style>

</head>

<body>

<?php if(isset($applicationSetting)): ?>
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="card">
            <div class="card-block">
                <div class="row mt-5 mb-5">
                    <div class="col-sm-2">
                        <div class="inner text-center">
                            <?php if(is_file('uploads/application-setting/'.$applicationSetting->logo_left)): ?>
                            <img src="<?php echo e(asset('uploads/application-setting/'.$applicationSetting->logo_left)); ?>" class="img-fluid" alt="Logo">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-8 text-center">
                        <h2><?php echo e($applicationSetting->title); ?></h2>
                        <p><?php echo strip_tags($applicationSetting->body, '<br><b><i><strong><u><a><span><del>'); ?></p>
                    </div>
                    <div class="col-sm-2">
                        <div class="inner text-center">
                            <?php if(is_file('uploads/application-setting/'.$applicationSetting->logo_right)): ?>
                            <img src="<?php echo e(asset('uploads/application-setting/'.$applicationSetting->logo_right)); ?>" class="img-fluid" alt="Logo">
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <?php if(session('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                        <i class="fas fa-check-double"></i> <?php echo e(trans_choice('module_application', 1)); ?> <?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <?php
                        function field($slug){
                            return \App\Models\Field::field($slug);
                        }
                    ?>
                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <?php echo csrf_field(); ?>

                        <h3><?php echo e(__('tab_basic_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start -->
                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="first_name"><?php echo e(__('field_first_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e(old('first_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_first_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="last_name"><?php echo e(__('field_last_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e(old('last_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_last_name')); ?>

                                </div>
                            </div>

                            <?php if(field('application_father_name')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="father_name"><?php echo e(__('field_father_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e(old('father_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_father_occupation')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="father_occupation"><?php echo e(__('field_father_occupation')); ?></label>
                                <input type="text" class="form-control" name="father_occupation" id="father_occupation" value="<?php echo e(old('father_occupation')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_occupation')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_mother_name')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_name"><?php echo e(__('field_mother_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="<?php echo e(old('mother_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_mother_occupation')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_occupation"><?php echo e(__('field_mother_occupation')); ?></label>
                                <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" value="<?php echo e(old('mother_occupation')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_occupation')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-md-6">
                                <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email"><?php echo e(__('field_email')); ?> <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo e(old('email')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="gender"><?php echo e(__('field_gender')); ?> <span>*</span></label>
                                <select class="form-control" name="gender" id="gender" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('gender') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('gender_male')); ?></option>
                                    <option value="2" <?php if( old('gender') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('gender_female')); ?></option>
                                    <option value="3" <?php if( old('gender') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('gender_other')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_gender')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="dob"><?php echo e(__('field_dob')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="dob" id="dob" value="<?php echo e(old('dob')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_dob')); ?>

                                </div>
                            </div>

                            <?php if(field('application_emergency_phone')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="emergency_phone"><?php echo e(__('field_emergency_phone')); ?></label>
                                <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="<?php echo e(old('emergency_phone')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_emergency_phone')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_religion')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="religion"><?php echo e(__('field_religion')); ?></label>
                                <input type="text" class="form-control" name="religion" id="religion" value="<?php echo e(old('religion')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_religion')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_caste')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="caste"><?php echo e(__('field_caste')); ?></label>
                                <input type="text" class="form-control" name="caste" id="caste" value="<?php echo e(old('caste')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_caste')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_mother_tongue')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_tongue"><?php echo e(__('field_mother_tongue')); ?></label>
                                <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" value="<?php echo e(old('mother_tongue')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_tongue')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_nationality')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="nationality"><?php echo e(__('field_nationality')); ?></label>
                                <input type="text" class="form-control" name="nationality" id="nationality" value="<?php echo e(old('nationality')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_nationality')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_marital_status')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="marital_status"><?php echo e(__('field_marital_status')); ?></label>
                                <select class="form-control" name="marital_status" id="marital_status">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('marital_status') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_single')); ?></option>
                                    <option value="2" <?php if( old('marital_status') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_married')); ?></option>
                                    <option value="3" <?php if( old('marital_status') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_widowed')); ?></option>
                                    <option value="4" <?php if( old('marital_status') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_divorced')); ?></option>
                                    <option value="5" <?php if( old('marital_status') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_other')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_marital_status')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_blood_group')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="blood_group"><?php echo e(__('field_blood_group')); ?></label>
                                <select class="form-control" name="blood_group" id="blood_group">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('blood_group') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('A+')); ?></option>
                                    <option value="2" <?php if( old('blood_group') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('A-')); ?></option>
                                    <option value="3" <?php if( old('blood_group') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('B+')); ?></option>
                                    <option value="4" <?php if( old('blood_group') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('B-')); ?></option>
                                    <option value="5" <?php if( old('blood_group') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('AB+')); ?></option>
                                    <option value="6" <?php if( old('blood_group') == 6 ): ?> selected <?php endif; ?>><?php echo e(__('AB-')); ?></option>
                                    <option value="7" <?php if( old('blood_group') == 7 ): ?> selected <?php endif; ?>><?php echo e(__('O+')); ?></option>
                                    <option value="8" <?php if( old('blood_group') == 8 ): ?> selected <?php endif; ?>><?php echo e(__('O-')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_blood_group')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_national_id')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="national_id"><?php echo e(__('field_national_id')); ?></label>
                                <input type="text" class="form-control" name="national_id" id="national_id" value="<?php echo e(old('national_id')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_national_id')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_passport_no')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="passport_no"><?php echo e(__('field_passport_no')); ?></label>
                                <input type="text" class="form-control" name="passport_no" id="passport_no" value="<?php echo e(old('passport_no')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_passport_no')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            </fieldset>
                            </div>
                            </div>

                            <?php if(field('application_address')->status == 1): ?>
                            <div class="row">
                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend><?php echo e(__('field_present')); ?> <?php echo e(__('field_address')); ?></legend>
                                
                                <?php echo $__env->make('common.inc.present_province', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-12">
                                    <label for="present_address"><?php echo e(__('field_address')); ?></label>
                                    <input type="text" class="form-control" name="present_address" id="present_address" value="<?php echo e(old('present_address')); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                                    </div>
                                </div>
                                </fieldset>
                              </div>

                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend><?php echo e(__('field_permanent')); ?> <?php echo e(__('field_address')); ?></legend>
                                
                                <?php echo $__env->make('common.inc.permanent_province', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-12">
                                    <label for="permanent_address"><?php echo e(__('field_address')); ?></label>
                                    <input type="text" class="form-control" name="permanent_address" id="permanent_address" value="<?php echo e(old('permanent_address')); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                                    </div>
                                </div>
                                </fieldset>
                              </div>
                            </div>
                            <?php endif; ?>

                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_academic_information')); ?></legend>
                            <div class="form-group col-md-6">
                            <label for="program"><?php echo e(__('field_program')); ?> <span>*</span></label>
                                <select class="form-control program" name="program" id="program" required>
                                  <option value=""><?php echo e(__('select')); ?></option>
                                  <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($program->id); ?>" <?php if(old('program') == $program->id): ?> selected <?php endif; ?>><?php echo e($program->title); ?></option>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                              <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_program')); ?>

                              </div>
                            </div>
                            </fieldset>
                            <!-- Form End -->
                        </content>

                        <?php if(field('application_school_info')->status == 1 || field('application_collage_info')->status == 1): ?>
                        <h3><?php echo e(__('tab_educational_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <?php if(field('application_school_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_school_information')); ?></legend>
                            <div class="form-group col-md-3">
                                <label for="school_name"><?php echo e(__('field_school_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="school_name" id="school_name" value="<?php echo e(old('school_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_school_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_exam_id"><?php echo e(__('field_exam_id')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="school_exam_id" id="school_exam_id" value="<?php echo e(old('school_exam_id')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_exam_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_graduation_year"><?php echo e(__('field_graduation_year')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="school_graduation_year" id="school_graduation_year" value="<?php echo e(old('school_graduation_year')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_year')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_graduation_point"><?php echo e(__('field_graduation_point')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="school_graduation_point" id="school_graduation_point" value="<?php echo e(old('school_graduation_point')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_point')); ?>

                                </div>
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('application_collage_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_college_information')); ?></legend>
                            <div class="form-group col-md-3">
                                <label for="collage_name"><?php echo e(__('field_collage_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="collage_name" id="collage_name" value="<?php echo e(old('collage_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_exam_id"><?php echo e(__('field_exam_id')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="collage_exam_id" id="collage_exam_id" value="<?php echo e(old('collage_exam_id')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_exam_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_graduation_year"><?php echo e(__('field_graduation_year')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="collage_graduation_year" id="collage_graduation_year" value="<?php echo e(old('collage_graduation_year')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_year')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_graduation_point"><?php echo e(__('field_graduation_point')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="collage_graduation_point" id="collage_graduation_point" value="<?php echo e(old('collage_graduation_point')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_point')); ?>

                                </div>
                            </div>
                            </fieldset>
                            <?php endif; ?>
                            <!-- Form End--->
                        </content>
                        <?php endif; ?>

                        <?php if(field('application_school_transcript')->status == 1 || field('application_school_certificate')->status == 1 || field('application_collage_transcript')->status == 1 || field('application_collage_certificate')->status == 1 || field('application_photo')->status == 1 || field('application_signature')->status == 1): ?>
                        <h3><?php echo e(__('tab_documents')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <?php if(field('application_school_transcript')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="school_transcript"><?php echo e(__('field_school_transcript')); ?> <span>*</span></label>
                                <input type="file" class="form-control" name="school_transcript" id="school_transcript" value="<?php echo e(old('school_transcript')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_school_transcript')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_school_certificate')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="school_certificate"><?php echo e(__('field_school_certificate')); ?> <span>*</span></label>
                                <input type="file" class="form-control" name="school_certificate" id="school_certificate" value="<?php echo e(old('school_certificate')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_school_certificate')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_collage_transcript')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="collage_transcript"><?php echo e(__('field_collage_transcript')); ?> <span>*</span></label>
                                <input type="file" class="form-control" name="collage_transcript" id="collage_transcript" value="<?php echo e(old('collage_transcript')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_transcript')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_collage_certificate')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="collage_certificate"><?php echo e(__('field_collage_certificate')); ?> <span>*</span></label>
                                <input type="file" class="form-control" name="collage_certificate" id="collage_certificate" value="<?php echo e(old('collage_certificate')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_certificate')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_photo')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="photo"><?php echo e(__('field_photo')); ?>: <span><?php echo e(__('image_size', ['height' => 300, 'width' => 300])); ?></span> <span>*</span></label>
                                <input type="file" class="form-control" name="photo" id="photo" value="<?php echo e(old('photo')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_photo')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('application_signature')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="signature"><?php echo e(__('field_signature')); ?>: <span><?php echo e(__('image_size', ['height' => 100, 'width' => 300])); ?></span> <span>*</span></label>
                                <input type="file" class="form-control" name="signature" id="signature" value="<?php echo e(old('signature')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_signature')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            </fieldset>
                            <!-- Form End--->
                        </content>
                        <?php endif; ?>
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
<?php endif; ?>

    
    <?php echo $__env->make('admin.layouts.common.footer_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


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

</body>
</html><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\application\create.blade.php ENDPATH**/ ?>