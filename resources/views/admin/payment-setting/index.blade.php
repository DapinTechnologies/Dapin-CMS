@extends('admin.layouts.master')

@section('content')

@php
$bankDetails = \App\Models\BankMpesaDetails::first();
$paybill= \App\Models\PaybillDetail::first();
$mpesa= \App\Models\MpesaSetting::first();
@endphp



<!-- Start Content -->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-12 col-lg-12">
                <form class="needs-validation" novalidate action="{{ route('storegatedetails') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Update') }} </h5>
                        </div>
                        <div class="card-block">
                            <!-- First Group Heading -->
                            <div class="row">
                                <div class="col-lg-12">
                                    <h6 class="mb-3">{{ __('Mpesa API SettingS') }}</h6>
                                </div>
                            </div>
                            <div class="row">
                                <!-- Field 1 -->
                                <div class="col-lg-4 mb-3">
                                    <div>
                                        <label for="field1" class="form-label">{{ __('Consumer Key') }}</label>
                                        <input 
                                        type="text" 
                                        name="consumer_key" 
                                        id="consumer_key" 
                                        class="form-control" 
                                        value="{{ $mpesa->consumer_key ?? '' }}" 
                                        required
                                    >
                                        <div class="invalid-feedback">
                                            {{ __('Please provide a valid Consumer Key.') }}
                                        </div>
                                    </div>

                                    <div>
                                        <label for="field1" class="form-label">{{ __('Consumer Secret') }}</label>
                                        <input type="text" name="consumer_secret" id="consumer_secret" class="form-control" value="{{ $mpesa->consumer_secret ?? '' }}" required>
                                        <div class="invalid-feedback">
                                            {{ __('Please provide a valid Consumer Secret.') }}
                                        </div>
                                    </div>
                                    <div>
                                        <label for="field1" class="form-label">{{ __('Short Code') }}</label>
                                        <input type="text" name="shortcode" id="shortcode" class="form-control"  value="{{ $mpesa->shortcode ?? '' }}" required>
                                        <div class="invalid-feedback">
                                            {{ __('Please provide a valid Short Code.') }}
                                        </div>
                                    </div>
                                   
                                </div>

                                <!-- Second Group Heading (Above Field 2) -->
                                <div class="col-lg-4 mb-3">
                                    <h6 class="mb-2">{{ __('Bank Details') }}</h6>
                                    <div>
                                        <label for="field1" class="form-label">{{ __('Bank  Name') }}</label>
                                        <input type="text" name="bank_name" id="bank_name" class="form-control" value="{{$bankDetails->bank_name ?? ''}}" required>
                                        <div class="invalid-feedback">
                                            {{ __('Please provide a valid Bank  Name.') }}
                                        </div>
                                    </div>

                                    <div>
                                        <label for="field1" class="form-label">{{ __('Bank Account Number') }}</label>
                                        <input type="text" name="bank_account" id="bank_account" class="form-control" value="{{$bankDetails->bank_account ?? ''}}" required>
                                        <div class="invalid-feedback">
                                            {{ __('Please provide a valid Bank Account Number.') }}
                                        </div>
                                    </div>

                                    <div>
                                        <label for="field1" class="form-label">{{ __('Bank  Name') }}</label>
                                        <input type="text" name="bank_branch" id="bank_branch" class="form-control"  value="{{$bankDetails->bank_branch ?? ''}}"required>
                                        <div class="invalid-feedback">
                                            {{ __('Please provide a valid Bank  Name.') }}
                                        </div>
                                    </div>


                                </div>

                                <!-- Last Group Heading (Above Field 3) -->
                                <div class="col-lg-4 mb-3">
                                    <h6 class="mb-2">{{ __('PayBill Information') }}</h6>

                                    <div>
                                    <label for="field3" class="form-label">{{ __('PayBill Number') }}</label>
                                    <input type="text" name="paybill_number" id="paybill_number" class="form-control"  value="{{$paybill->paybill_number ?? ''}}" required>
                                    <div class="invalid-feedback">
                                        {{ __('Please provide a valid PayBill Number.') }}
                                    </div>
                                </div>

                                <div>
                                    <label for="field3" class="form-label">{{ __('PayBill Account') }}</label>
                                    <input type="text" name="paybill_account" id="paybill_account" class="form-control" value="{{$paybill->paybill_account ?? ''}}" required>
                                    <div class="invalid-feedback">
                                        {{ __('Please provide a valid PayBill Account.') }}
                                    </div>
                                </div>

                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Save /Update Settings') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
