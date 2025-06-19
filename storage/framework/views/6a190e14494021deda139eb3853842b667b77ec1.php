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
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block row">
                        
                        <!-- Form Start -->
                        <input name="id" type="hidden" value="<?php echo e((isset($row)) ? $row->id : ''); ?>">
                        <input name="slug" type="hidden" value="student-card">

                        <div class="form-group col-md-6">
                            <label for="title"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e(isset($row->title)?$row->title:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="subtitle"><?php echo e(__('field_subtitle')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="subtitle" id="subtitle" value="<?php echo e(isset($row->subtitle)?$row->subtitle:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_subtitle')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="validity"><?php echo e(__('field_validity')); ?> <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="validity" id="validity" value="<?php echo e(isset($row->validity)?$row->validity:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_validity')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="address"><?php echo e(__('field_address')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="address" id="address" value="<?php echo e(isset($row->address)?$row->address:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_address')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="prefix" class="form-label"><?php echo e(__('field_prefix')); ?></label>
                            <input type="text" class="form-control" name="prefix" id="prefix" value="<?php echo e(isset($row->prefix)?$row->prefix:''); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_prefix')); ?>

                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><?php if(isset($row)): ?> <i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?> <?php else: ?> <i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?> <?php endif; ?></button>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/id-card-setting/index.blade.php ENDPATH**/ ?>