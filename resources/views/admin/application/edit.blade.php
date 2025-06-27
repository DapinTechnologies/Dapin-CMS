@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@section('content')
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_add') }} {{ __('field_student') }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>
                    
                    <div class="wizard-sec-bg">
                        <form id="wizard-advanced-form" class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <input type="text" name="registration_no" value="{{ $row->registration_no }}" hidden>

                            <h3>{{ __('tab_basic_info') }}</h3>
                            <content class="form-step">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $row->first_name }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="last_name">{{ __('field_last_name') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $row->last_name }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="gender">{{ __('field_gender') }} <span>*</span></label>
                                        <select class="form-control" name="gender" id="gender" required>
                                            <option value="">{{ __('select') }}</option>
                                            <option value="1" @if( $row->gender == 1 ) selected @endif>{{ __('gender_male') }}</option>
                                            <option value="2" @if( $row->gender == 2 ) selected @endif>{{ __('gender_female') }}</option>
                                            <option value="3" @if( $row->gender == 3 ) selected @endif>{{ __('gender_other') }}</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                        <input type="date" class="form-control date" name="dob" id="dob" value="{{ $row->dob }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                        <input type="text" class="form-control" name="phone" id="phone" value="{{ $row->phone }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="email">{{ __('field_email') }} <span>*</span></label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" required>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="national_id">{{ __('field_national_id') }}</label>
                                        <input type="text" class="form-control" name="national_id" id="national_id" value="{{ $row->national_id }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="admission_date">{{ __('field_admission_date') }} <span>*</span></label>
                                        <input type="date" class="form-control date" name="admission_date" id="admission_date" value="{{ date('Y-m-d') }}" required>
                                    </div>
                                </div>
                            </content>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
