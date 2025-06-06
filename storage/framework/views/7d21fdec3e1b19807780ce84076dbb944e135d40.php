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

                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $row->id)); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-4">
                            <label for="title"><?php echo e(__('field_title')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="<?php echo e($row->title); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_title')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="faculty"><?php echo e(__('field_faculty')); ?></label>
                            <input type="text" class="form-control" name="faculty" id="faculty" value="<?php echo e($row->faculty); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_faculty')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="semesters"><?php echo e(__('field_total')); ?> <?php echo e(__('field_semester')); ?></label>
                            <input type="text" class="form-control" name="semesters" id="semesters" value="<?php echo e($row->semesters); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_total')); ?> <?php echo e(__('field_semester')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="credits"><?php echo e(__('field_total_credit_hour')); ?></label>
                            <input type="text" class="form-control" name="credits" id="credits" value="<?php echo e($row->credits); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_total_credit_hour')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="courses"><?php echo e(__('field_total')); ?> <?php echo e(__('field_subject')); ?></label>
                            <input type="text" class="form-control" name="courses" id="courses" value="<?php echo e($row->courses); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_total')); ?> <?php echo e(__('field_subject')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="duration"><?php echo e(__('field_duration')); ?></label>
                            <input type="text" class="form-control" name="duration" id="duration" value="<?php echo e($row->duration); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_duration')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="fee"><?php echo e(__('field_total')); ?> <?php echo e(__('field_fee')); ?> (<?php echo $setting->currency_symbol; ?>)</label>
                            <input type="text" class="form-control autonumber" name="fee" id="fee" value="<?php echo e(round($row->fee)); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_total')); ?> <?php echo e(__('field_fee')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-8">
                            <label for="attach"><?php echo e(__('field_thumbnail')); ?>: <span><?php echo e(__('image_size', ['height' => 500, 'width' => 800])); ?></span></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="<?php echo e(old('attach')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_thumbnail')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description"><?php echo e(__('field_description')); ?> <span>*</span></label>
                            <textarea class="form-control texteditor" name="description" id="description" required><?php echo e($row->description); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_description')); ?>

                            </div>
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

<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\web\course\edit.blade.php ENDPATH**/ ?>