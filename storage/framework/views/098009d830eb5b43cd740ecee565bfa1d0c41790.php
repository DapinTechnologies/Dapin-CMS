<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-8">
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

                            <div class="form-group col-md-6">
                                <label for="email" class="form-label"><?php echo e(__('field_email')); ?> <span>*</span></label>
                                <input type="email" class="form-control" name="email" id="email" value="<?php echo e(isset($row->email)?$row->email:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_email')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="phone" class="form-label"><?php echo e(__('field_phone')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="phone" id="phone" value="<?php echo e(isset($row->phone)?$row->phone:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_phone')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="address" class="form-label"><?php echo e(__('field_address')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="address" id="address" value="<?php echo e(isset($row->address)?$row->address:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                                </div>
                            </div>

                            

                            <div class="form-group col-md-6">
                                <label for="social_status"><?php echo e(__('field_social_status')); ?> <span>*</span></label>
                                <br/>

                                <div class="radio radio-success d-inline">
                                    <input type="radio" name="social_status" value="1" id="show" <?php if( isset($row->social_status) && $row->social_status == 1 ): ?> checked <?php endif; ?> required>
                                    <label for="show" class="cr"><?php echo e(__('status_show')); ?></label>
                                </div>

                                <div class="radio radio-danger d-inline">
                                    <input type="radio" name="social_status" value="0" id="hide" <?php if( isset($row->social_status) && $row->social_status == 0 ): ?> checked <?php endif; ?> required>
                                    <label for="hide" class="cr"><?php echo e(__('status_hide')); ?></label>
                                </div>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_social_status')); ?>

                                </div>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\web\topbar-setting\index.blade.php ENDPATH**/ ?>