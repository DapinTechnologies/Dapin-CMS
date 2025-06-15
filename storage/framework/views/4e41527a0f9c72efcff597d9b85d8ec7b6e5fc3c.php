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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.report')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="role"><?php echo e(__('field_role')); ?></label>
                                    <select class="form-control" name="role" id="role">
                                        <option value=""><?php echo e(__('all')); ?>

                                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($role->slug != 'super-admin'): ?>
                                        <option value="<?php echo e($role->id); ?>" <?php if( $selected_role == $role->id): ?> selected <?php endif; ?>><?php echo e($role->name); ?></option>
                                        <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_role')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="department"><?php echo e(__('field_department')); ?></label>
                                    <select class="form-control" name="department" id="department">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $department): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($department->id); ?>" <?php if( $selected_department == $department->id): ?> selected <?php endif; ?>><?php echo e($department->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_department')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="designation"><?php echo e(__('field_designation')); ?></label>
                                    <select class="form-control" name="designation" id="designation">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($designation->id); ?>" <?php if( $selected_designation == $designation->id): ?> selected <?php endif; ?>><?php echo e($designation->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_designation')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="shift"><?php echo e(__('field_work_shift')); ?></label>
                                    <select class="form-control" name="shift" id="shift">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $work_shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($shift->id); ?>" <?php if( $selected_shift == $shift->id): ?> selected <?php endif; ?>><?php echo e($shift->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_work_shift')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="month"><?php echo e(__('field_month')); ?> <span>*</span></label>
                                    <select class="form-control" name="month" id="month" required>
                                        <option value="1" <?php if($selected_month == 1): ?> selected <?php endif; ?>><?php echo e(__('month_january')); ?></option>
                                        <option value="2" <?php if($selected_month == 2): ?> selected <?php endif; ?>><?php echo e(__('month_february')); ?></option>
                                        <option value="3" <?php if($selected_month == 3): ?> selected <?php endif; ?>><?php echo e(__('month_march')); ?></option>
                                        <option value="4" <?php if($selected_month == 4): ?> selected <?php endif; ?>><?php echo e(__('month_april')); ?></option>
                                        <option value="5" <?php if($selected_month == 5): ?> selected <?php endif; ?>><?php echo e(__('month_may')); ?></option>
                                        <option value="6" <?php if($selected_month == 6): ?> selected <?php endif; ?>><?php echo e(__('month_june')); ?></option>
                                        <option value="7" <?php if($selected_month == 7): ?> selected <?php endif; ?>><?php echo e(__('month_july')); ?></option>
                                        <option value="8" <?php if($selected_month == 8): ?> selected <?php endif; ?>><?php echo e(__('month_august')); ?></option>
                                        <option value="9" <?php if($selected_month == 9): ?> selected <?php endif; ?>><?php echo e(__('month_september')); ?></option>
                                        <option value="10" <?php if($selected_month == 10): ?> selected <?php endif; ?>><?php echo e(__('month_october')); ?></option>
                                        <option value="11" <?php if($selected_month == 11): ?> selected <?php endif; ?>><?php echo e(__('month_november')); ?></option>
                                        <option value="12" <?php if($selected_month == 12): ?> selected <?php endif; ?>><?php echo e(__('month_december')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_month')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="year"><?php echo e(__('field_year')); ?> <span>*</span></label>
                                    <select class="form-control" name="year" id="year" required>
                                        <option value="<?php echo e(date("Y")); ?>" <?php if($selected_year == date("Y")): ?> selected <?php endif; ?>><?php echo e(date("Y")); ?></option>
                                        <option value="<?php echo e(date("Y") - 1); ?>" <?php if($selected_year == date("Y") - 1): ?> selected <?php endif; ?>><?php echo e(date("Y") - 1); ?></option>
                                        <option value="<?php echo e(date("Y") - 2); ?>" <?php if($selected_year == date("Y") - 2): ?> selected <?php endif; ?>><?php echo e(date("Y") - 2); ?></option>
                                        <option value="<?php echo e(date("Y") - 3); ?>" <?php if($selected_year == date("Y") - 3): ?> selected <?php endif; ?>><?php echo e(date("Y") - 3); ?></option>
                                        <option value="<?php echo e(date("Y") - 4); ?>" <?php if($selected_year == date("Y") - 4): ?> selected <?php endif; ?>><?php echo e(date("Y") - 4); ?></option>
                                        <option value="<?php echo e(date("Y") - 5); ?>" <?php if($selected_year == date("Y") - 5): ?> selected <?php endif; ?>><?php echo e(date("Y") - 5); ?></option>
                                        <option value="<?php echo e(date("Y") - 6); ?>" <?php if($selected_year == date("Y") - 6): ?> selected <?php endif; ?>><?php echo e(date("Y") - 6); ?></option>
                                        <option value="<?php echo e(date("Y") - 7); ?>" <?php if($selected_year == date("Y") - 7): ?> selected <?php endif; ?>><?php echo e(date("Y") - 7); ?></option>
                                        <option value="<?php echo e(date("Y") - 8); ?>" <?php if($selected_year == date("Y") - 8): ?> selected <?php endif; ?>><?php echo e(date("Y") - 8); ?></option>
                                        <option value="<?php echo e(date("Y") - 9); ?>" <?php if($selected_year == date("Y") - 9): ?> selected <?php endif; ?>><?php echo e(date("Y") - 9); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_year')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_search')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.report')); ?>" class="btn btn-info"><i class="fas fa-sync-alt"></i> <?php echo e(__('btn_refresh')); ?></a>

                        <?php if(isset($rows)): ?>
                        <button type="button" class="btn btn-dark btn-print">
                            <i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?>

                        </button>
                        <?php endif; ?>
                    </div>
                    
                    <div class="card-header">
                        <p><?php echo e(__('attendance_present')); ?>: <span class="text-primary"><?php echo e(__('P')); ?></span> | <?php echo e(__('attendance_absent')); ?>: <span class="text-danger"><?php echo e(__('A')); ?></span> | <?php echo e(__('attendance_leave')); ?>: <span class="text-success"><?php echo e(__('L')); ?></span> | <?php echo e(__('attendance_holiday')); ?>: <span class="text-warning"><?php echo e(__('H')); ?></span></p>
                    </div>
                    <div class="card-block">
                        <?php
                        $start = $selected_year.'-'.$selected_month.'-01';
                        $date = $selected_year.'-'.$selected_month.'-01';
                        ?>
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="table table-attendance table-striped table-hover table-bordered printable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_staff_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <?php for($i = 0; $i < \Carbon\Carbon::parse($start)->daysInMonth; ++$i): ?>

                                            <th class='text-center'>
                                                <?php echo e(date('d', strtotime($date))); ?>

                                            </th>

                                            <?php
                                            $date = date("Y-m-d", strtotime("+1 day", strtotime($date)));
                                            ?>
                                        <?php endfor; ?>
                                        <th><?php echo e(__('P')); ?></th>
                                        <th><?php echo e(__('A')); ?></th>
                                        <th><?php echo e(__('L')); ?></th>
                                        <th><?php echo e(__('H')); ?></th>
                                        <th><?php echo e(__('%')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php
                                    $atten_date = date("Y-m-d", strtotime($selected_year.'-'.$selected_month.'-01'));
                                  ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.user.show', $row->id)); ?>">
                                                #<?php echo e($row->staff_id); ?>

                                            </a>
                                        </td>
                                        <td><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></td>
                                        <?php for($i = 0; $i < \Carbon\Carbon::parse($start)->daysInMonth; ++$i): ?>
                                            <td>
                                            <?php if(isset($attendances)): ?>
                                            <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($attendance->user_id == $row->id && date("Y-m-d", strtotime($attendance->date)) == $atten_date): ?>
                                                <?php if($attendance->attendance == 1): ?>
                                                <div class="text-primary"><?php echo e(__('P')); ?></div>
                                                <?php elseif($attendance->attendance == 2): ?>
                                                <div class="text-danger"><?php echo e(__('A')); ?></div>
                                                <?php elseif($attendance->attendance == 3): ?>
                                                <div class="text-success"><?php echo e(__('L')); ?></div>
                                                <?php elseif($attendance->attendance == 4): ?>
                                                <div class="text-warning"><?php echo e(__('H')); ?></div>
                                                <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                            <?php
                                            $atten_date = date("Y-m-d", strtotime("+1 day", strtotime($atten_date)));
                                            ?>
                                            </td>
                                        <?php endfor; ?>
                                        <?php
                                            $total_present = 0;
                                            $total_absent = 0;
                                            $total_leave = 0;
                                            $total_holiday = 0;
                                        ?>
                                        <?php if(isset($attendances)): ?>
                                        <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user_attend): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($user_attend->user_id == $row->id): ?>
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
                                        <td><?php echo e($total_present); ?></td>
                                        <td><?php echo e($total_absent); ?></td>
                                        <td><?php echo e($total_leave); ?></td>
                                        <td><?php echo e($total_holiday); ?></td>
                                        <?php
                                            $total_working_days = $total_present + $total_absent + $total_leave;
                                            if($total_working_days == 0){
                                                $total_working_days = 1;
                                            }
                                        ?>
                                        <td><?php echo e(round((($total_present / $total_working_days) * 100), 2)); ?> %</td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>

                                <caption><?php echo e(date("F Y", strtotime($selected_year.'-'.$selected_month.'-01')) ?? ''); ?></caption>
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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/staff-daily-attendance/report.blade.php ENDPATH**/ ?>