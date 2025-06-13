<?php $__env->startSection('title', $title); ?>

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
                        <h5><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <?php
                        function field($slug){
                            return \App\Models\Field::field($slug);
                        }
                    ?>
                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

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

                            <?php if(field('student_father_name')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="father_name"><?php echo e(__('field_father_name')); ?></label>
                                <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e($row->father_name); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_father_occupation')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="father_occupation"><?php echo e(__('field_father_occupation')); ?></label>
                                <input type="text" class="form-control" name="father_occupation" id="father_occupation" value="<?php echo e($row->father_occupation); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_occupation')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_mother_name')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_name"><?php echo e(__('field_mother_name')); ?></label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="<?php echo e($row->mother_name); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_mother_occupation')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_occupation"><?php echo e(__('field_mother_occupation')); ?></label>
                                <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" value="<?php echo e($row->mother_occupation); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_occupation')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

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

                            <?php if(field('student_emergency_phone')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="emergency_phone"><?php echo e(__('field_emergency_phone')); ?></label>
                                <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="<?php echo e($row->emergency_phone); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_emergency_phone')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_religion')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="religion"><?php echo e(__('field_religion')); ?></label>
                                <input type="text" class="form-control" name="religion" id="religion" value="<?php echo e($row->religion); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_religion')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_caste')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="caste"><?php echo e(__('field_caste')); ?></label>
                                <input type="text" class="form-control" name="caste" id="caste" value="<?php echo e($row->caste); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_caste')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_mother_tongue')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="mother_tongue"><?php echo e(__('field_mother_tongue')); ?></label>
                                <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" value="<?php echo e($row->mother_tongue); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_tongue')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_nationality')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="nationality"><?php echo e(__('field_nationality')); ?></label>
                                <input type="text" class="form-control" name="nationality" id="nationality" value="<?php echo e($row->nationality); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_nationality')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_marital_status')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="marital_status"><?php echo e(__('field_marital_status')); ?></label>
                                <select class="form-control" name="marital_status" id="marital_status">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( $row->marital_status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_single')); ?></option>
                                    <option value="2" <?php if( $row->marital_status == 2 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_married')); ?></option>
                                    <option value="3" <?php if( $row->marital_status == 3 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_widowed')); ?></option>
                                    <option value="4" <?php if( $row->marital_status == 4 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_divorced')); ?></option>
                                    <option value="5" <?php if( $row->marital_status == 5 ): ?> selected <?php endif; ?>><?php echo e(__('marital_status_other')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_marital_status')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_blood_group')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="blood_group"><?php echo e(__('field_blood_group')); ?></label>
                                <select class="form-control" name="blood_group" id="blood_group">
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( $row->blood_group == 1 ): ?> selected <?php endif; ?>><?php echo e(__('A+')); ?></option>
                                    <option value="2" <?php if( $row->blood_group == 2 ): ?> selected <?php endif; ?>><?php echo e(__('A-')); ?></option>
                                    <option value="3" <?php if( $row->blood_group == 3 ): ?> selected <?php endif; ?>><?php echo e(__('B+')); ?></option>
                                    <option value="4" <?php if( $row->blood_group == 4 ): ?> selected <?php endif; ?>><?php echo e(__('B-')); ?></option>
                                    <option value="5" <?php if( $row->blood_group == 5 ): ?> selected <?php endif; ?>><?php echo e(__('AB+')); ?></option>
                                    <option value="6" <?php if( $row->blood_group == 6 ): ?> selected <?php endif; ?>><?php echo e(__('AB-')); ?></option>
                                    <option value="7" <?php if( $row->blood_group == 7 ): ?> selected <?php endif; ?>><?php echo e(__('O+')); ?></option>
                                    <option value="8" <?php if( $row->blood_group == 8 ): ?> selected <?php endif; ?>><?php echo e(__('O-')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_blood_group')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_national_id')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="national_id"><?php echo e(__('field_national_id')); ?></label>
                                <input type="text" class="form-control" name="national_id" id="national_id" value="<?php echo e($row->national_id); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_national_id')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_passport_no')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="passport_no"><?php echo e(__('field_passport_no')); ?></label>
                                <input type="text" class="form-control" name="passport_no" id="passport_no" value="<?php echo e($row->passport_no); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_passport_no')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-md-6">
                                <label for="admission_date"><?php echo e(__('field_admission_date')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="admission_date" id="admission_date" value="<?php echo e($row->admission_date); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_admission_date')); ?>

                                </div>
                            </div>
                            </fieldset>
                            </div>
                            </div>

                            <?php if(field('student_address')->status == 1): ?>
                            <div class="row">
                              <div class="col-md-6">
                                <fieldset class="row scheduler-border">
                                <legend><?php echo e(__('field_present')); ?> <?php echo e(__('field_address')); ?></legend>
                                <?php echo $__env->make('common.inc.present_province', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-12">
                                    <label for="present_address"><?php echo e(__('field_address')); ?></label>
                                    <input type="text" class="form-control" name="present_address" id="present_address" value="<?php echo e($row->present_address); ?>">

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
                                    <input type="text" class="form-control" name="permanent_address" id="permanent_address" value="<?php echo e($row->permanent_address); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                                    </div>
                                </div>
                                </fieldset>
                              </div>
                            </div>
                            <?php endif; ?>
                            <!-- Form End -->
                        </content>

                        <h3><?php echo e(__('tab_educational_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <?php if(field('student_school_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_school_information')); ?></legend>
                            <div class="form-group col-md-3">
                                <label for="school_name"><?php echo e(__('field_school_name')); ?></label>
                                <input type="text" class="form-control" name="school_name" id="school_name" value="<?php echo e($row->school_name); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_school_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_exam_id"><?php echo e(__('field_exam_id')); ?></label>
                                <input type="text" class="form-control" name="school_exam_id" id="school_exam_id" value="<?php echo e($row->school_exam_id); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_exam_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_graduation_year"><?php echo e(__('field_graduation_year')); ?></label>
                                <input type="text" class="form-control" name="school_graduation_year" id="school_graduation_year" value="<?php echo e($row->school_graduation_year); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_year')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="school_graduation_point"><?php echo e(__('field_graduation_point')); ?></label>
                                <input type="text" class="form-control" name="school_graduation_point" id="school_graduation_point" value="<?php echo e($row->school_graduation_point); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_point')); ?>

                                </div>
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <?php if(field('student_collage_info')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_college_information')); ?></legend>
                            <div class="form-group col-md-3">
                                <label for="collage_name"><?php echo e(__('field_collage_name')); ?></label>
                                <input type="text" class="form-control" name="collage_name" id="collage_name" value="<?php echo e($row->collage_name); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_exam_id"><?php echo e(__('field_exam_id')); ?></label>
                                <input type="text" class="form-control" name="collage_exam_id" id="collage_exam_id" value="<?php echo e($row->collage_exam_id); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_exam_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_graduation_year"><?php echo e(__('field_graduation_year')); ?></label>
                                <input type="text" class="form-control" name="collage_graduation_year" id="collage_graduation_year" value="<?php echo e($row->collage_graduation_year); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_year')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-3">
                                <label for="collage_graduation_point"><?php echo e(__('field_graduation_point')); ?></label>
                                <input type="text" class="form-control" name="collage_graduation_point" id="collage_graduation_point" value="<?php echo e($row->collage_graduation_point); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_point')); ?>

                                </div>
                            </div>
                            </fieldset>
                            <?php endif; ?>

                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_academic_information')); ?></legend>
                            <div class="form-group col-md-4">
                                <label for="student_id"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="student_id" id="student_id" value="<?php echo e($row->student_id); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="batch"><?php echo e(__('field_batch')); ?> <span>*</span></label>
                                <select class="form-control" name="batch" id="batch" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($batch->id); ?>" <?php if( $row->batch_id == $batch->id): ?> selected <?php endif; ?>><?php echo e($batch->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                    <?php echo e(__('required_field')); ?> <?php echo e(__('field_batch')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="status"><?php echo e(__('field_status')); ?></label>
                                <select class="form-control select2" name="statuses[]" id="status" multiple>
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($status->id); ?>" <?php $__currentLoopData = $row->statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($stat->id == $status->id ? 'selected' : ''); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>><?php echo e($status->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_status')); ?>

                                </div>
                            </div>
                            </fieldset>
                            
                            <?php if(field('student_relatives')->status == 1): ?>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_guardians_information')); ?></legend>
                            <div class="container-fluid">

                            <?php $__currentLoopData = $row->relatives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relative): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <hr/>
                            <div id="inputFormField" class="row">
                            <div class="form-group col-md-4">
                                <label for="relation" class="form-label"><?php echo e(__('field_relation')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="relations[]" id="relation" value="<?php echo e($relative->relation); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_relation')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="relative_name" class="form-label"><?php echo e(__('field_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="relative_names[]" id="relative_name" value="<?php echo e($relative->name); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="occupation" class="form-label"><?php echo e(__('field_occupation')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="occupations[]" id="occupation" value="<?php echo e($relative->occupation); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_occupation')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="relative_phone" class="form-label"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="relative_phones[]" id="relative_phone" value="<?php echo e($relative->phone); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="address" class="form-label"><?php echo e(__('field_address')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="addresses[]" id="address" value="<?php echo e($relative->address); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> <?php echo e(__('btn_remove')); ?></button>
                            </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <div id="newField" class="clearfix"></div>
                            <div class="form-group">
                                <button id="addField" type="button" class="btn btn-info"><i class="fas fa-plus"></i> <?php echo e(__('btn_add_new')); ?></button>
                            </div>
                            </div>
                            </fieldset>
                            <?php endif; ?>
                            <!-- Form End--->
                        </content>

                        <?php if(field('student_school_transcript')->status == 1 || field('student_school_certificate')->status == 1 || field('student_collage_transcript')->status == 1 || field('student_collage_certificate')->status == 1 || field('student_photo')->status == 1 || field('student_signature')->status == 1 || field('student_documents')->status == 1): ?>
                        <h3><?php echo e(__('tab_documents')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <?php if(field('student_school_transcript')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="school_transcript"><?php echo e(__('field_school_transcript')); ?></label>
                                <input type="file" class="form-control" name="school_transcript" id="school_transcript" value="<?php echo e(old('school_transcript')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_school_transcript')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->school_transcript)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->school_transcript)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_school_certificate')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="school_certificate"><?php echo e(__('field_school_certificate')); ?></label>
                                <input type="file" class="form-control" name="school_certificate" id="school_certificate" value="<?php echo e(old('school_certificate')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_school_certificate')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->school_certificate)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->school_certificate)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_collage_transcript')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="collage_transcript"><?php echo e(__('field_collage_transcript')); ?></label>
                                <input type="file" class="form-control" name="collage_transcript" id="collage_transcript" value="<?php echo e(old('collage_transcript')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_transcript')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->collage_transcript)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->collage_transcript)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_collage_certificate')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="collage_certificate"><?php echo e(__('field_collage_certificate')); ?></label>
                                <input type="file" class="form-control" name="collage_certificate" id="collage_certificate" value="<?php echo e(old('collage_certificate')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_collage_certificate')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->collage_certificate)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->collage_certificate)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            
                            <?php if(field('student_photo')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="photo"><?php echo e(__('field_photo')); ?>: <span><?php echo e(__('image_size', ['height' => 300, 'width' => 300])); ?></span></label>
                                <input type="file" class="form-control" name="photo" id="photo" value="<?php echo e(old('photo')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_photo')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->photo)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->photo)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>

                            <?php if(field('student_signature')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="signature"><?php echo e(__('field_signature')); ?>: <span><?php echo e(__('image_size', ['height' => 100, 'width' => 300])); ?></span></label>
                                <input type="file" class="form-control" name="signature" id="signature" value="<?php echo e(old('signature')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_signature')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->signature)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->signature)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;">
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                            </fieldset>

                            <?php if(field('student_documents')->status == 1): ?>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_document')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $row->documents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($document->title); ?></td>
                                        <td>
                                        <?php if(is_file('uploads/'.$path.'/'.$document->attach)): ?>
                                        <a href="<?php echo e(asset('uploads/'.$path.'/'.$document->attach)); ?>" class="btn btn-sm btn-icon btn-dark" download><i class="fas fa-download"></i></a>
                                        <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <fieldset class="row scheduler-border">
                            <legend><?php echo e(__('field_upload')); ?> <?php echo e(__('field_document')); ?></legend>
                            <div class="container-fluid">
                            <div id="newDocument" class="clearfix"></div>
                            <div class="form-group">
                                <button id="addDocument" type="button" class="btn btn-info"><i class="fas fa-plus"></i> <?php echo e(__('btn_add_new')); ?></button>
                            </div>
                            </div>
                            </fieldset>
                            <?php endif; ?>
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

    <script type="text/javascript">
    (function ($) {
        "use strict";
        // add Field
        $(document).on('click', '#addField', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="inputFormField" class="row">';
            html += '<div class="form-group col-md-4"><label for="relation" class="form-label"><?php echo e(__('field_relation')); ?> <span>*</span></label><input type="text" class="form-control" name="relations[]" id="relation" value="<?php echo e(old('relation')); ?>" required><div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_relation')); ?></div></div>';
            html += '<div class="form-group col-md-4"><label for="relative_name" class="form-label"><?php echo e(__('field_name')); ?> <span>*</span></label><input type="text" class="form-control" name="relative_names[]" id="relative_name" value="<?php echo e(old('relative_name')); ?>" required><div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_name')); ?></div></div>';
            html += '<div class="form-group col-md-4"><label for="occupation" class="form-label"><?php echo e(__('field_occupation')); ?> <span>*</span></label><input type="text" class="form-control" name="occupations[]" id="occupation" value="<?php echo e(old('occupation')); ?>" required><div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_occupation')); ?></div></div>';
            html += '<div class="form-group col-md-4"><label for="relative_phone" class="form-label"><?php echo e(__('field_phone')); ?> <span>*</span></label><input type="text" class="form-control" name="relative_phones[]" id="relative_phone" value="<?php echo e(old('relative_phone')); ?>" required><div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?></div></div>';
            html += '<div class="form-group col-md-4"><label for="address" class="form-label"><?php echo e(__('field_address')); ?> <span>*</span></label><input type="text" class="form-control" name="addresses[]" id="address" value="<?php echo e(old('address')); ?>" required><div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?></div></div>';
            html += '<div class="form-group col-md-4"><button id="removeField" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> <?php echo e(__('btn_remove')); ?></button></div>';
            html += '</div>';

            $('#newField').append(html);
        });

        // remove Field
        $(document).on('click', '#removeField', function () {
            $(this).closest('#inputFormField').remove();
        });
    }(jQuery));
    </script>

    <script type="text/javascript">
    (function ($) {
        "use strict";
        // add Field
        $(document).on('click', '#addDocument', function () {
            var html = '';
            html += '<hr/>';
            html += '<div id="documentFormField" class="row">';
            html += '<div class="form-group col-md-4"><label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label><input type="text" class="form-control" name="titles[]" id="title" value="<?php echo e(old('title')); ?>" required><div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?></div></div>';
            html += '<div class="form-group col-md-4"><label for="document" class="form-label"><?php echo e(__('field_document')); ?> <span>*</span></label><input type="file" class="form-control" name="documents[]" id="document" value="<?php echo e(old('document')); ?>" required><div class="invalid-feedback"><?php echo e(__('required_field')); ?> <?php echo e(__('field_document')); ?></div></div>';
            html += '<div class="form-group col-md-4"><button id="removeDocument" type="button" class="btn btn-danger btn-filter"><i class="fas fa-trash-alt"></i> <?php echo e(__('btn_remove')); ?></button></div>';
            html += '</div>';

            $('#newDocument').append(html);
        });

        // remove Field
        $(document).on('click', '#removeDocument', function () {
            $(this).closest('#documentFormField').remove();
        });
    }(jQuery));
    </script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/student/edit.blade.php ENDPATH**/ ?>