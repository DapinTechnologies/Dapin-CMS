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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.index')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-2">
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
                                <div class="form-group col-md-2">
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
                                <div class="form-group col-md-2">
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
                                <div class="form-group col-md-2">
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
                                <div class="form-group col-md-2">
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
                    <?php if(isset($rows)): ?>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th><?php echo e(__('field_staff_id')); ?></th>
                                        <th><?php echo e(__('field_name')); ?></th>
                                        <th><?php echo e(__('field_department')); ?></th>
                                        <th><?php echo e(__('field_designation')); ?></th>
                                        <th><?php echo e(__('field_salary_type')); ?></th>
                                        <th><?php echo e(__('field_work_shift')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($row->status == 1): ?>
                                    <tr>
                                        <td>
                                            <a href="<?php echo e(route('admin.user.show', $row->id)); ?>">
                                                #<?php echo e($row->staff_id); ?>

                                            </a>
                                        </td>
                                        <td><?php echo e($row->first_name); ?> <?php echo e($row->last_name); ?></td>
                                        <td><?php echo e($row->department->title ?? ''); ?></td>
                                        <td><?php echo e($row->designation->title ?? ''); ?></td>
                                        <td>
                                            <?php if( $row->salary_type == 1 ): ?>
                                            <?php echo e(__('salary_type_fixed')); ?>

                                            <?php elseif( $row->salary_type == 2 ): ?>
                                            <?php echo e(__('salary_type_hourly')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->workShift->title ?? ''); ?></td>
                                        <?php
                                            $payroll_generate = 0;
                                            $payroll_status = 0;
                                        ?>
                                        <?php if(isset($payrolls)): ?>
                                        <?php $__currentLoopData = $payrolls; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payroll): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($payroll->user_id == $row->id): ?>
                                            <?php
                                            $payroll_data = $payroll;
                                            $payroll_generate = 1;
                                            if($payroll->status == 1){
                                                $payroll_status = 1;
                                            }
                                            ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                        <td>
                                            <?php if( $payroll_generate == 1 ): ?>
                                            <?php if($payroll_status == 1): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_paid')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_generated')); ?></span>
                                            <?php endif; ?>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_not_generated')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                        <?php if( $payroll_generate == 0 ): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-action')): ?>
                                            <a href="<?php echo e(route($route.'.generate', ['id' => $row->id, 'month' => $selected_month, 'year' => $selected_year])); ?>" class="btn btn-icon btn-primary btn-sm">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                            <?php endif; ?>
                                        <?php else: ?>

                                            <?php if(isset($payroll_data)): ?>
                                            <?php if($payroll_status == 0): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-action')): ?>
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#payModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-money-check"></i> <?php echo e(__('btn_pay')); ?>

                                            </button>
                                            <!-- Include Edit modal -->
                                            <?php echo $__env->make($view.'.pay', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-action')): ?>
                                            <a href="<?php echo e(route($route.'.generate', ['id' => $row->id, 'month' => $selected_month, 'year' => $selected_year])); ?>" class="btn btn-icon btn-primary btn-sm">
                                                <i class="far fa-edit"></i>
                                            </a>
                                            <?php endif; ?>

                                            <?php else: ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-print')): ?>
                                            <?php if(isset($print) && isset($payroll_data)): ?>
                                            <a href="#" class="btn btn-icon btn-dark btn-sm" onclick="PopupWin('<?php echo e(route($route.'.print', ['id' => $payroll_data->id])); ?>', '<?php echo e($title); ?>', 1000, 600);">
                                                <i class="fas fa-print"></i>
                                            </a>
                                            <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-action')): ?>
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" title="<?php echo e(__('status_unpaid')); ?>" data-bs-toggle="modal" data-bs-target="#unpayModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-undo"></i>
                                            </button>
                                            <!-- Include Unpay modal -->
                                            <?php echo $__env->make($view.'.unpay', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            <?php endif; ?>
                                            
                                        <?php endif; ?>
                                        </td>
                                    </tr>
                                  <?php endif; ?>
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

<?php $__env->startSection('page_js'); ?>
    <script type="text/javascript">
        "use strict";
        function salaryCalculator(type, id) {
          // Get Data
          var total_earning = $("input[name='total_earning'][data_id='"+type+"-"+id+"']").val();
          var bonus = $("input[name='bonus'][data_id='"+type+"-"+id+"']").val();
          var gross_salary = $("input[name='gross_salary'][data_id='"+type+"-"+id+"']").val();
          var deduction_salary = $("input[name='deduction_salary'][data_id='"+type+"-"+id+"']").val();
          var total_deduction = $("input[name='total_deduction'][data_id='"+type+"-"+id+"']").val();
          var tax_amount = $("input[name='tax'][data_id='"+type+"-"+id+"']").val();
          var net_salary = $("input[name='net_salary'][data_id='"+type+"-"+id+"']").val();

          // Pass Bonus
          if (isNaN(bonus)) bonus = 0;
          $("input[name='bonus'][data_id='"+type+"-"+id+"']").val(Math.ceil(bonus));

          // Total Gross
          var total_gross = parseFloat(total_earning) + parseFloat(bonus);

            // Calculate Tax
            <?php
            if(isset($taxs)){
            foreach($taxs as $key =>$value){
                $taxs[$key] = json_decode(json_encode($value));
            }
            ?>

            var taxs = <?php echo json_encode($taxs); ?>;

            var i;
            for (i = 0; i < taxs.length; ++i) {
                if(taxs[i]['min_amount'] <= total_gross && taxs[i]['max_amount'] >= total_gross){

                    var taxable_amount = total_gross - taxs[i]['max_no_taxable_amount'];

                    var tax_amount = (taxable_amount / 100) * taxs[i]['percentange'];
                }
            }
            <?php } ?>
            

          // Net Total
          var total_deduction = parseFloat(deduction_salary) + parseFloat(tax_amount);
          var net_total = parseFloat(total_gross) - parseFloat(tax_amount);

          // Pass Data
          $("input[name='gross_salary'][data_id='"+type+"-"+id+"']").val(Math.ceil(total_gross));
          $("input[name='tax'][data_id='"+type+"-"+id+"']").val(Math.ceil(tax_amount));
          $("input[name='total_deduction'][data_id='"+type+"-"+id+"']").val(Math.ceil(total_deduction));
          $("input[name='net_salary'][data_id='"+type+"-"+id+"']").val(Math.ceil(net_total));
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home7/httpurba/public_html/college/resources/views/admin/payroll/index.blade.php ENDPATH**/ ?>