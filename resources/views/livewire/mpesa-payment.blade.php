<div>
   

    <form wire:submit.prevent="processpayment" >
   
        
        <div class="card-block">
            <!-- Display Fee Category Name -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fee_category" class="form-label">{{ __('Fee Category') }}</label>
                    <input type="text" class="form-control" name="fee_category" id="fee_category"  readonly>
                </div>

            
            </div>
            


           
            <!-- Display Fee Amount and Balance -->
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="fee_amount" class="form-label">
                        {{ __('Fee Amount') }} ({!! $setting->currency_symbol !!})
                    </label>
                    <input type="text" class="form-control" wire:model="fee_amount" id="fee_amount"  readonly>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="phone_number" class="form-label">
                        {{ __('Phone Number') }}
                    </label>
                    <input type="text" class="form-control" wire:model="phone_number" id="phone_number"  required>
                    @error('phone_number')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="balance" class="form-label">
                        {{ __('Balance Due') }} ({!! $setting->currency_symbol !!})
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
