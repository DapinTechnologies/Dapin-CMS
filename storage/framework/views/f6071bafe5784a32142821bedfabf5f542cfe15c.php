<?php $__env->startSection('title', $title); ?>
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

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-12">
                            <label for="title"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e(old('title')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="sub_title"><?php echo e(__('field_sub_title')); ?></label>
                            <textarea class="form-control" name="sub_title" id="sub_title" rows="4"><?php echo e(old('sub_title')); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_sub_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="button_text"><?php echo e(__('field_button_text')); ?></label>
                            <input type="text" class="form-control" name="button_text" id="button_text" value="<?php echo e(old('button_text')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_button_text')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="button_link"><?php echo e(__('field_button_link')); ?></label>
                            <input type="url" class="form-control" name="button_link" id="button_link" value="<?php echo e(old('button_link')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_button_link')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="attach"><?php echo e(__('field_thumbnail')); ?>: <span><?php echo e(__('image_size', ['height' => 850, 'width' => 1920])); ?></span> <span>*</span></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="<?php echo e(old('attach')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_thumbnail')); ?>

                            </div>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\web\slider\create.blade.php ENDPATH**/ ?>