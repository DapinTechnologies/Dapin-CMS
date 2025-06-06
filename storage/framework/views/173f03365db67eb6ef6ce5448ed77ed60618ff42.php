<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.leave')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-2">
                                    <label for="user"><?php echo e(__('field_staff')); ?></label>
                                    <select class="form-control select2" name="user" id="user">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($user->id); ?>" <?php if($selected_user == $user->id): ?> selected <?php endif; ?>><?php echo e($user->staff_id); ?> - <?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_staff')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="pay_type"><?php echo e(__('field_pay_type')); ?></label>
                                    <select class="form-control" name="pay_type" id="pay_type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if($selected_pay_type == 1): ?> selected <?php endif; ?>><?php echo e(__('field_paid_leave')); ?></option>
                                        <option value="2" <?php if($selected_pay_type == 2): ?> selected <?php endif; ?>><?php echo e(__('field_unpaid_leave')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_pay_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="type"><?php echo e(__('field_leave_type')); ?></label>
                                    <select class="form-control" name="type" id="type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($type->id); ?>" <?php if($selected_type == $type->id): ?> selected <?php endif; ?>><?php echo e($type->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_leave_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="duration"><?php echo e(__('field_duration')); ?></label>
                                    <select class="form-control" name="duration" id="duration">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php if($selected_duration == '1'): ?> selected <?php endif; ?>><?php echo e(__('cal_1_month')); ?></option>
                                        <option value="3" <?php if($selected_duration == '3'): ?> selected <?php endif; ?>><?php echo e(__('cal_3_months')); ?></option>
                                        <option value="6" <?php if($selected_duration == '6'): ?> selected <?php endif; ?>><?php echo e(__('cal_6_months')); ?></option>
                                        <option value="12" <?php if($selected_duration == '12'): ?> selected <?php endif; ?>><?php echo e(__('cal_1_year')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_duration')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="report-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <caption><?php echo e(date($setting->date_format ?? "Y-m-d", strtotime($start_date))); ?> - <?php echo e(date($setting->date_format ?? "Y-m-d", strtotime($end_date))); ?></caption>

                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_staff_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_leave_type')); ?></th>
                                        <th><?php echo e(__('field_pay_type')); ?></th>
                                        <th><?php echo e(__('field_leave_date')); ?></th>
                                        <th><?php echo e(__('field_days')); ?></th>
                                        <th><?php echo e(__('field_apply_date')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $total_days = 0; ?>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php
                                            $total_days = $total_days + (int)((strtotime($row->to_date) - strtotime($row->from_date))/86400) + 1;
                                        ?>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.user.show', $row->user->id)); ?>">
                                                #<?php echo e($row->user->staff_id ?? ''); ?>

                                            </a>
                                        </td>
                                        <td><?php echo e($row->user->first_name ?? ''); ?> <?php echo e($row->user->last_name ?? ''); ?></td>
                                        <td><?php echo e($row->leaveType->title ?? ''); ?></td>
                                        <td>
                                            <?php if($row->pay_type == 1): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('field_paid_leave')); ?></span>
                                            <?php elseif($row->pay_type == 2): ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('field_unpaid_leave')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                                <?php echo e(date($setting->date_format, strtotime($row->from_date))); ?>

                                            <?php else: ?>
                                                <?php echo e(date("Y-m-d", strtotime($row->from_date))); ?>

                                            <?php endif; ?>
                                            -
                                            <?php if(isset($setting->date_format)): ?>
                                                <?php echo e(date($setting->date_format, strtotime($row->to_date))); ?>

                                            <?php else: ?>
                                                <?php echo e(date("Y-m-d", strtotime($row->to_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e((int)((strtotime($row->to_date) - strtotime($row->from_date))/86400) + 1); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                                <?php echo e(date($setting->date_format, strtotime($row->apply_date))); ?>

                                            <?php else: ?>
                                                <?php echo e(date("Y-m-d", strtotime($row->apply_date))); ?>

                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo e(__('field_grand_total')); ?></th>
                                        <th><?php echo e($total_days); ?></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
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

<?php $__env->startSection('page_js'); ?>
    <?php echo $__env->make('admin.report.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\report\leave.blade.php ENDPATH**/ ?>