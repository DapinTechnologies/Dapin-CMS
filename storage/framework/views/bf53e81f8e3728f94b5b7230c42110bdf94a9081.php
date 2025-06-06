<!-- Edit modal content -->
<div id="editModal-<?php echo e($row->id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <form class="needs-validation" novalidate action="<?php echo e(route($route.'.update', $payroll_data->id)); ?>" method="post" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <input type="text" name="month" value="<?php echo e($selected_month); ?>" hidden>
            <input type="text" name="year" value="<?php echo e($selected_year); ?>" hidden>

            <?php
            $paid_leave = \App\Models\Leave::paid_leave($row->id, $selected_month, $selected_year);
            $unpaid_leave = \App\Models\Leave::unpaid_leave($row->id, $selected_month, $selected_year);

            $present = $attendances->where('attendance', 1)->where('user_id', $row->id)->count();
            $absent = $attendances->where('attendance', 2)->where('user_id', $row->id)->count();
            $leave = $attendances->where('attendance', 3)->where('user_id', $row->id)->count();
            $holiday = $attendances->where('attendance', 4)->where('user_id', $row->id)->count();


            $working_days = $present + $holiday + $paid_leave;

            $deduction_days = $absent + $unpaid_leave;

            if($row->basic_salary != null || $row->basic_salary != ''){
                $basic_salary = $row->basic_salary;
            }else{
                $basic_salary = 0;
            }
            if($row->salary_type == 1){
                $per_day_salary = $basic_salary / $total_days;
                
                $total_earning = $per_day_salary * $working_days;

                $deduction_salary = $per_day_salary * $deduction_days;
            }

            if($row->salary_type == 2){
                $total_earning = $basic_salary * $working_days;

                $deduction_salary = $basic_salary * $deduction_days;
            }

            $bonus = round($payroll_data->bonus ?? 0);
            $gross_salary = round($total_earning + $bonus);

            if(round($total_earning) == round($payroll_data->total_earning)){  
                $tax_amount = round($payroll_data->tax ?? 0);
            }
            else{
                $tax_amount = 0;

                if(isset($taxs)){
                foreach($taxs as $tax){
                    if($tax->min_amount <= $gross_salary && $tax->max_amount >= $gross_salary){
                        $taxable_amount = $gross_salary - $tax->max_no_taxable_amount;

                        $tax_amount = ($taxable_amount / 100) * $tax->percentange;
                    }
                }}
            }

            $total_deduction = round($deduction_salary + $tax_amount);
            $net_salary = round($gross_salary - $tax_amount);
            ?>

            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel"><?php echo e(__('modal_edit')); ?> <?php echo e($title); ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <!-- View Start -->
                <div class="">
                    <div class="row">
                        <div class="col-md-6">
                            <p><mark class="text-primary"><?php echo e(__('field_staff_id')); ?>:</mark> #<?php echo e($row->staff_id); ?></p><hr/>

                            <p><mark class="text-primary"><?php echo e(__('field_contract_type')); ?>:</mark> 
                                <?php if( $row->contract_type == 1 ): ?>
                                <?php echo e(__('contract_type_full_time')); ?>

                                <?php elseif( $row->contract_type == 2 ): ?>
                                <?php echo e(__('contract_type_part_time')); ?>

                                <?php endif; ?>
                            </p><hr/>
                        </div>
                        <div class="col-md-6">
                            <p><mark class="text-primary"><?php echo e(__('field_name')); ?>:</mark> <?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></p><hr/>

                            <p><mark class="text-primary"><?php echo e(__('field_basic_salary')); ?>: </mark><?php echo e(round($row->basic_salary, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?> / 
                                <?php if( $row->salary_type == 1 ): ?>
                                <?php echo e(__('salary_type_fixed')); ?>

                                <?php elseif( $row->salary_type == 2 ): ?>
                                <?php echo e(__('salary_type_hourly')); ?>

                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-12">
                            <p><?php echo e(__('field_attendance')); ?>: <?php echo e(date("F - Y", strtotime($selected_year.'-'.$selected_month.'-01'))); ?></p>
                            <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('attendance_present')); ?></th>
                                        <th><?php echo e(__('attendance_absent')); ?></th>
                                        <th><?php echo e(__('attendance_leave')); ?></th>
                                        <th><?php echo e(__('field_paid_leave')); ?></th>
                                        <th><?php echo e(__('field_unpaid_leave')); ?></th>
                                        <th><?php echo e(__('attendance_holiday')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo e($present); ?></td>
                                        <td><?php echo e($absent); ?></td>
                                        <td><?php echo e($leave); ?></td>
                                        <td><?php echo e($paid_leave); ?></td>
                                        <td><?php echo e($unpaid_leave); ?></td>
                                        <td><?php echo e($holiday); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
                <br/>
                <!-- View End -->

                <!-- Form Start -->
                <input type="hidden" name="user_id" value="<?php echo e($row->id); ?>">
                <input type="hidden" name="basic_salary" value="<?php echo e($basic_salary); ?>">
                <input type="hidden" name="salary_type" value="<?php echo e($row->salary_type); ?>">
                <input type="hidden" name="salary_month" value="<?php echo e(date("Y-m-d", strtotime($selected_year.'-'.$selected_month.'-01'))); ?>">
                <div class="clearfix"></div>

                <div class="row">
                    <div class="form-group col-md-4">
                        <label for="total_earning"><?php echo e(__('field_total_earning')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="total_earning" id="total_earning" value="<?php echo e(round($total_earning, 0)); ?>" readonly required data_id="edit-<?php echo e($row->id); ?>" onkeyup="salaryCalculator('edit', <?php echo e($row->id); ?>)">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_total_earning')); ?>

                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="bonus"><?php echo e(__('field_bonus')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="bonus" id="bonus" value="<?php echo e(round($bonus, 0)); ?>" required data_id="edit-<?php echo e($row->id); ?>" onkeyup="salaryCalculator('edit', <?php echo e($row->id); ?>)">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_bonus')); ?>

                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="gross_salary"><?php echo e(__('field_gross_salary')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="gross_salary" id="gross_salary" value="<?php echo e(round($gross_salary, 0)); ?>" readonly required data_id="edit-<?php echo e($row->id); ?>" onkeyup="salaryCalculator('edit', <?php echo e($row->id); ?>)">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_gross_salary')); ?>

                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="tax"><?php echo e(__('field_tax')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="tax" id="tax" value="<?php echo e(round($tax_amount, 0)); ?>" readonly required data_id="edit-<?php echo e($row->id); ?>" onkeyup="salaryCalculator('edit', <?php echo e($row->id); ?>)">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_tax')); ?>

                        </div>
                    </div>

                    <input type="text" name="deduction_salary" value="<?php echo e(round($deduction_salary, 0)); ?>" hidden data_id="edit-<?php echo e($row->id); ?>" onkeyup="salaryCalculator('edit', <?php echo e($row->id); ?>)">

                    <div class="form-group col-md-4">
                        <label for="total_deduction"><?php echo e(__('field_total_deduction')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="total_deduction" id="total_deduction" value="<?php echo e(round($total_deduction, 0)); ?>" readonly required data_id="edit-<?php echo e($row->id); ?>" onkeyup="salaryCalculator('edit', <?php echo e($row->id); ?>)">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_total_deduction')); ?>

                        </div>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="net_salary"><?php echo e(__('field_net_salary')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                        <input type="text" class="form-control" name="net_salary" id="net_salary" value="<?php echo e(round($net_salary, 0)); ?>" readonly required data_id="edit-<?php echo e($row->id); ?>" onkeyup="salaryCalculator('edit', <?php echo e($row->id); ?>)">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_net_salary')); ?>

                        </div>
                    </div>

                    <div class="form-group col-md-12">
                        <label for="note"><?php echo e(__('field_note')); ?></label>
                        <input type="text" class="form-control" name="note" id="note" value="<?php echo e($payroll_data->note); ?>">

                        <div class="invalid-feedback">
                          <?php echo e(__('required_field')); ?> <?php echo e(__('field_note')); ?>

                        </div>
                    </div>
                </div>
                <!-- Form End -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="fas fa-times"></i> <?php echo e(__('btn_close')); ?></button>
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_update')); ?></button>
            </div>
          </form>
        </div>
    </div>
</div><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\payroll\edit.blade.php ENDPATH**/ ?>