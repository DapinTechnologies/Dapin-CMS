<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <form class="needs-validation" novalidate action="<?php echo e(route($route.'.quick.received.store')); ?>" method="post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="student"><?php echo e(__('field_student_id')); ?> <span>*</span></label>
                            <select class="form-control select2" name="student" id="student" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($student->id); ?>" <?php if(old('student') == $student->id): ?> selected <?php endif; ?>><?php echo e($student->student->student_id ?? ''); ?> - <?php echo e($student->student->first_name ?? ''); ?> <?php echo e($student->student->last_name ?? ''); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_student_id')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="category"><?php echo e(__('field_fees_type')); ?> <span>*</span></label>
                            <select class="form-control" name="category" id="category" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>" <?php if(old('category') == $category->id): ?> selected <?php endif; ?>><?php echo e($category->title); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fees_type')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="pay_date" class="form-label"><?php echo e(__('field_pay_date')); ?> <span>*</span></label>
                            <input type="date" class="form-control date" name="pay_date" id="pay_date" value="<?php echo e(date('Y-m-d')); ?>" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_pay_date')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="fee_amount" class="form-label"><?php echo e(__('field_fee')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="fee_amount" id="fee_amount" value="<?php echo e(old('fee_amount') ?? 0); ?>" onkeyup="feesCalculator()" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fee')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="discount_amount" class="form-label"><?php echo e(__('field_discount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="discount_amount" id="discount_amount" value="<?php echo e(old('discount_amount') ?? 0); ?>" onkeyup="feesCalculator()" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_discount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="fine_amount" class="form-label"><?php echo e(__('field_fine_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="fine_amount" id="fine_amount" value="<?php echo e(old('fine_amount') ?? 0); ?>" onkeyup="feesCalculator()" required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_fine_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="paid_amount" class="form-label"><?php echo e(__('field_net_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="paid_amount" id="paid_amount" value="<?php echo e(old('paid_amount') ?? 0); ?>" onkeyup="feesCalculator()" readonly required>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_net_amount')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="payment_method" class="form-label"><?php echo e(__('field_payment_method')); ?> <span>*</span></label>
                            <select class="form-control" name="payment_method" id="payment_method" required>
                                <option value=""><?php echo e(__('select')); ?></option>
                                <option value="1" <?php if( old('payment_method') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_card')); ?></option>
                                <option value="2" <?php if( old('payment_method') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_cash')); ?></option>
                                <option value="3" <?php if( old('payment_method') == 3 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_cheque')); ?></option>
                                <option value="4" <?php if( old('payment_method') == 4 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_bank')); ?></option>
                                <option value="5" <?php if( old('payment_method') == 5 ): ?> selected <?php endif; ?>><?php echo e(__('payment_method_e_wallet')); ?></option>
                            </select>

                            <div class="invalid-feedback">
                              <?php echo e(__('required_field')); ?> <?php echo e(__('field_payment_method')); ?>

                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="note" class="form-label"><?php echo e(__('field_note')); ?></label>
                            <textarea class="form-control" name="note" id="note"><?php echo old('note'); ?></textarea>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> <?php echo e(__('btn_save')); ?></button>
                    </div>
                    </form>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
    <script type="text/javascript">
        "use strict";
        function feesCalculator() {
          var fee_amount = $("input[name='fee_amount']").val();
          var fine_amount = $("input[name='fine_amount']").val();
          var discount_amount = $("input[name='discount_amount']").val();
          var paid_amount = $("input[name='paid_amount']").val();
          
          //
          if (isNaN(parseFloat(fee_amount))) fee_amount = 0;
          if (isNaN(parseFloat(fine_amount))) fine_amount = 0;
          if (isNaN(parseFloat(discount_amount))) discount_amount = 0;
          $("input[name='fee_amount']").val(fee_amount);
          $("input[name='fine_amount']").val(fine_amount);
          $("input[name='discount_amount']").val(discount_amount);

          // Set Value
          var net_total = (parseFloat(fee_amount) - parseFloat(discount_amount)) + parseFloat(fine_amount);
          $("input[name='paid_amount']").val(net_total);
        }
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/admin/fees-student/quick-received.blade.php ENDPATH**/ ?>