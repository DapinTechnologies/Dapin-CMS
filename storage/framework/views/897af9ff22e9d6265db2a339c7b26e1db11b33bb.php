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

                                <?php echo $__env->make('common.inc.fees_search_filter', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                <div class="form-group col-md-3">
                                    <label for="category"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="0"><?php echo e(__('all')); ?></option>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($category->id); ?>" <?php if( $selected_category == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                                    </div>
                                </div>

                                <div class="form-group col-md-3">
                                    <label for="student_id"><?php echo e(__('field_student_id')); ?></label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" value="<?php echo e($selected_student_id); ?>">

                                    <div class="invalid-feedback">
                                      <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

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
                    <div class="card-header">
                        <?php if(isset($rows)): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-print')): ?>
                        <form class="needs-validation d-inline" novalidate method="get" action="<?php echo e(route($route.'.multiprint')); ?>" target="_blank">
                            <input type="hidden" name="fees" class="fees" value="">
                            <button type="submit" class="btn btn-sm btn-dark print-btn"><i class="fas fa-print"></i> <?php echo e(__('btn_print')); ?> <?php echo e(__('field_selected')); ?></button>
                        </form>
                        <?php endif; ?>
                        <?php endif; ?>
                    </div>

                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="export-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="checkbox checkbox-success d-inline">
                                                <input type="checkbox" id="checkbox" class="all_select">
                                                <label for="checkbox" class="cr" style="margin-bottom: 0px;"></label>
                                            </div>
                                        </th>
                                        <th>#</th>
                                        <th><?php echo e(__('field_receipt')); ?></th>
                                        <th><?php echo e(__('field_student_id')); ?></th>
                                        <th><?php echo e(__('field_fees_type')); ?></th>
                                        <th><?php echo e(__('field_fee')); ?></th>
                                        <th><?php echo e(__('field_discount')); ?></th>
                                        <th><?php echo e(__('field_fine_amount')); ?></th>
                                        <th><?php echo e(__('field_net_amount')); ?></th>
                                        <th><?php echo e(__('field_pay_date')); ?></th>
                                        <th><?php echo e(__('field_status')); ?></th>
                                        <th><?php echo e(__('field_payment_method')); ?></th>
                                        <th><?php echo e(__('field_note')); ?></th>
                                        <th><?php echo e(__('field_action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                  <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="checkbox checkbox-primary d-inline">
                                                <input type="checkbox" data_id="<?php echo e($row->id); ?>" id="checkbox-<?php echo e($row->id); ?>" value="<?php echo e($row->id); ?>">
                                                <label for="checkbox-<?php echo e($row->id); ?>" class="cr"></label>
                                            </div>
                                        </td>
                                        <td><?php echo e($key + 1); ?></td>
                                        <td><?php echo e($print->prefix ?? ''); ?><?php echo e(str_pad($row->id, 6, '0', STR_PAD_LEFT)); ?></td>
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
                                            <?php if($row->status == 1): ?>
                                            <span class="badge badge-pill badge-success"><?php echo e(__('status_paid')); ?></span>
                                            <?php elseif($row->status == 2): ?>
                                            <span class="badge badge-pill badge-danger"><?php echo e(__('status_canceled')); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-pill badge-primary"><?php echo e(__('status_pending')); ?></span>
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

                                            <?php elseif( $row->payment_method == 6 ): ?>
                                            <?php echo e(__('PayPal')); ?>

                                            <?php elseif( $row->payment_method == 7 ): ?>
                                            <?php echo e(__('Stripe')); ?>

                                            <?php elseif( $row->payment_method == 8 ): ?>
                                            <?php echo e(__('RazorPay')); ?>

                                            <?php elseif( $row->payment_method == 9 ): ?>
                                            <?php echo e(__('PayStack')); ?>

                                            <?php elseif( $row->payment_method == 10 ): ?>
                                            <?php echo e(__('Flutterwave')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row->note; ?></td>
                                        <td>
                                            <?php if($row->status == 0): ?>
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payModal-<?php echo e($row->id); ?>">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <!-- Include Pay modal -->
                                            <?php echo $__env->make($view.'.pay', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                            <?php elseif($row->status == 1): ?>
                                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check($access.'-print')): ?>
                                            <?php if(isset($print)): ?>
                                            <a href="#" class="btn btn-icon btn-dark btn-sm" onclick="PopupWin('<?php echo e(route($route.'.print', ['id' => $row->id])); ?>', '<?php echo e($title); ?>', 1000, 600);">
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
                                        </td>
                                    </tr>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
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
    $(document).ready(function() {
        $(".print-btn").on('click',function(e){

            var numberOfChecked = $("input[data_id]:checked").length;
            if(numberOfChecked <= 0){
                e.preventDefault();
                alert("<?php echo e(__('select')); ?> <?php echo e(__('field_receipt')); ?>");
            }

            var fees = [];
            $.each($("input[data_id]:checked"), function(){
                fees.push($(this).val());
            });

            $(".fees").val( fees.join(',') );
        });
    });

    // checkbox all-check-button selector
    $(".all_select").on('click',function(e){
        if($(this).is(":checked")){
            // check all checkbox
            $("input:checkbox").prop('checked', true);
        }
        else if($(this).is(":not(:checked)")){
            // uncheck all checkbox
            $("input:checkbox").prop('checked', false);
        }
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fees-student/report.blade.php ENDPATH**/ ?>