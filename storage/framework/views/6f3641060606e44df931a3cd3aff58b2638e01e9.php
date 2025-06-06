<?php $__env->startSection('title', $title); ?>
<?php $__env->startSection('content'); ?>

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route($route.'.index')); ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?></a>
                    </div>
                    <form method="post" action="<?php echo e(route('payment.stripe.process')); ?>" id="stripe-form">
                    <?php echo csrf_field(); ?>
                    <div class="card-block">
                    <!-- Details View Start -->
                    <div class="">
                        <div class="row">
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_student_id')); ?>:</mark> #<?php echo e($row->studentEnroll->student->student_id ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_program')); ?>:</mark> <?php echo e($row->studentEnroll->program->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_fees_type')); ?>:</mark> <?php echo e($row->category->title ?? ''); ?></p><hr/>
                            </div>
                            <div class="col-md-6">
                                <p><mark class="text-primary"><?php echo e(__('field_session')); ?>:</mark> <?php echo e($row->studentEnroll->session->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_semester')); ?>:</mark> <?php echo e($row->studentEnroll->semester->title ?? ''); ?></p><hr/>
                                <p><mark class="text-primary"><?php echo e(__('field_section')); ?>:</mark> <?php echo e($row->studentEnroll->section->title ?? ''); ?></p><hr/>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-6">
                                <label for="due_date" class="form-label"><?php echo e(__('field_due_date')); ?> <span>*</span></label>
                                <input type="date" class="form-control" name="due_date" id="due_date" value="<?php echo e($row->due_date); ?>" required readonly>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_due_date')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="pay_date" class="form-label"><?php echo e(__('field_pay_date')); ?> <span>*</span></label>
                                <input type="date" class="form-control" name="pay_date" id="pay_date" value="<?php echo e(date('Y-m-d')); ?>" required readonly>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_pay_date')); ?>

                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="fee_amount" class="form-label"><?php echo e(__('field_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="fee_amount" id="fee_amount" value="<?php echo e(round($row->fee_amount, 2)); ?>" required readonly>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_amount')); ?>

                                </div>
                            </div>

                            <?php 
                            $discount_amount = 0;
                            $today = date('Y-m-d');
                            ?>

                            <?php if(isset($row->category)): ?>
                            <?php $__currentLoopData = $row->category->discounts->where('status', '1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discount): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php
                            $availability = \App\Models\FeesDiscount::availability($discount->id, $row->studentEnroll->student_id);
                            ?>

                            <?php if(isset($availability)): ?>
                            <?php if($discount->start_date <= $today && $discount->end_date >= $today): ?>
                                <?php if($discount->type == '1'): ?>
                                    <?php
                                    $discount_amount = $discount_amount + $discount->amount;
                                    ?>
                                <?php else: ?>
                                    <?php
                                    $discount_amount = $discount_amount + ( ($row->fee_amount / 100) * $discount->amount);
                                    ?>
                                <?php endif; ?>
                            <?php endif; ?>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <div class="form-group col-md-6">
                                <label for="discount_amount" class="form-label"><?php echo e(__('field_discount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="discount_amount" id="discount_amount" value="<?php echo e(round($discount_amount, 2)); ?>" required readonly>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_discount')); ?>

                                </div>
                            </div>

                            <?php
                            $fine_amount = 0;
                            ?>
                            <?php if(empty($row->pay_date) || $row->due_date < $row->pay_date): ?>
                                
                                <?php
                                $due_date = strtotime($row->due_date);
                                $today = strtotime(date('Y-m-d')); 
                                $days = (int)(($today - $due_date)/86400);
                                ?>

                                <?php if($row->due_date < date("Y-m-d")): ?>
                                <?php if(isset($row->category)): ?>
                                <?php $__currentLoopData = $row->category->fines->where('status', '1'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($fine->start_day <= $days && $fine->end_day >= $days): ?>
                                    <?php if($fine->type == '1'): ?>
                                        <?php
                                        $fine_amount = $fine_amount + $fine->amount;
                                        ?>
                                    <?php else: ?>
                                        <?php
                                        $fine_amount = $fine_amount + ( ($row->fee_amount / 100) * $fine->amount);
                                        ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <?php endif; ?>
                            <?php endif; ?>

                            <div class="form-group col-md-6">
                                <label for="fine_amount" class="form-label"><?php echo e(__('field_fine_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="fine_amount" id="fine_amount" value="<?php echo e(round($fine_amount, 2)); ?>" required readonly>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_fine_amount')); ?>

                                </div>
                            </div>

                            <?php
                            $net_amount = ($row->fee_amount - $discount_amount) + $fine_amount;
                            ?>

                            <div class="form-group col-md-6">
                                <label for="net_amount" class="form-label"><?php echo e(__('field_net_amount')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span></label>
                                <input type="text" class="form-control autonumber" name="paid_amount" id="net_amount" value="<?php echo e(round($net_amount, 2)); ?>"  required readonly>

                                <div class="invalid-feedback">
                                  <?php echo e(__('required_field')); ?> <?php echo e(__('field_net_amount')); ?>

                                </div>
                            </div>
                        </div>

                        <?php if(config('payment.status') == 'stripe'): ?>
                        <div class="row">
                            <div class="col-md-12 mt-2 text-center">
                                <img src="<?php echo e(asset('dashboard/images/stripe.png')); ?>" class="img-fluid">
                            </div>
                            <div class="col-md-12 mt-2">
                                
                                <input type='hidden' name='stripeToken' id='stripe-token'>
                                <input type="hidden" name="fee_id" value="<?php echo e($row->id); ?>">

                                <div id="stripe-card-element" class="form-control"></div>
                                
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                    <!-- Details View End -->
                    </div>
                    <div class="card-footer">
                        <button type="button" id="stripe-pay-btn" class="btn btn-primary" onclick="createToken()"><i class="fas fa-money-check"></i> <?php echo e(__('btn_pay')); ?></button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_js'); ?>
<?php if(config('payment.status') == 'stripe'): ?>
<script src="https://js.stripe.com/v3/"></script>
<script type="text/javascript">

    var stripe = Stripe('<?php echo e(env('STRIPE_KEY')); ?>');
    var elements = stripe.elements();
    var cardElement = elements.create('card', {
        hidePostalCode: true,
        style: {
         base: {
          color: '#495057',
          lineHeight: '30px',
          fontWeight: 300,
          fontSize: '16px',

          '::placeholder': {
            color: '#888',
           },
          }, 
        }
    });
    cardElement.mount('#stripe-card-element');

    /*------------------------------------------
    --------------------------------------------
    Create Token Code
    --------------------------------------------
    --------------------------------------------*/
    function createToken() {

        document.getElementById("stripe-pay-btn").disabled = true;

        stripe.createToken(cardElement).then(function(result) {
            if(typeof result.error != 'undefined') {
                document.getElementById("stripe-pay-btn").disabled = false;
                alert(result.error.message);
            }

            /* creating token success */
            if(typeof result.token != 'undefined') {
                document.getElementById("stripe-token").value = result.token.id;
                document.getElementById('stripe-form').submit();
            }
        });
    }
</script>
<?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\User\Desktop\college\resources\views\student\fees\pay.blade.php ENDPATH**/ ?>