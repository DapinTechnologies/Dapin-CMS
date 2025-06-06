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

                        <div class="form-group col-md-12">
                            <label for="title"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e(isset($row->title)?$row->title:''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="sub_title"><?php echo e(__('field_sub_title')); ?> <span>*</span></label>
                            <textarea class="form-control" name="sub_title" id="sub_title" rows="4" required><?php echo e(isset($row->sub_title)?$row->sub_title:''); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_sub_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="button_text"><?php echo e(__('field_button_text')); ?></label>
                            <input type="text" class="form-control" name="button_text" id="button_text" value="<?php echo e(isset($row->button_text)?$row->button_text:''); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_button_text')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="button_link"><?php echo e(__('field_button_link')); ?></label>
                            <input type="url" class="form-control" name="button_link" id="button_link" value="<?php echo e(isset($row->button_link)?$row->button_link:''); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_button_link')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status" class="form-label"><?php echo e(__('select_status')); ?></label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" <?php if( isset($row->status) && $row->status == 1 ): ?> selected <?php endif; ?>><?php echo e(__('status_active')); ?></option>
                                <option value="0" <?php if( isset($row->status) && $row->status == 0 ): ?> selected <?php endif; ?>><?php echo e(__('status_inactive')); ?></option>
                            </select>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\web\call-to-action\index.blade.php ENDPATH**/ ?>