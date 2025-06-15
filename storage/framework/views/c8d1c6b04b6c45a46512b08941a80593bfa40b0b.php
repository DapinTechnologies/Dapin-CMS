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
                        <h5><?php echo e(__('modal_add')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.create')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <?php
                        function field($slug){
                            return \App\Models\Field::field($slug);
                        }
                    ?>
                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data" style="display: none;">
                    <?php echo csrf_field(); ?>

                        <h3><?php echo e(__('tab_profile_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start -->
                            <div class="row">
                            <div class="col-md-12">
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-4">
                                <label for="staff_id"><?php echo e(__('field_staff_id')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="staff_id" id="staff_id" value="<?php echo e(old('staff_id')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_staff_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="first_name"><?php echo e(__('field_first_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e(old('first_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_first_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="last_name"><?php echo e(__('field_last_name')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e(old('last_name')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_last_name')); ?>

                                </div>
                            </div>

                            <?php if(field('user_father_name')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="father_name"><?php echo e(__('field_father_name')); ?></label>
                                <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e(old('father_name')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_mother_name')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="mother_name"><?php echo e(__('field_mother_name')); ?></label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="<?php echo e(old('mother_name')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_name')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-md-4">
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

                            <div class="form-group col-md-4">
                                <label for="role"><?php echo e(__('field_role')); ?> <span>*</span></label>
                                <select class="form-control" name="roles[]" id="role" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($role->id); ?>" <?php if(old('roles') == $role->id): ?> selected <?php endif; ?>><?php echo e($role->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_role')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="department"><?php echo e(__('field_department')); ?> <span>*</span></label>
                                <select class="form-control" name="department" id="department" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($department->id); ?>" <?php if(old('department') == $department->id): ?> selected <?php endif; ?>><?php echo e($department->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_department')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="designation"><?php echo e(__('field_designation')); ?> <span>*</span></label>
                                <select class="form-control" name="designation" id="designation" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($designation->id); ?>" <?php if(old('designation') == $designation->id): ?> selected <?php endif; ?>><?php echo e($designation->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_designation')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="dob"><?php echo e(__('field_dob')); ?> <span>*</span></label>
                                <input type="date" class="form-control date" name="dob" id="dob" value="<?php echo e(old('dob')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_dob')); ?>

                                </div>
                            </div>

                            <?php if(field('user_joining_date')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="joining_date"><?php echo e(__('field_joining_date')); ?></label>
                                <input type="date" class="form-control date" name="joining_date" id="joining_date" value="<?php echo e(old('joining_date')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_joining_date')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_ending_date')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="ending_date"><?php echo e(__('field_ending_date')); ?></label>
                                <input type="date" class="form-control date" name="ending_date" id="ending_date" value="<?php echo e(old('ending_date')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_ending_date')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <div class="form-group col-md-4">
                                <label for="email"><?php echo e(__('field_email')); ?> <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo e(old('email')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(old('phone')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                </div>
                            </div>

                            <?php if(field('user_emergency_phone')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="emergency_phone"><?php echo e(__('field_emergency_phone')); ?></label>
                                <input type="text" class="form-control" name="emergency_phone" id="emergency_phone" value="<?php echo e(old('emergency_phone')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_emergency_phone')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_religion')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="religion"><?php echo e(__('field_religion')); ?></label>
                                <input type="text" class="form-control" name="religion" id="religion" value="<?php echo e(old('religion')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_religion')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_caste')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="caste"><?php echo e(__('field_caste')); ?></label>
                                <input type="text" class="form-control" name="caste" id="caste" value="<?php echo e(old('caste')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_caste')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_mother_tongue')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="mother_tongue"><?php echo e(__('field_mother_tongue')); ?></label>
                                <input type="text" class="form-control" name="mother_tongue" id="mother_tongue" value="<?php echo e(old('mother_tongue')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_tongue')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_nationality')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="nationality"><?php echo e(__('field_nationality')); ?></label>
                                <input type="text" class="form-control" name="nationality" id="nationality" value="<?php echo e(old('nationality')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_nationality')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_marital_status')->status == 1): ?>
                            <div class="form-group col-md-4">
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

                            <?php if(field('user_blood_group')->status == 1): ?>
                            <div class="form-group col-md-4">
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

                            <?php if(field('user_national_id')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="national_id"><?php echo e(__('field_national_id')); ?></label>
                                <input type="text" class="form-control" name="national_id" id="national_id" value="<?php echo e(old('national_id')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_national_id')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_passport_no')->status == 1): ?>
                            <div class="form-group col-md-4">
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

                            <?php if(field('user_address')->status == 1): ?>
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
                            <!-- Form End -->
                        </content>

                        <?php if(field('user_education')->status == 1): ?>
                        <h3><?php echo e(__('tab_educational_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="education_level"><?php echo e(__('field_education_level')); ?></label>
                                <input type="text" class="form-control" name="education_level" id="education_level" value="<?php echo e(old('education_level')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_education_level')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="graduation_academy"><?php echo e(__('field_graduation_academy')); ?></label>
                                <input type="text" class="form-control" name="graduation_academy" id="graduation_academy" value="<?php echo e(old('graduation_academy')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_academy')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="year_of_graduation"><?php echo e(__('field_year_of_graduation')); ?></label>
                                <input type="text" class="form-control autonumber" name="year_of_graduation" id="year_of_graduation" value="<?php echo e(old('year_of_graduation')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_year_of_graduation')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="graduation_field"><?php echo e(__('field_graduation_field')); ?></label>
                                <input type="text" class="form-control" name="graduation_field" id="graduation_field" value="<?php echo e(old('graduation_field')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_graduation_field')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="experience"><?php echo e(__('field_experience')); ?></label>
                                <textarea class="form-control" name="experience" id="experience"><?php echo e(old('experience')); ?></textarea>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_experience')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="note"><?php echo e(__('field_note')); ?></label>
                                <textarea class="form-control" name="note" id="note"><?php echo e(old('note')); ?></textarea>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                                </div>
                            </div>

                            
                            </fieldset>
                            <!-- Form End--->
                        </content>
                        <?php endif; ?>

                        <h3><?php echo e(__('tab_payroll_details')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-4">
                                <label for="contract_type"><?php echo e(__('field_contract_type')); ?> <span>*</span></label>
                                <select class="form-control" name="contract_type" id="contract_type" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('contract_type') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('contract_type_full_time')); ?></option>
                                    <option value="2" <?php if( old('contract_type') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('contract_type_part_time')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_contract_type')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="work_shift"><?php echo e(__('field_work_shift')); ?> <span>*</span></label>
                                <select class="form-control" name="work_shift" id="work_shift" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <?php $__currentLoopData = $work_shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($shift->id); ?>" <?php if( old('work_shift') == $shift->id ): ?> selected <?php endif; ?>><?php echo e($shift->title); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_work_shift')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="salary_type"><?php echo e(__('field_salary_type')); ?> <span>*</span></label>
                                <select class="form-control" name="salary_type" id="salary_type" required>
                                    <option value=""><?php echo e(__('select')); ?></option>
                                    <option value="1" <?php if( old('salary_type') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('salary_type_fixed')); ?></option>
                                    <option value="2" <?php if( old('salary_type') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('salary_type_hourly')); ?></option>
                                </select>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_salary_type')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="basic_salary"><?php echo e(__('salary_type_hourly')); ?> / <?php echo e(__('salary_type_fixed')); ?> <?php echo e(__('field_salary')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="basic_salary" id="basic_salary" value="<?php echo e(old('basic_salary')); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('salary_type_hourly')); ?> / <?php echo e(__('salary_type_fixed')); ?> <?php echo e(__('field_salary')); ?>

                                </div>
                            </div>

                            <?php if(field('user_epf_no')->status == 1): ?>
                            <div class="form-group col-md-4">
                                <label for="epf_no"><?php echo e(__('field_epf_no')); ?></label>
                                <input type="text" class="form-control" name="epf_no" id="epf_no" value="<?php echo e(old('epf_no')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_epf_no')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            </fieldset>
                            <!-- Form End--->
                        </content>

                        <?php if(field('user_bank_account')->status == 1): ?>
                        <h3><?php echo e(__('tab_bank_info')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-4">
                                <label for="bank_account_name"><?php echo e(__('field_bank_account_name')); ?></label>
                                <input type="text" class="form-control" name="bank_account_name" id="bank_account_name" value="<?php echo e(old('bank_account_name')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_bank_account_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="bank_account_no"><?php echo e(__('field_bank_account_no')); ?></label>
                                <input type="text" class="form-control autonumber" name="bank_account_no" id="bank_account_no" value="<?php echo e(old('bank_account_no')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_bank_account_no')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="bank_name"><?php echo e(__('field_bank_name')); ?></label>
                                <input type="text" class="form-control" name="bank_name" id="bank_name" value="<?php echo e(old('bank_name')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_bank_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="ifsc_code"><?php echo e(__('field_ifsc_code')); ?></label>
                                <input type="text" class="form-control" name="ifsc_code" id="ifsc_code" value="<?php echo e(old('ifsc_code')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_ifsc_code')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="bank_brach"><?php echo e(__('field_bank_brach')); ?></label>
                                <input type="text" class="form-control" name="bank_brach" id="bank_brach" value="<?php echo e(old('bank_brach')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_bank_brach')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="tin_no"><?php echo e(__('field_tin_no')); ?></label>
                                <input type="text" class="form-control" name="tin_no" id="tin_no" value="<?php echo e(old('tin_no')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_tin_no')); ?>

                                </div>
                            </div>
                            </fieldset>
                            <!-- Form End--->
                        </content>
                        <?php endif; ?>

                        <h3><?php echo e(__('tab_documents')); ?></h3>
                        <content class="form-step">
                            <!-- Form Start--->
                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="photo"><?php echo e(__('field_photo')); ?>: <span><?php echo e(__('image_size', ['height' => 300, 'width' => 300])); ?></span></label>
                                <input type="file" class="form-control" name="photo" id="photo" value="<?php echo e(old('photo')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_photo')); ?>

                                </div>
                            </div>

                            <?php if(field('user_signature')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="signature"><?php echo e(__('field_signature')); ?>: <span><?php echo e(__('image_size', ['height' => 100, 'width' => 300])); ?></span></label>
                                <input type="file" class="form-control" name="signature" id="signature" value="<?php echo e(old('signature')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_signature')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_resume')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="resume"><?php echo e(__('field_resume')); ?></label>
                                <input type="file" class="form-control" name="resume" id="resume" value="<?php echo e(old('resume')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_resume')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(field('user_joining_letter')->status == 1): ?>
                            <div class="form-group col-md-6">
                                <label for="joining_letter"><?php echo e(__('field_joining_letter')); ?></label>
                                <input type="file" class="form-control" name="joining_letter" id="joining_letter" value="<?php echo e(old('joining_letter')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_joining_letter')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                            </fieldset>

                            <?php if(field('user_documents')->status == 1): ?>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/user/create.blade.php ENDPATH**/ ?>