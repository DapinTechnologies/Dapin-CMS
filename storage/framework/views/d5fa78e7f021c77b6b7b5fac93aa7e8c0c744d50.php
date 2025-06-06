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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route .'.student-attendance')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="student"><?php echo e(__('field_student')); ?> <span>*</span></label>
                                    <select class="form-control select2" name="student" id="student" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>" <?php if($selected_student == $student->id): ?> selected <?php endif; ?>><?php echo e($student->student_id); ?> - <?php echo e($student->first_name); ?> <?php echo e($student->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_student')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="session"><?php echo e(__('field_session')); ?> <span>*</span></label>
                                    <select class="form-control" name="session" id="session" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($session->id); ?>" <?php if($selected_session == $session->id): ?> selected <?php endif; ?>><?php echo e($session->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                        <?php echo e(__('required_field')); ?> <?php echo e(__('field_session')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <?php if(isset($attendances) && isset($studentEnroll)): ?>
                    <div class="card-header">
                        <p><?php echo e(__('attendance_present')); ?>: <span class="text-primary"><?php echo e(__('P')); ?></span> | <?php echo e(__('attendance_absent')); ?>: <span class="text-danger"><?php echo e(__('A')); ?></span> | <?php echo e(__('attendance_leave')); ?>: <span class="text-success"><?php echo e(__('L')); ?></span> | <?php echo e(__('attendance_holiday')); ?>: <span class="text-warning"><?php echo e(__('H')); ?></span></p>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="table table-attendance table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_subject')); ?></th>
                                        <th><?php echo e(__('field_code')); ?></th>
                                        <th><?php echo e(__('field_period')); ?></th>
                                        <th><?php echo e(__('P')); ?></th>
                                        <th><?php echo e(__('A')); ?></th>
                                        <th><?php echo e(__('L')); ?></th>
                                        <th><?php echo e(__('H')); ?></th>
                                        <th><?php echo e(__('%')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $grand_total_working = 0;
                                    $grand_total_present = 0;
                                    $grand_total_absent = 0;
                                    $grand_total_leave = 0;
                                    $grand_total_holiday = 0;
                                  ?>
                                  <?php $__currentLoopData = $studentEnroll->subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($row->title); ?></td>
                                        <td><?php echo e($row->code); ?></td>
                                        <?php
                                            $total_present = 0;
                                            $total_absent = 0;
                                            $total_leave = 0;
                                            $total_holiday = 0;
                                        ?>
                                        <?php if(isset($attendances)): ?>
                                        <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_attend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user_attend->subject_id == $row->id): ?>
                                            <?php if($user_attend->attendance == 1): ?>
                                            <?php
                                                $total_present = $total_present + 1;
                                            ?>
                                            <?php elseif($user_attend->attendance == 2): ?>
                                            <?php
                                                $total_absent = $total_absent + 1;
                                            ?>
                                            <?php elseif($user_attend->attendance == 3): ?>
                                            <?php
                                                $total_leave = $total_leave + 1;
                                            ?>
                                            <?php elseif($user_attend->attendance == 4): ?>
                                            <?php
                                                $total_holiday = $total_holiday + 1;
                                            ?>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <?php
                                            $total_working_days = $total_present + $total_absent + $total_leave;
                                        ?>
                                        <td><?php echo e($total_working_days); ?></td>
                                        <td><?php echo e($total_present); ?></td>
                                        <td><?php echo e($total_absent); ?></td>
                                        <td><?php echo e($total_leave); ?></td>
                                        <td><?php echo e($total_holiday); ?></td>
                                        <?php
                                            $grand_total_working = $grand_total_working + $total_working_days;
                                            $grand_total_present = $grand_total_present + $total_present;
                                            $grand_total_absent = $grand_total_absent + $total_absent;
                                            $grand_total_leave = $grand_total_leave + $total_leave;
                                            $grand_total_holiday = $grand_total_holiday + $total_holiday;
                                            if($total_working_days == 0){
                                                $total_working_days = 1;
                                            }
                                        ?>
                                        <td><?php echo e(round((($total_present / $total_working_days) * 100), 2)); ?> %</td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th><?php echo e(__('field_grand_total')); ?></th>
                                        <th><?php echo e($grand_total_working); ?></th>
                                        <th><?php echo e($grand_total_present); ?></th>
                                        <th><?php echo e($grand_total_absent); ?></th>
                                        <th><?php echo e($grand_total_leave); ?></th>
                                        <th><?php echo e($grand_total_holiday); ?></th>
                                        <?php
                                            if($grand_total_working == 0){
                                                $grand_total_working = 1;
                                            }
                                        ?>
                                        <th><?php echo e(round((($grand_total_present / $grand_total_working) * 100), 2)); ?> %</th>
                                    </tr>
                                </tfoot>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\report\student-attendance.blade.php ENDPATH**/ ?>