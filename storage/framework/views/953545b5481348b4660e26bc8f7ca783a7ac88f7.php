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
                        <form class="needs-validation" novalidate method="get" action="<?php echo e(route($route.'.expense')); ?>">
                            <div class="row gx-2">
                                <div class="form-group col-md-3">
                                    <label for="category"><?php echo e(__('field_category')); ?></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value=""><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if($selected_category == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_category')); ?>

                                    </div>
                                </div>
                                <div class="form-group col-md-3">
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
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> <?php echo e(__('btn_filter')); ?></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <?php if(isset($rows)): ?>
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
                                        <th><?php echo e(__('field_title')); ?></th>
                                        <th><?php echo e(__('field_category')); ?></th>
                                        <th><?php echo e(__('field_invoice_id')); ?></th>
                                        <th><?php echo e(__('field_date')); ?></th>
                                        <th><?php echo e(__('field_amount')); ?></th>
                                        <th><?php echo e(__('field_payment_method')); ?></th>
                                        <th><?php echo e(__('field_recorded_by')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo str_limit($row->title, 30, ' ...'); ?></td>
                                        <td><?php echo e($row->category->title ?? ''); ?></td>
                                        <td><?php echo e($row->invoice_id); ?></td>
                                        <td>
                                            <?php if(isset($setting->date_format)): ?>
                                            <?php echo e(date($setting->date_format, strtotime($row->date))); ?>

                                            <?php else: ?>
                                            <?php echo e(date("Y-m-d", strtotime($row->date))); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(number_format((float)$row->amount, $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></td>
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
                                        <td>#<?php echo e($row->recordedBy->staff_id ?? ''); ?></td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><?php echo e(__('field_grand_total')); ?></th>
                                        <th><?php echo e(number_format((float)$rows->sum('amount'), $setting->decimal_place ?? 2)); ?> <?php echo $setting->currency_symbol; ?></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
            <?php endif; ?>
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
    <?php echo $__env->make('admin.report.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\admin\report\expense.blade.php ENDPATH**/ ?>