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

                    <form method="post" action="{{ route('student.initiatepush') }}">
                        @csrf
                        <div class="card-block">
                            <!-- Display Fee Information -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fee_category" class="form-label">{{ __('Fee Category') }}</label>
                                    <input type="text" class="form-control" name="fee_category" id="fee_category" 
                                           value="{{ $fee->category->title ?? 'Fee Payment' }}" readonly>
                                </div>
                            </div>

                            <!-- Hidden Fields -->
                            <input type="hidden" name="assign_date" value="{{ date('Y-m-d') }}">
                            <input type="hidden" name="due_date" value="{{ $fee->due_date ?? now()->addDays(30)->format('Y-m-d') }}">
                            <input type="hidden" name="student_id" value="{{ auth('student')->user()->id }}">
                            <input type="hidden" name="fee_id" value="{{ $fee->id ?? $id }}">
                            <input type="hidden" name="pay_date" value="{{ now()->format('Y-m-d') }}">
                
                            <!-- Display Fee Amount -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="fee_amount" class="form-label">
                                        {{ __('Fee Amount') }} ({!! $setting->currency_symbol ?? 'KSh' !!})
                                    </label>
                                    <input type="text" class="form-control" name="fee_amount" id="fee_amount" 
                                           value="{{ number_format($feeAmount, 2) }}" readonly>
                                </div>
                            </div>

                            <!-- Display Paid Amount -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="paid_amount" class="form-label">
                                        {{ __('Paid Amount') }} ({!! $setting->currency_symbol ?? 'KSh' !!})
                                    </label>
                                    <input type="text" class="form-control" name="paid_amount" id="paid_amount" 
                                           value="{{ number_format($paidAmount, 2) }}" readonly>
                                </div>
                            </div>

                            <!-- Display Balance -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="balance" class="form-label">
                                        {{ __('Balance Due') }} ({!! $setting->currency_symbol ?? 'KSh' !!})
                                    </label>
                                    <input type="text" class="form-control" name="balance" id="balance" 
                                           value="{{ number_format($balance, 2) }}" readonly>
                                </div>
                            </div>

                            <!-- Phone Number -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="phone_number" class="form-label">
                                        {{ __('Phone Number') }} <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" 
                                           value="{{ auth('student')->user()->phone ?? '' }}" 
                                           placeholder="2547XXXXXXXX" required>
                                    <small class="form-text text-muted">Format: 2547XXXXXXXX</small>
                                </div>
                            </div>

                            <!-- Amount to Pay -->
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="payment_amount" class="form-label">
                                        {{ __('Amount to Pay Now') }} ({!! $setting->currency_symbol ?? 'KSh' !!}) <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" class="form-control" name="payment_amount" id="payment_amount" 
                                           value="{{ $balance > 0 ? $balance : '' }}" 
                                           min="1" max="{{ $balance }}" 
                                           step="0.01" required>
                                    <small class="form-text text-muted">Maximum: {{ number_format($balance, 2) }}</small>
                                </div>
                            </div>

                            <!-- Notification -->
                            <div class="alert alert-info mt-3" role="alert">
                                <strong>Important:</strong> After you click on "Pay with M-Pesa," you will be prompted to enter your M-Pesa password on your phone to complete the payment.
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="payButton" {{ $balance <= 0 ? 'disabled' : '' }}>
                                <i class="fas fa-money-check"></i> 
                                {{ $balance <= 0 ? 'Already Paid' : 'Pay with M-Pesa' }}
                            </button>
                            
                            @if($balance <= 0)
                            <div class="alert alert-success mt-2">
                                <i class="fas fa-check-circle"></i> This fee has already been paid in full.
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Bank and Paybill Details -->
            <div class="col-sm-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-header text-center bg-primary text-white">
                        <h4>Bank Details</h4>
                    </div>
                    <div class="card-body">
                        @if ($bankDetails)
                            <table class="table table-bordered table-striped">
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
                </div>

                <div class="card shadow-sm">
                    <div class="card-header text-center bg-secondary text-white">
                        <h4>PayBill Details</h4>
                    </div>
                    <div class="card-body">
                        @if ($paybill)
                            <table class="table table-bordered table-striped">
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
                                <p>No PayBill details available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector('form');
    const payButton = document.getElementById('payButton');
    
    if (form && !payButton.disabled) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            
            const paymentAmount = parseFloat(document.getElementById('payment_amount').value);
            const balance = parseFloat(document.getElementById('balance').value);
            
            if (paymentAmount > balance) {
                alert('Payment amount cannot exceed the balance due.');
                return;
            }
            
            if (paymentAmount <= 0) {
                alert('Payment amount must be greater than 0.');
                return;
            }

            payButton.disabled = true;
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';

            const loader = document.createElement('div');
            loader.className = 'fixed-top fixed-bottom d-flex justify-content-center align-items-center bg-light bg-opacity-75';
            loader.style.zIndex = '9999';
            loader.innerHTML = `
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
                        <span class="visually-hidden">Processing...</span>
                    </div>
                    <p class="mt-3 fs-5">Processing payment. Please wait...</p>
                </div>`;
            document.body.appendChild(loader);

            setTimeout(() => {
                form.submit();
            }, 3000);
        });

        const phoneInput = document.getElementById('phone_number');
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.startsWith('0') && value.length === 10) {
                value = '254' + value.substring(1);
            } else if (value.startsWith('7') && value.length === 9) {
                value = '254' + value;
            }
            
            e.target.value = value;
        });
    }
});
</script>
@endsection