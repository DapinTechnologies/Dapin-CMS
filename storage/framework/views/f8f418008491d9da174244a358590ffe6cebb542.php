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
                        <h5><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>

                        <a href="<?php echo e(route($route.'.edit', $row->id)); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>
                    </div>

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', [$row->id])); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-12">
                            <label for="title" class="form-label"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e($row->title); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="body" class="form-label"><?php echo e(__('field_body')); ?> <span>*</span></label>
                            <textarea class="form-control" name="body" id="body" rows="8" required><?php echo e($row->body); ?></textarea>

                            <div class="alert alert-secondary" role="alert">
                                <?php echo e(__('field_shortcode')); ?>: 
                                [first_name] [last_name] [dob] [gender] [student_id] [batch] [program] [faculty] [father_name] [mother_name] [starting_year] [ending_year] [starting_session] [ending_session] [credits] [cgpa] [grade] [email] [phone]
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="footer_left" class="form-label"><?php echo e(__('field_footer_left')); ?></label>
                            <textarea class="form-control" name="footer_left" id="footer_left"><?php echo e($row->footer_left); ?></textarea>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="footer_center" class="form-label"><?php echo e(__('field_footer_center')); ?></label>
                            <textarea class="form-control" name="footer_center" id="footer_center"><?php echo e($row->footer_center); ?></textarea>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="footer_right" class="form-label"><?php echo e(__('field_footer_right')); ?></label>
                            <textarea class="form-control" name="footer_right" id="footer_right"><?php echo e($row->footer_right); ?></textarea>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="logo_left"><?php echo e(__('field_logo_left')); ?>: <span><?php echo e(__('image_size', ['height' => 200, 'width' => 'Any'])); ?></span></label>
                            <input type="file" class="form-control" name="logo_left" id="logo_left" value="<?php echo e(old('logo_left')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_logo_left')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="background"><?php echo e(__('field_border_background')); ?>: <span><?php echo e(__('image_size', ['height' => 'Any', 'width' =>800])); ?></span></label>
                            <input type="file" class="form-control" name="background" id="background" value="<?php echo e(old('background')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_border_background')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="width" class="form-label"><?php echo e(__('field_width')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="width" id="width" value="<?php echo e($row->width); ?>" placeholder="800px" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_width')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="height" class="form-label"><?php echo e(__('field_height')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="height" id="height" value="<?php echo e($row->height); ?>" placeholder="auto" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_height')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4 mt-4">
                            <div class="switch d-inline m-r-10">
                                <input type="checkbox" id="student_photo-<?php echo e($row->id); ?>" name="student_photo" value="1" <?php if($row->student_photo == 1): ?> checked <?php endif; ?>>
                                <label for="student_photo-<?php echo e($row->id); ?>" class="cr"></label>
                            </div>
                            <label><?php echo e(__('field_student_photo')); ?></label>
                        </div>

                        <div class="form-group col-md-4 mt-4">
                            <div class="switch d-inline m-r-10">
                                <input type="checkbox" id="barcode-<?php echo e($row->id); ?>" name="barcode" value="1" <?php if($row->barcode == 1): ?> checked <?php endif; ?>>
                                <label for="barcode-<?php echo e($row->id); ?>" class="cr"></label>
                            </div>
                            <label><?php echo e(__('field_barcode')); ?></label>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="status" class="form-label"><?php echo e(__('select_status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" <?php if( $row->status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_active')); ?></option>
                                <option value="0" <?php if( $row->status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_inactive')); ?></option>
                            </select>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\certificate-template\edit.blade.php ENDPATH**/ ?>