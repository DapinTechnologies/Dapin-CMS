@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            @can($access.'-create')
            <div class="col-md-4">
                <form class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('btn_create') }} {{ $title }}</h5>
                        </div>
                        <div class="card-block">
                            <!-- Form Start -->
                            <div class="form-group">
                                <label for="name" class="form-label">{{ __('field_name') }} <span>*</span></label>
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_name') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="type" class="form-label">{{ __('field_type') }} <span>*</span></label>
                                <select class="form-control" name="type" id="type" required>
                                    <option value="">{{ __('select') }}</option>
                                    <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>{{ __('field_fixed') }}</option>
                                    <option value="rate" {{ old('type') == 'rate' ? 'selected' : '' }}>{{ __('field_rate') }}</option>
                                    <option value="tiered" {{ old('type') == 'tiered' ? 'selected' : '' }}>{{ __('field_tiered') }}</option>
                                </select>
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_type') }}
                                </div>
                            </div>

                            <!-- Fixed Amount Field -->
                            <div class="form-group" id="fixed-field">
                                <label for="fixed_amount" class="form-label">{{ __('field_fixed_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                <input type="text" class="form-control" name="fixed_amount" id="fixed_amount" value="{{ old('fixed_amount') }}">
                                <div class="invalid-feedback">
                                  {{ __('required_field') }} {{ __('field_fixed_amount') }}
                                </div>
                            </div>

                            <!-- Rate Fields -->
                            <div id="rate-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="rate" class="form-label">{{ __('field_rate') }} (e.g., 0.0275) <span>*</span></label>
                                    <input type="text" class="form-control" name="rate" id="rate" value="{{ old('rate') }}" placeholder="0.0275">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_rate') }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="min_salary" class="form-label">{{ __('field_min_salary') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                    <input type="text" class="form-control" name="min_salary" id="min_salary" value="{{ old('min_salary') }}" placeholder="25000">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_min_salary') }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="max_salary" class="form-label">{{ __('field_max_salary') }} ({!! $setting->currency_symbol !!})</label>
                                    <input type="text" class="form-control" name="max_salary" id="max_salary" value="{{ old('max_salary') }}" placeholder="Optional">
                                    <div class="invalid-feedback">
                                      {{ __('field_max_salary') }}
                                    </div>
                                </div>
                            </div>

                            <!-- Tiered Fields -->
                            <div id="tiered-fields" style="display: none;">
                                <div class="form-group">
                                    <label for="min_amount" class="form-label">{{ __('field_min_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                    <input type="text" class="form-control" name="min_amount" id="min_amount" value="{{ old('min_amount') }}">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_min_amount') }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="max_amount" class="form-label">{{ __('field_max_amount') }} ({!! $setting->currency_symbol !!}) <span>*</span></label>
                                    <input type="text" class="form-control" name="max_amount" id="max_amount" value="{{ old('max_amount') }}">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_max_amount') }}
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="percentage" class="form-label">{{ __('field_percentage') }} (%) <span>*</span></label>
                                    <input type="text" class="form-control" name="percentage" id="percentage" value="{{ old('percentage') }}">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_percentage') }}
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="max_no_deduction_amount" class="form-label">{{ __('field_max_no_deduction_amount') }} ({!! $setting->currency_symbol !!})</label>
                                <input type="text" class="form-control" name="max_no_deduction_amount" id="max_no_deduction_amount" value="{{ old('max_no_deduction_amount') }}">
                                <div class="invalid-feedback">
                                  {{ __('field_max_no_deduction_amount') }}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="description" class="form-label">{{ __('field_description') }}</label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <!-- Statutory Checkbox (always visible) -->
                            <div class="form-group">
                                <div class="checkbox checkbox-primary">
                                    <input type="checkbox" name="is_statutory" id="is_statutory" value="1" {{ old('is_statutory', 1) ? 'checked' : '' }}>
                                    <label for="is_statutory">{{ __('field_is_statutory') }}</label>
                                </div>
                            </div>
                            <!-- Form End -->
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> {{ __('btn_save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
            @endcan
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }} {{ __('list') }}</h5>
                    </div>
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="basic-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>{{ __('field_name') }}</th>
                                        <th>{{ __('field_type') }}</th>
                                        <th>{{ __('field_rate_amount') }}</th>
                                        <th>{{ __('field_max_no_deduction_amount') }}</th>
                                        <th>{{ __('field_status') }}</th>
                                        <th>{{ __('field_action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach( $rows as $key => $row )
                                    <tr>
                                        <td>{{ $row->name }}</td>
                                        <td>
                                            @if($row->type == 'fixed')
                                            <span class="badge badge-pill badge-primary">{{ __('field_fixed') }}</span>
                                            @elseif($row->type == 'rate')
                                            <span class="badge badge-pill badge-info">{{ __('field_rate') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-warning">{{ __('field_tiered') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->type == 'fixed')
                                                @if(isset($setting->decimal_place))
                                                {{ number_format((float)$row->fixed_amount, $setting->decimal_place, '.', '') }} 
                                                @else
                                                {{ number_format((float)$row->fixed_amount, 2, '.', '') }} 
                                                @endif
                                                {!! $setting->currency_symbol !!}
                                            @elseif($row->type == 'rate')
                                                Rate: {{ $row->rate }}<br>
                                                Min Salary: 
                                                @if(isset($setting->decimal_place))
                                                {{ number_format((float)$row->min_salary, $setting->decimal_place, '.', '') }} 
                                                @else
                                                {{ number_format((float)$row->min_salary, 2, '.', '') }} 
                                                @endif
                                                {!! $setting->currency_symbol !!}
                                            @else
                                                {{ __('field_tiered_calculation') }}
                                            @endif
                                        </td>
                                        <td>
                                            {!! $setting->currency_symbol !!}
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$row->max_no_deduction_amount, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$row->max_no_deduction_amount, 2, '.', '') }} 
                                            @endif
                                            
</td>
                                        <td>
                                            @if( $row->status == 1 )
                                            <span class="badge badge-pill badge-success">{{ __('status_active') }}</span>
                                            @else
                                            <span class="badge badge-pill badge-danger">{{ __('status_inactive') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @can($access.'-edit')
                                            <button type="button" class="btn btn-icon btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $row->id }}">
                                                <i class="far fa-edit"></i>
                                            </button>
                                            <!-- Include Edit modal -->
                                            @include($view.'.edit')
                                            @endcan

                                            @can($access.'-delete')
                                            <button type="button" class="btn btn-icon btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $row->id }}">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                            <!-- Include Delete modal -->
                                            @include('admin.layouts.inc.delete')
                                            @endcan
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@section('script')
<script>
// Show/hide fields based on deduction type
document.getElementById('type').addEventListener('change', function() {
    const type = this.value;
    const fixedField = document.getElementById('fixed-field');
    const rateFields = document.getElementById('rate-fields');
    const tieredFields = document.getElementById('tiered-fields');
    
    // Hide all fields first
    fixedField.style.display = 'none';
    rateFields.style.display = 'none';
    tieredFields.style.display = 'none';
    
    // Remove required from all fields
    document.getElementById('fixed_amount').removeAttribute('required');
    document.getElementById('rate').removeAttribute('required');
    document.getElementById('min_salary').removeAttribute('required');
    document.getElementById('min_amount').removeAttribute('required');
    document.getElementById('max_amount').removeAttribute('required');
    document.getElementById('percentage').removeAttribute('required');
    
    // Show relevant fields and set required
    if (type === 'fixed') {
        fixedField.style.display = 'block';
        document.getElementById('fixed_amount').setAttribute('required', 'required');
    } else if (type === 'rate') {
        rateFields.style.display = 'block';
        document.getElementById('rate').setAttribute('required', 'required');
        document.getElementById('min_salary').setAttribute('required', 'required');
    } else if (type === 'tiered') {
        tieredFields.style.display = 'block';
        document.getElementById('min_amount').setAttribute('required', 'required');
        document.getElementById('max_amount').setAttribute('required', 'required');
        document.getElementById('percentage').setAttribute('required', 'required');
    }
});

// Trigger change event on page load
document.getElementById('type').dispatchEvent(new Event('change'));
</script>
@endsection

@endsection
