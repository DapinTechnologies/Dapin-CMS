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
                                <label for="facebook"><?php echo e(__('field_facebook_url')); ?></label>
                                <input type="url" class="form-control" name="facebook" id="facebook" value="<?php echo e(isset($row->facebook)?$row->facebook:''); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_facebook_url')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="twitter"><?php echo e(__('field_twitter_url')); ?></label>
                                <input type="url" class="form-control" name="twitter" id="twitter" value="<?php echo e(isset($row->twitter)?$row->twitter:''); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_twitter_url')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="instagram"><?php echo e(__('field_instagram_url')); ?></label>
                                <input type="url" class="form-control" name="instagram" id="instagram" value="<?php echo e(isset($row->instagram)?$row->instagram:''); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_instagram_url')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="linkedin"><?php echo e(__('field_linkedin_url')); ?></label>
                                <input type="url" class="form-control" name="linkedin" id="linkedin" value="<?php echo e(isset($row->linkedin)?$row->linkedin:''); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_linkedin_url')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="pinterest"><?php echo e(__('field_pinterest_url')); ?></label>
                                <input type="url" class="form-control" name="pinterest" id="pinterest" value="<?php echo e(isset($row->pinterest)?$row->pinterest:''); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_pinterest_url')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="youtube"><?php echo e(__('field_youtube_url')); ?></label>
                                <input type="url" class="form-control" name="youtube" id="youtube" value="<?php echo e(isset($row->youtube)?$row->youtube:''); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_youtube_url')); ?>

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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\web\social-setting\index.blade.php ENDPATH**/ ?>