@extends('student.layouts.master')
@section('title', 'M-Pesa Payment')
@section('content')

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
                        <h5>{{ __('M-Pesa Payment') }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route('student.fees.index') }}" class="btn btn-primary">
                            <i class="fas fa-arrow-left"></i> {{ __('btn_back') }}
                        </a>
                    </div>






                    <?php
                    $fee = \App\Models\Fee::find($feeId);  // Use the feeId passed from the controller
                    $feeAmount = $fee->fee_amount ?? 0;
                    $paidAmount = $fee->paid_amount ?? 0;
                    $balance = max(0, $feeAmount - $paidAmount); // Ensure balance doesn't go negative
                ?>
                
                <!-- Now you can use $balance and other fee details in the form -->
                
                <form method="post" action="{{ route('feepaymentmpesa', ['id' => $formData['fee_category_id']]) }}" >
                    @csrf
                    
                    <div class="card-block">
                        <!-- Display Fee Category Name -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="fee_category" class="form-label">{{ __('Fee Category') }}</label>
                    <input type="text" class="form-control" name="fee_category" id="fee_category" value="{{ $formData['fee_category_title'] ?? '' }} Fee" readonly>
                            </div>

                        
                        </div>
                        


                        <input type="hidden" name="assign_date" value="{{ date('Y-m-d') }}" readonly>
                        <input type="hidden" name="due_date" value="{{ $formData['due_date'] }}" readonly>
                        <input type="hidden" name="student_id" value="{{ auth('student')->user()->id }}">
                        <input type="hidden" name="fee_id" value="{{ $feeId ?? $formData['fee_category_id'] }}">
                        <input type="hidden" name="pay_date" value="{{ $formData['pay_date'] ?? now()->format('Y-m-d') }}">
                
                        <!-- Display Fee Amount and Balance -->
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="fee_amount" class="form-label">
                                    {{ __('Fee Amount') }} ({!! $setting->currency_symbol !!})
                                </label>
                                <input type="text" class="form-control" name="fee_amount" id="fee_amount" value="{{ $feeAmount }}" readonly>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="phone_number" class="form-label">
                                    {{ __('Phone Number') }}
                                </label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number" value="{{ $formData['phone_number'] }}" required>
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
                                <input type="text" class="form-control" name="balance" id="balance" value="{{ $balance }}" readonly>
                            </div>
                        </div>
                 <!-- Amount to Pay -->
        <div class="row">
            <div class="form-group col-md-6">
                <label for="payment_amount" class="form-label">
                    {{ __('Amount to Pay Now') }} ({!! $setting->currency_symbol !!}) <span>*</span>
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
            
       
           

                        @php
        $bankDetails = \App\Models\BankMpesaDetails::first();
        $paybill= \App\Models\PaybillDetail::first();
    @endphp
   <div class="col-sm-6">
<div class="container my-5">
    <div class="row justify-content-center">
     
            <div class="card shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h4>Bank Details</h4>
                </div>
                <div class="card-body">
                    @if ($bankDetails)
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                              
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><i class="bi bi-bank2 text-primary fs-4"></i> Bank Name</td>
                                    <td class="text-center">{{ $bankDetails->bank_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center"><i class="bi bi-card-text text-primary fs-4"></i> Account Number</td>
                                    <td class="text-center">{{ $bankDetails->bank_account }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center"><i class="bi bi-geo-alt text-primary fs-4"></i> Branch</td>
                                    <td class="text-center">{{ $bankDetails->bank_branch }}</td>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p>No bank details available.</p>
                        </div>
                    @endif
                </div>
        <div class="card shadow-sm">
            <div class="card-header text-center bg-secondary text-white">
                    <h4>PayBill Details</h4>
                </div>
                <div class="card-body">
                    @if ($paybill)
                        <table class="table table-bordered table-striped">
                            <thead class="table-light">
                              
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center"><i class="bi bi-wallet2 text-primary fs-4"></i> PayBill Number</td>
                                    <td class="text-center">{{ $paybill->paybill_number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center"><i class="bi bi-card-text text-primary fs-4"></i> Account Number</td>
                                    <td class="text-center">{{ $paybill->paybill_account }}</td>
                                </tr>
                                
                            </tbody>
                        </table>
                    @else
                        <div class="text-center">
                            <p>No bank details available.</p>
                        </div>
                    @endif
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
@endsection
