@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Card ] start -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                        <a href="{{ route($route.'.edit', $row->id) }}" class="btn btn-info"><i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}</a>
                    </div>

                    <form class="needs-validation" novalidate action="{{ route($route.'.update', [$row->id]) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="card-block">
                      <div class="row">
                        <!-- Form Start -->
                        <div class="form-group col-md-6">
                            <label for="billing_no">{{ __('field_billing_no') }} <span>*</span></label>
                            <input type="text" class="form-control" name="billing_no" id="billing_no" value="{{ $row->billing_no }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_billing_no') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="supplier_id">{{ __('field_supplier') }} <span>*</span></label>
                            <select class="form-control" name="supplier_id" id="supplier_id" required>
                                <option value="">{{ __('select') }}</option>
                                @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->id }}" @if($supplier->id == $row->supplier_id) selected @endif>{{ $supplier->title }}</option>
                                @endforeach
                            </select>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_supplier') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="title">{{ __('field_title') }} <span>*</span></label>
                            <input type="text" class="form-control" name="title" id="title" value="{{ $row->title }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_title') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="amount">{{ __('field_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                            <input type="text" class="form-control autonumber" name="amount" id="amount" value="{{ round($row->amount) }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_amount') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="date">{{ __('field_date') }} <span>*</span></label>
                            <input type="date" class="form-control date" name="date" id="date" value="{{ $row->date }}" required>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="due_date">{{ __('field_due_date') }}</label>
                            <input type="date" class="form-control date" name="due_date" id="due_date" value="{{ $row->due_date }}">

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_due_date') }}
                            </div>
                        </div>

                        <div class="form-group col-md-12">
                            <label for="description">{{ __('field_description') }}</label>
                            <textarea class="form-control" name="description" id="description" rows="3">{{ $row->description }}</textarea>

                            <div class="invalid-feedback">
                              {{ __('required_field') }} {{ __('field_description') }}
                            </div>
                        </div>

                        <div class="form-group col-md-6">
                            <label for="status" class="form-label">{{ __('field_status') }}</label>
                            <select class="form-control" name="status" id="status">
                                <option value="1" @if($row->status == 1) selected @endif>{{ __('status_active') }}</option>
                                <option value="0" @if($row->status == 0) selected @endif>{{ __('status_inactive') }}</option>
                            </select>
                        </div>
                        <!-- Form End -->
                      </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_update') }}</button>
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

@endsection