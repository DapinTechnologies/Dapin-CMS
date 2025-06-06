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
                                    <label for="salary_type"><?php echo e(__('field_salary_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="salary_type" id="salary_type" required>
                                        <option value=""><?php echo e(__('select')); ?></option>
                                        <option value="1" <?php if($selected_salary_type == 1): ?> selected <?php endif; ?>><?php echo e(__('salary_type_fixed')); ?></option>
                                        <option value="2" <?php if($selected_salary_type == 2): ?> selected <?php endif; ?>><?php echo e(__('salary_type_hourly')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_salary_type')); ?>

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
                                    <label for="contract_type"><?php echo e(__('field_contract_type')); ?> </label>
                                    <select class="form-control" name="contract_type" id="contract_type">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <option value="1" <?php echo e($selected_contract == 1 ? 'selected' : ''); ?>><?php echo e(__('contract_type_full_time')); ?></option>
                                        <option value="2" <?php echo e($selected_contract == 2 ? 'selected' : ''); ?>><?php echo e(__('contract_type_part_time')); ?></option>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_contract_type')); ?>

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
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
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
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover table-bordered printable">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_receipt')); ?></th>
                                        <th><?php echo e(__('field_staff_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_basic_salary')); ?></th>
                                        <th><?php echo e(__('field_total_earning')); ?></th>
                                        <th><?php echo e(__('field_total_allowance')); ?></th>
                                        <th><?php echo e(__('field_total_deduction')); ?></th>
                                        <th><?php echo e(__('field_gross_salary')); ?></th>
                                        <th><?php echo e(__('field_tax')); ?></th>
                                        <th><?php echo e(__('field_net_salary')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_pay_date')); ?></th>
                                        <th><?php echo e(__('field_payment_method')); ?></th>
                                        <th><?php echo e(__('field_note')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>

                                  <?php if(isset($rows)): ?>
                                    <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($print->prefix ?? ''); ?><?php echo e(str_pad($row->id, 6, '0', STR_PAD_LEFT)); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.user.show', $row->user->id)); ?>">
                                                #<?php echo e($row->user->staff_id ?? ''); ?>

                                            </a>
                                        </td>
                                        <td><?php echo e($row->user->first_name ?? ''); ?> <?php echo e($row->user->last_name ?? ''); ?></td>
                                        <td>
                                            <?php echo e(number_format((float)$row->basic_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?> / 

                                            <?php if( $row->salary_type == 1 ): ?>
                                            <?php echo e(__('salary_type_fixed')); ?>

                                            <?php elseif( $row->salary_type == 2 ): ?>
                                            <?php echo e(__('salary_type_hourly')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(number_format((float)$row->total_earning, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td><?php echo e(number_format((float)$row->total_allowance, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td><?php echo e(number_format((float)$row->total_deduction, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td><?php echo e(number_format((float)$row->gross_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td><?php echo e(number_format((float)$row->tax, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td><?php echo e(number_format((float)$row->net_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
                                        <td>
                                            <?php if($row->status == 1): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_paid')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_unpaid')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($row->status == 1): ?>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->pay_date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->pay_date))); ?>

                                            <?php endif; ?>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if( $row->payment_method == 1 ): ?>
                                            <?php echo e(__('payment_method_card')); ?>

                                            <?php elseif( $row->payment_method == 2 ): ?>
                                            <?php echo e(__('payment_method_cash')); ?>

                                            <?php elseif( $row->payment_method == 3 ): ?>
                                            <?php echo e(__('payment_method_cheque')); ?>

                                            <?php elseif( $row->payment_method == 4 ): ?>
                                            <?php echo e(__('payment_method_bank')); ?>

                                            <?php elseif( $row->payment_method == 5 ): ?>
                                            <?php echo e(__('payment_method_e_wallet')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->note); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  <?php endif; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo e(__('field_grand_total')); ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('total_earning'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('total_allowance'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('total_deduction'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('gross_salary'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('tax'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('net_salary'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

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
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\payroll\report.blade.php ENDPATH**/ ?>