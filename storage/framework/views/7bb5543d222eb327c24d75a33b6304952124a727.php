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
                        <div class="card-block">
                          <div class="row">
                            <!-- Form Start -->
                            <input name="id" type="hidden" value="<?php echo e((isset($row->id))?$row->id:-1); ?>">
                            <input name="slug" type="hidden" value="admit-card">

                            <div class="form-group col-md-12">
                                <label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="title" id="title" value="<?php echo e(isset($row->title)?$row->title:''); ?>" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="body" class="form-label"><?php echo e(__('field_body')); ?></label>
                                <textarea class="form-control texteditor" name="body" id="body"><?php echo e(isset($row->body)?$row->body:''); ?></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="footer_left" class="form-label"><?php echo e(__('field_footer_left')); ?></label>
                                <textarea class="form-control" name="footer_left" id="footer_left"><?php echo e(isset($row->footer_left)?$row->footer_left:''); ?></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="footer_right" class="form-label"><?php echo e(__('field_footer_right')); ?></label>
                                <textarea class="form-control" name="footer_right" id="footer_right"><?php echo e(isset($row->footer_right)?$row->footer_right:''); ?></textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="width" class="form-label"><?php echo e(__('field_width')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="width" id="width" value="<?php echo e(isset($row->width)?$row->width:'600px'); ?>" placeholder="600px" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_width')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="height" class="form-label"><?php echo e(__('field_height')); ?> <span>*</span></label>
                                <input type="text" class="form-control" name="height" id="height" value="<?php echo e(isset($row->height)?$row->height:'auto'); ?>" placeholder="auto" required>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_height')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="logo_left"><?php echo e(__('field_logo_left')); ?>: <span><?php echo e(__('image_size', ['height' => 200, 'width' => 'Any'])); ?></span></label>

                                <?php if(isset($row->logo_left) && is_file('uploads/'.$path.'/'.$row->logo_left)): ?>
                                <img src="<?php echo e(asset('uploads/'.$path.'/'.$row->logo_left)); ?>" class="img-fluid" style="max-width: 80px; max-height: 80px;">
                                <?php endif; ?>
                                
                                <input type="file" class="form-control" name="logo_left" id="logo_left" value="<?php echo e(old('logo_left')); ?>">

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_logo_left')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6 mt-4">
                                <div class="switch d-inline m-r-10">
                                    <input type="checkbox" id="student_photo" name="student_photo" value="1" <?php if(isset($row->student_photo)): ?> <?php if($row->student_photo == 1): ?> checked <?php endif; ?> <?php else: ?> checked <?php endif; ?>>
                                    <label for="student_photo" class="cr"></label>
                                </div>
                                <label><?php echo e(__('field_student_photo')); ?></label>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/admit-setting/index.blade.php ENDPATH**/ ?>