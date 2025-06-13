<?php $__env->startSection('title', $title); ?>

<?php $__env->startSection('page_css'); ?>
    <!-- Full calendar css -->
    <link rel="stylesheet" href="<?php echo e(asset('dashboard/plugins/fullcalendar/css/fullcalendar.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">

            <?php
                function field($slug){
                    return \App\Models\Field::field($slug);
                }
            ?> 

            <?php if(field('panel_assignment')->status == 1): ?>
            <div class="col-sm-12 col-lg-12">
                <div class="card">
                    <?php if(isset($assignments)): ?>
                    <div class="card-header">
                        <h5><?php echo e(trans_choice('module_assignment', 2)); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $__currentLoopData = $assignments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($row->assignment->status == 1): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('student.assignment.show', $row->id)); ?>"><?php echo str_limit($row->assignment->title ?? '', 50, ' ...'); ?></a>
                                        </td>
                                        <td><?php echo e($row->assignment->subject->code ?? ''); ?></td>
                                        <td>
                                            <?php if( $row->attendance == 1 ): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_submitted')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>

        </div>
 
        <div class="row">
            <div class="col-xl-8 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(trans_choice('module_calendar', 2)); ?></h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Calendar ] start -->
                        <div id='calendar' class='calendar'></div>
                        <!-- [ Calendar ] end -->
                    </div>
                </div>
            </div>
           
            <div class="col-xl-4 col-md-4 col-sm-12">
                <!-- [Today's Classes] start -->
                <div class="card statistial-visit">
                    <div class="card-header">
                        <h5><?php echo e(__('Today\'s Classes')); ?> (<?php echo e(\Carbon\Carbon::now()->format('l')); ?>)</h5>
                        <?php if(isset($program_id)): ?>
                            <span class="badge badge-primary">
                                <i class="fas fa-graduation-cap"></i> 
                                Program: <?php echo e(App\Models\Program::find($program_id)->name ?? 'N/A'); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="card-block">
                        <?php if($today_classes->isNotEmpty()): ?>
                            <?php $__currentLoopData = $today_classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p>
                                <mark style="color: #6777ef;">
                                    <i class="fas fa-book-open"></i>
                                    <span style="color: inherit;">
                                        <?php echo e($class->subject->code ?? 'N/A'); ?> - 
                                        <?php if(isset($setting->time_format)): ?>
                                        <?php echo e(date($setting->time_format, strtotime($class->start_time))); ?> to 
                                        <?php echo e(date($setting->time_format, strtotime($class->end_time))); ?>

                                        <?php else: ?>
                                        <?php echo e(date("h:i A", strtotime($class->start_time))); ?> to 
                                        <?php echo e(date("h:i A", strtotime($class->end_time))); ?>

                                        <?php endif; ?>
                                    </span>
                                </mark>
                                <br>
                                <small>
                                    <?php echo e(__('Unit')); ?>: <?php echo e($class->subject->code ?? 'N/A'); ?> |
                                    <?php echo e(__('Room')); ?>: <?php echo e($class->room->title ?? 'N/A'); ?> | 
                                    <?php echo e(__('Lecturer')); ?>: <?php echo e($class->teacher->first_name ?? ''); ?> <?php echo e($class->teacher->last_name ?? ''); ?> 
                                </small>
                            </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p>
                                <mark style="color: #6777ef;">
                                    <i class="fas fa-book-open"></i>
                                    <span style="color: inherit;">
                                        <?php echo e(__('No classes scheduled for today')); ?>

                                    </span>
                                </mark>
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- [Today's Classes] end -->
                
                <!-- [Notice List] start -->
                <div class="card statistial-visit" style="margin-top: 20px;">
                    <div class="card-header">
                        <h5><?php echo e(__('Recent Notices')); ?></h5>
                    </div>
                    <div class="card-block">
                        <?php if($latest_notices->isNotEmpty()): ?>
                            <?php $__currentLoopData = $latest_notices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <p>
                                <mark style="color: #6777ef;">
                                    <i class="fas fa-bullhorn"></i>
                                    <a href="<?php echo e(route('student.notice.show', $notice->id)); ?>" style="color: inherit;">
                                        <?php echo e($notice->title); ?>

                                    </a>
                                </mark>
                                <br>
                                <small>
                                    <?php if(isset($setting->date_format)): ?>
                                    <?php echo e(date($setting->date_format, strtotime($notice->date))); ?>

                                    <?php else: ?>
                                    <?php echo e(date("Y-m-d", strtotime($notice->date))); ?>

                                    <?php endif; ?>
                                </small>
                            </p>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p><?php echo e(__('No recent notices')); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <!-- [Notice List] end -->
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
    <!-- Full calendar js -->
    <script src="<?php echo e(asset('dashboard/plugins/fullcalendar/js/lib/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/fullcalendar/js/lib/jquery-ui.min.js')); ?>"></script>
    <script src="<?php echo e(asset('dashboard/plugins/fullcalendar/js/fullcalendar.min.js')); ?>"></script>

    <script type="text/javascript">
        // Full calendar
        $(window).on('load', function() {
            "use strict";
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'today'
                },
                defaultDate: '<?php echo date("Y-m-d"); ?>',
                editable: false,
                droppable: false,
                events: [
                <?php
                    foreach($events as $key => $row){
                        echo "{
                                title: '".$row->title."',
                                start: '".$row->start_date."',
                                end: '".$row->end_date."',
                                borderColor: '".$row->color."',
                                backgroundColor: '".$row->color."',
                                textColor: '#fff'
                            }, ";
                    }
                ?>
                ],
            });
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/index.blade.php ENDPATH**/ ?>