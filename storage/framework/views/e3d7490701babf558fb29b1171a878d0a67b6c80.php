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
                        <h5><?php echo e($title); ?> <?php echo e(__('list')); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route .'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="session"><?php echo e(__('field_session')); ?></label>
                                    <select class="form-control" name="session" id="session">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->session_id); ?>" <?php if( $selected_session == $session->session_id): ?> selected <?php endif; ?>><?php echo e($session->session->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="semester"><?php echo e(__('field_semester')); ?></label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $semesters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $semester): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($semester->semester_id); ?>" <?php if( $selected_semester == $semester->semester_id): ?> selected <?php endif; ?>><?php echo e($semester->semester->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_semester')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th><?php echo e(__('field_session')); ?></th>
                                        <th><?php echo e(__('field_semester')); ?></th>
                                        <th><?php echo e(__('field_start_date')); ?></th>
                                        <th><?php echo e(__('field_end_date')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($row->assignment->status == 1): ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <?php
                                        $unread = 0;
                                        $user = Auth::guard('student')->user();
                                        foreach ($user->unreadNotifications as $notification) {
                                            if($notification->data['type'] == 'assignment' && $notification->data['id'] == $row->assignment->id) {
                                                $unread = 1;
                                            }
                                        }
                                        ?>
                                        <td>
                                            <?php if($unread == 1): ?>
                                            <a href="<?php echo e(route($route.'.show', $row->id)); ?>"><b><?php echo str_limit($row->assignment->title ?? '', 50, ' ...'); ?></b></a>
                                            <?php else: ?>
                                            <a href="<?php echo e(route($route.'.show', $row->id)); ?>"><?php echo str_limit($row->assignment->title ?? '', 50, ' ...'); ?></a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->assignment->subject->code ?? ''); ?></td>
                                        <td><?php echo e($row->studentEnroll->session->title ?? ''); ?></td>
                                        <td><?php echo e($row->studentEnroll->semester->title ?? ''); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->assignment->start_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->assignment->start_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->assignment->end_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->assignment->end_date))); ?>

                                            <?php endif; ?>
                                        </td>
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
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/assignment/index.blade.php ENDPATH**/ ?>