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

                                            <?php endif; ?> <br/> <?php if(isset($setting->time_format)): ?>
                                            <?php echo e(date($setting->time_format, strtotime($row->end_time))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("h:i A", strtotime($row->end_time))); ?>

                                            <?php endif; ?><br>
                                            <?php echo e(__('field_room')); ?>: <?php echo e($row->room->title ?? ''); ?><br>
                                            <?php echo e($row->teacher->first_name ?? ''); ?> <?php echo e($row->teacher->last_name ?? ''); ?>

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
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/class-routine/index.blade.php ENDPATH**/ ?>