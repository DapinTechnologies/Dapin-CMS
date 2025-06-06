<div>
   

    <form wire:submit.prevent="processpayment" >
   
        
        <div class="card-block">
            <!-- Display Fee Category Name -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fee_category" class="form-label"><?php echo e(__('Fee Category')); ?></label>
                    <input type="text" class="form-control" name="fee_category" id="fee_category"  readonly>
                </div>

            
            </div>
            


           
            <!-- Display Fee Amount and Balance -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fee_amount" class="form-label">
                        <?php echo e(__('Fee Amount')); ?> (<?php echo $setting->currency_symbol; ?>)
                    </label>
                    <input type="text" class="form-control" wire:model="fee_amount" id="fee_amount"  readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="phone_number" class="form-label">
                        <?php echo e(__('Phone Number')); ?>

                    </label>
                    <input type="text" class="form-control" wire:model="phone_number" id="phone_number"  required>
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
                    <input type="text" class="form-control" name="balance" id="balance" readonly>
                </div>
            </div>
     <!-- Amount to Pay -->
<div class="row">
   
    
        
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
<?php /**PATH C:\Users\User\Desktop\college\resources\views\livewire\mpesa-payment.blade.php ENDPATH**/ ?>