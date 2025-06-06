<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
<script src="<?php echo e(asset('dashboard/plugins/jquery/js/jquery.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">

            <!-- [ Card ] start -->
            <div class="col-lg-12">
              <div class="card">
                <div class="card-header">
                    <h5><?php echo e($title); ?></h5>
                </div>
                <div class="card-block">
                    <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                    <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                </div>
                
                <div class="card-block">
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', [$row->id])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                        <content class="form-step">
                            <!-- Form Start -->
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
                                <label for="father_name"><?php echo e(__('field_father_name')); ?></label>
                                <input type="text" class="form-control" name="father_name" id="father_name" value="<?php echo e($row->father_name); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="father_occupation"><?php echo e(__('field_father_occupation')); ?></label>
                                <input type="text" class="form-control" name="father_occupation" id="father_occupation" value="<?php echo e($row->father_occupation); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_father_occupation')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mother_name"><?php echo e(__('field_mother_name')); ?></label>
                                <input type="text" class="form-control" name="mother_name" id="mother_name" value="<?php echo e($row->mother_name); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_name')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="mother_occupation"><?php echo e(__('field_mother_occupation')); ?></label>
                                <input type="text" class="form-control" name="mother_occupation" id="mother_occupation" value="<?php echo e($row->mother_occupation); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_mother_occupation')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="occupation"><?php echo e(__('field_occupation')); ?></label>
                                <input type="text" class="form-control" name="occupation" id="occupation" value="<?php echo e($row->occupation); ?>">

                                <div class="invalid-feedback">
                                <?php echo e(__('required_field')); ?> <?php echo e(__('field_occupation')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="religion"><?php echo e(__('field_religion')); ?></label>
                                <input type="text" class="form-control" name="religion" id="religion" value="<?php echo e($row->religion); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_religion')); ?>

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
                            </fieldset>
                            

                            <fieldset class="row scheduler-border">
                            <div class="form-group col-md-6">
                                <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($row->phone); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="email"><?php echo e(__('field_email')); ?></label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo e($row->email); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="national_id"><?php echo e(__('field_national_id')); ?></label>
                                <input type="text" class="form-control" name="national_id" id="national_id" value="<?php echo e($row->national_id); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_national_id')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="passport_no"><?php echo e(__('field_passport_no')); ?></label>
                                <input type="text" class="form-control" name="passport_no" id="passport_no" value="<?php echo e($row->passport_no); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_passport_no')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="photo"><?php echo e(__('field_photo')); ?>: <span><?php echo e(__('image_size', ['height' => 300, 'width' => 300])); ?></span></label>
                                <input type="file" class="form-control" name="photo" id="photo" value="<?php echo e(old('photo')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_photo')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->photo)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->photo)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
                                <?php endif; ?>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="signature"><?php echo e(__('field_signature')); ?>: <span><?php echo e(__('image_size', ['height' => 100, 'width' => 300])); ?></span></label>
                                <input type="file" class="form-control" name="signature" id="signature" value="<?php echo e(old('signature')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_signature')); ?>

                                </div>

                                <?php if(is_file('uploads/'.$path.'/'.$row->signature)): ?>
                                    <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->signature)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;" onerror="this.src='<?php echo e(asset('dashboard/images/user/avatar-2.jpg')); ?>';">
                                <?php endif; ?>
                            </div>
                            </fieldset>

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

                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                            </div>
                            <!-- Form End -->
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\library-outsider\edit.blade.php ENDPATH**/ ?>