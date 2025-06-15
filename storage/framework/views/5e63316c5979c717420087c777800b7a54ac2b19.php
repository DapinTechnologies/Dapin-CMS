<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <form class="needs-validation" novalidate action="<?php echo e(route($route.'.store')); ?>" method="post" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                        <span>Total contribution of final result must be equal to 100%</span>
                    </div>
                    <div class="card-block row">
                        
                        <!-- Form Start -->
                        <input name="id" type="hidden" value="<?php echo e((isset($row)) ? $row->id : '-1'); ?>">

                        <?php $__currentLoopData = $exams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="text" name="exams[]" value="<?php echo e($exam->id); ?>" hidden>

                        <div class="form-group col-md-4">
                            <label for="exam-<?php echo e($key); ?>"><?php echo e($exam->title); ?> (%) <span>*</span></label>
                            <input type="text" class="form-control" name="contributions[]" id="exam-<?php echo e($key); ?>" value="<?php echo e(round($exam->contribution, 2)); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e($exam->title); ?>

                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        <div class="form-group col-md-4">
                            <label for="attendances"><?php echo e(__('field_attendance')); ?> (%) <span>*</span></label>
                            <input type="text" class="form-control" name="attendances" id="attendances" value="<?php echo e(isset($row->attendances)?round($row->attendances, 2):''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_attendance')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="assignments"><?php echo e(__('field_assignment')); ?> (%) <span>*</span></label>
                            <input type="text" class="form-control" name="assignments" id="assignments" value="<?php echo e(isset($row->assignments)?round($row->assignments, 2):''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_assignment')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="activities"><?php echo e(__('field_activities')); ?> (%) <span>*</span></label>
                            <input type="text" class="form-control" name="activities" id="activities" value="<?php echo e(isset($row->activities)?round($row->activities, 2):''); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_activities')); ?>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/result-contribution/index.blade.php ENDPATH**/ ?>