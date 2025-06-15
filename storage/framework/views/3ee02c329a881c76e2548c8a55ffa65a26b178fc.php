<?php $__env->startSection('title', 'M-Pesa Payment'); ?>
<?php $__env->startSection('content'); ?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->

        <div class="row">
            <div class="col-sm-6">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e(__('M-Pesa Payment')); ?></h5>
                    </div>
                    <div class="card-block">
                        <a href="<?php echo e(route('student.fees.index')); ?>" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> <?php echo e(__('btn_back')); ?>

                        </a>
                    </div>






                    <?php
                    $fee = \App\Models\Fee::find($feeId);  // Use the feeId passed from the controller
                    $feeAmount = $fee->fee_amount ?? 0;
                    $paidAmount = $fee->paid_amount ?? 0;
                    $balance = max(0, $feeAmount - $paidAmount); // Ensure balance doesn't go negative
                ?>
                
                <!-- Now you can use $balance and other fee details in the form -->
                
                <form method="post" action="<?php echo e(route('feepaymentmpesa', ['id' => $formData['fee_category_id']])); ?>" >
                    <?php echo csrf_field(); ?>
                    
                    <div class="card-block">
                        <!-- Display Fee Category Name -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="fee_category" class="form-label"><?php echo e(__('Fee Category')); ?></label>
                    <input type="text" class="form-control" name="fee_category" id="fee_category" value="<?php echo e($formData['fee_category_title'] ?? ''); ?> Fee" readonly>
                            </div>

                        
                        </div>
                        


                        <input type="hidden" name="assign_date" value="<?php echo e(date('Y-m-d')); ?>" readonly>
                        <input type="hidden" name="due_date" value="<?php echo e($formData['due_date']); ?>" readonly>
                        <input type="hidden" name="student_id" value="<?php echo e(auth('student')->user()->id); ?>">
                        <input type="hidden" name="fee_id" value="<?php echo e($feeId ?? $formData['fee_category_id']); ?>">
                        <input type="hidden" name="pay_date" value="<?php echo e($formData['pay_date'] ?? now()->format('Y-m-d')); ?>">
                
                        <!-- Display Fee Amount and Balance -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="fee_amount" class="form-label">
                                    <?php echo e(__('Fee Amount')); ?> (<?php echo $setting->currency_symbol; ?>)
                                </label>
                                <input type="text" class="form-control" name="fee_amount" id="fee_amount" value="<?php echo e($feeAmount); ?>" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="phone_number" class="form-label">
                                    <?php echo e(__('Phone Number')); ?>

                                </label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number" value="<?php echo e($formData['phone_number']); ?>" required>
                                <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="alert alert-danger"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="balance" class="form-label">
                                    <?php echo e(__('Balance Due')); ?> (<?php echo $setting->currency_symbol; ?>)
                                </label>
                                <input type="text" class="form-control" name="balance" id="balance" value="<?php echo e($balance); ?>" readonly>
                            </div>
                        </div>
                 <!-- Amount to Pay -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="payment_amount" class="form-label">
                    <?php echo e(__('Amount to Pay Now')); ?> (<?php echo $setting->currency_symbol; ?>) <span>*</span>
                </label>
                <input type="number" class="form-control" name="payment_amount" id="payment_amount" 
                       value="" required>
            </div>
        </div>

        <!-- Notification -->
        <div class="alert alert-info" role="alert">
            <strong>Important:</strong> After you click on "Pay with M-Pesa," you will be prompted to enter your M-Pesa password on your phone to complete the payment.
        </div>
    </div>

                        <!-- Additional Fields for Phone, Payment Amount, etc. -->
                    </div>
                
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-money-check"></i> Pay with M-Pesa
                        </button>
                    </div>
                </form>
                
                    






                </div>
            
       
           

                        <?php
        $bankDetails = \App\Models\BankMpesaDetails::first();
        $paybill= \App\Models\PaybillDetail::first();
    ?>
   <div class="col-sm-6">
<div class="container my-5">
    <div class="row justify-content-center">
     
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Bank Details</h4>
                </div>
                <div class="card-body">
                    <?php if($bankDetails): ?>
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                              
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><i class="bi bi-bank2 text-primary fs-4"></i> Bank Name</td>
                                    <td class="text-center"><?php echo e($bankDetails->bank_name); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><i class="bi bi-card-text text-primary fs-4"></i> Account Number</td>
                                    <td class="text-center"><?php echo e($bankDetails->bank_account); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><i class="bi bi-geo-alt text-primary fs-4"></i> Branch</td>
                                    <td class="text-center"><?php echo e($bankDetails->bank_branch); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center">
                            <p>No bank details available.</p>
                        </div>
                    <?php endif; ?>
                </div>
        <div class="card shadow-sm">
            <div class="card-header text-center bg-secondary text-white">
                    <h4>PayBill Details</h4>
                </div>
                <div class="card-body">
                    <?php if($paybill): ?>
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                              
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><i class="bi bi-wallet2 text-primary fs-4"></i> PayBill Number</td>
                                    <td class="text-center"><?php echo e($paybill->paybill_number); ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center"><i class="bi bi-card-text text-primary fs-4"></i> Account Number</td>
                                    <td class="text-center"><?php echo e($paybill->paybill_account); ?></td>
                                </tr>
                                
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="text-center">
                            <p>No bank details available.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>


        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const form = document.querySelector('form');
        form.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevent immediate form submission

            // Show loader
            const loader = document.createElement('div');
            loader.innerHTML = `
                <div class="d-flex justify-content-center align-items-center" style="height: 200px;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Processing...</span>
                    </div>
                    <p class="ms-3">Processing payment. Please wait...</p>
                </div>`;
            document.body.appendChild(loader);

            // Delay submission
            setTimeout(() => {
                form.submit();
            }, 8000); // 8-second delay
        });
    });
</script>




<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('student.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\Dapin-CMS-main\resources\views/student/fees/mpesa_payment.blade.php ENDPATH**/ ?>