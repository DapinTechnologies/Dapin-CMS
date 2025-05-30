@extends('admin.layouts.master')
@section('title', 'Dapin SMS Setup')
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-md-12 col-lg-10">
                <form class="needs-validation" novalidate action="{{ route('sms.store') }}" method="post">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('Dapin SMS API Configuration') }}</h5>
                        </div>
                        <div class="card-block">
                            <div class="row">
                                <input name="id" type="hidden" value="{{ $smsConfig->id ?? -1 }}">

                                <div class="container">
                                    <div class="form-group">
                                        <label for="sms_api_url">{{ __('SMS API URL') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="sms_api_url" id="sms_api_url" 
                                               value="{{ $smsConfig->api_url ?? 'https://smsportal.dapintechnologies.com/sms/v3/sendmultiple' }}" required>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('SMS API URL') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sms_api_key">{{ __('SMS API Key') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="sms_api_key" id="sms_api_key" 
                                               value="{{ $smsConfig->api_key ?? '9v4CNdzEQOyehbr3P2ns5ltwfTVYRiSp0cI6uo1DZG8jBFqMm7xWXaLkUAKgHJ' }}" required>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('SMS API Key') }}
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="sms_service_id">{{ __('SMS Service ID') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="sms_service_id" id="sms_service_id" 
                                               value="{{ $smsConfig->sms_service_id ?? '0' }}" required>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('SMS Service ID') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
