<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.teacher')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="teacher"><?php echo e(__('field_staff_id')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="teacher" id="teacher" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($teacher->id); ?>" <?php if($selected_staff == $teacher->id): ?> selected <?php endif; ?>><?php echo e($teacher->staff_id); ?> - <?php echo e($teacher->first_name); ?> <?php echo e($teacher->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_staff_id')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>


                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="table class-routine-table">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('day_saturday')); ?></th>
                                        <th><?php echo e(__('day_sunday')); ?></th>
                                        <th><?php echo e(__('day_monday')); ?></th>
                                        <th><?php echo e(__('day_tuesday')); ?></th>
                                        <th><?php echo e(__('day_wednesday')); ?></th>
                                        <th><?php echo e(__('day_thursday')); ?></th>
                                        <th><?php echo e(__('day_friday')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $weekdays = array('1', '2', '3', '4', '5', '6', '7');
                                    ?>
                                    <tr>
                                        <?php $__currentLoopData = $weekdays; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $weekday): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <td>
                                            <?php $__currentLoopData = $rows->where('day', $weekday); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="class-time">
                                            <?php echo e($row->subject->code ?? ''); ?><br>
                                            <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->start_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->start_time))); ?>

                                            <?php endif; ?> <br> <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->end_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->end_time))); ?>

                                            <?php endif; ?><br>
                                            <?php echo e(__('field_room')); ?>: <?php echo e($row->room->title ?? ''); ?><br>
                                            <?php echo e($row->teacher->staff_id); ?> - <?php echo e($row->teacher->first_name ?? ''); ?>

                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\business\backup\Dapin\Dapin\resources\views\admin\class-routine\teacher.blade.php ENDPATH**/ ?>