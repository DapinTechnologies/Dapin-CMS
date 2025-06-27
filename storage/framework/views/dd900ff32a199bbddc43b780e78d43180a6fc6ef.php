
<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('dashboard/css/pages/wizard.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('modal_add')); ?> <?php echo e(__('field_student')); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>
                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>
                    
                    <div class="wizard-sec-bg">
                        <form id="wizard-advanced-form" class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <input type="text" name="registration_no" value="<?php echo e($row->registration_no); ?>" hidden>

                            <h3><?php echo e(__('tab_basic_info')); ?></h3>
                            <content class="form-step">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name"><?php echo e(__('field_first_name')); ?> <span>*</span></label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="<?php echo e($row->first_name); ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="last_name"><?php echo e(__('field_last_name')); ?> <span>*</span></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="<?php echo e($row->last_name); ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender"><?php echo e(__('field_gender')); ?> <span>*</span></label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value=""><?php echo e(__('select')); ?></option>
                                            <option value="1" <?php if( $row->gender == 1 ): ?> selected <?php endif; ?>><?php echo e(__('gender_male')); ?></option>
                                            <option value="2" <?php if( $row->gender == 2 ): ?> selected <?php endif; ?>><?php echo e(__('gender_female')); ?></option>
                                            <option value="3" <?php if( $row->gender == 3 ): ?> selected <?php endif; ?>><?php echo e(__('gender_other')); ?></option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dob"><?php echo e(__('field_dob')); ?> <span>*</span></label>
                                        <input type="date" class="form-control date" name="dob" id="dob" value="<?php echo e($row->dob); ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e($row->phone); ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email"><?php echo e(__('field_email')); ?> <span>*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?php echo e($row->email); ?>" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="national_id"><?php echo e(__('field_national_id')); ?></label>
                                        <input type="text" class="form-control" name="national_id" id="national_id" value="<?php echo e($row->national_id); ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="admission_date"><?php echo e(__('field_admission_date')); ?> <span>*</span></label>
                                        <input type="date" class="form-control date" name="admission_date" id="admission_date" value="<?php echo e(date('Y-m-d')); ?>" required>
                                    </div>
                                </div>
                            </content>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\cms\Dapin-CMS\resources\views/admin/application/edit.blade.php ENDPATH**/ ?>