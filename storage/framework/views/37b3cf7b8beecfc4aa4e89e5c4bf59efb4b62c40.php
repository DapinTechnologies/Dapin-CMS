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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.fees')); ?>">
                            <div class="row gx-2">

                                <?php echo $__env->make('common.inc.fees_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="category"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if( $selected_category == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="start_date"><?php echo e(__('field_from_date')); ?></label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="<?php echo e($selected_start_date); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_from_date')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
                                    <label for="end_date"><?php echo e(__('field_to_date')); ?></label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="<?php echo e($selected_end_date); ?>" required>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_to_date')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-2">
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
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="report-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo e(__('field_receipt')); ?></th>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_fees_type')); ?></th>
                                        <th><?php echo e(__('field_fee')); ?></th>
                                        <th><?php echo e(__('field_discount')); ?></th>
                                        <th><?php echo e(__('field_fine_amount')); ?></th>
                                        <th><?php echo e(__('field_net_amount')); ?></th>
                                        <th><?php echo e(__('field_pay_date')); ?></th>
                                        <th><?php echo e(__('field_payment_method')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e(str_pad($row->id, 6, '0', STR_PAD_LEFT)); ?></td>
                                        <td>
                                            <?php if(isset($row->studentEnroll->student->student_id)): ?>
                                            <a href="<?php echo e(route('admin.student.show', $row->studentEnroll->student->id)); ?>">
                                            #<?php echo e($row->studentEnroll->student->student_id ?? ''); ?>

                                            </a>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($row->category->title ?? ''); ?></td>
                                        <td>
                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$row->fee_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$row->fee_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

                                        </td>
                                        <td>
                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$row->discount_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$row->discount_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

                                        </td>
                                        <td>
                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$row->fine_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$row->fine_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

                                        </td>
                                        <td>
                                            <?php if(isset($setting->decimal_place)): ?>
                                            <?php echo e(number_format((float)$row->paid_amount, $setting->decimal_place, '.', '')); ?> 
                                            <?php else: ?>
                                            <?php echo e(number_format((float)$row->paid_amount, 2, '.', '')); ?> 
                                            <?php endif; ?> 
                                            <?php echo $setting->currency_symbol; ?>

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
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo e(__('field_grand_total')); ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('fee_amount'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('discount_amount'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('fine_amount'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('paid_amount'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>

                                <caption><?php echo e(date($setting->date_format ?? "Y-m-d", strtotime($selected_start_date))); ?> - <?php echo e(date($setting->date_format ?? "Y-m-d", strtotime($selected_end_date))); ?></caption>
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
    <?php echo $__env->make('admin.report.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/report/fees.blade.php ENDPATH**/ ?>