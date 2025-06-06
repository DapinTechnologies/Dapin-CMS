<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-8">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                    <div class="card">
                        <div class="card-header">
                            <h5><?php echo e(__('btn_update')); ?> <?php echo e($title); ?></h5>
                        </div>
                        <div class="card-block">
                          <div class="row">
                            <!-- Form Start -->
                            <input name="id" type="hidden" value="<?php echo e((isset($row->id))?$row->id:-1); ?>">
                            <input name="slug" type="hidden" value="fees-schedule">

                            <div class="form-group col-md-6">
                                <label for="day" class="form-label"><?php echo e(__('field_days_before')); ?> <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="day" id="day" value="<?php echo e(isset($row->day)?$row->day:''); ?>"  required data-v-max="999999999" data-v-min="0">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_days_before')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="time" class="form-label"><?php echo e(__('field_time')); ?> <span>*</span></label>
                                <input type="time" class="form-control time" name="time" id="time" value="<?php echo e(isset($row->time)?$row->time:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_time')); ?>

                                </div>
                            </div>

                            <div class="form-group-inline col-md-6">
                                <div class="switch d-inline m-r-10">
                                    <input type="checkbox" id="switch" name="email" value="1"  <?php if(isset($row->email)): ?> <?php echo e($row->email == 1 ? 'checked' : ''); ?> <?php endif; ?>>
                                    <label for="switch" class="cr"></label>
                                </div>
                                <label><?php echo e(__('field_email_notify')); ?></label>
                            </div>

                            <div class="form-group-inline col-md-6">
                                <div class="switch d-inline m-r-10">
                                    <input type="checkbox" id="switch-1" name="sms" value="1"  <?php if(isset($row->sms)): ?> <?php echo e($row->sms == 1 ? 'checked' : ''); ?> <?php endif; ?>>
                                    <label for="switch-1" class="cr"></label>
                                </div>
                                <label><?php echo e(__('field_sms_notify')); ?></label>
                            </div>

                            <!-- Form End -->
                          </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\schedule-setting\index.blade.php ENDPATH**/ ?>