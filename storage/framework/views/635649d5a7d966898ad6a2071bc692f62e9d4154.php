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
                        <h5><?php echo e($title); ?></h5>
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
                        <div class="form-group col-md-4">
                            <label for="apply_date"><?php echo e(__('field_apply_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control" name="apply_date" id="apply_date" value="<?php echo e(date('Y-m-d')); ?>" readonly required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_apply_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="from_date"><?php echo e(__('field_start_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="from_date" id="from_date" value="<?php echo e(old('from_date')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_start_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="to_date"><?php echo e(__('field_end_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="to_date" id="to_date" value="<?php echo e(old('to_date')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_end_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="subject"><?php echo e(__('field_leave_subject')); ?> <span>*</span></label>
                            <input type="text" class="form-control" name="subject" id="subject" value="<?php echo e(old('subject')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_leave_subject')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="reason"><?php echo e(__('field_reason')); ?></label>
                            <textarea class="form-control" name="reason" id="reason"><?php echo e(old('reason')); ?></textarea>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_reason')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="attach"><?php echo e(__('field_attach')); ?></label>
                            <input type="file" class="form-control" name="attach" id="attach" value="<?php echo e(old('attach')); ?>">

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_attach')); ?>

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
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/student/leave/create.blade.php ENDPATH**/ ?>