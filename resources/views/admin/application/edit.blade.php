@extends('admin.layouts.master')
@section('title', $title)
@section('content')




<form id="wizard-advanced-form" class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <!-- Basic Information -->
    <h3>{{ __('tab_basic_info') }}</h3>
    <content class="form-step">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="first_name">{{ __('First Name') }} <span>*</span></label>
                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $row->first_name }}" required>
            </div>

            <div class="form-group col-md-6">
                <label for="last_name">{{ __('Last Name') }} <span>*</span></label>
                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $row->last_name }}" required>
            </div>

            <div class="form-group col-md-6">
                <label for="dob">{{ __('Date of Birth') }} <span>*</span></label>
                <input type="date" class="form-control" name="dob" id="dob" value="{{ $row->dob }}" required>
            </div>

            <div class="form-group col-md-6">
                <label for="phone">{{ __('Phone Number') }} <span>*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ $row->phone }}" required>
            </div>
<div class="form-group col-md-6">
    <label for="email">{{ __('Email') }} <span>*</span></label>
    <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" required>
</div>

            <!-- Gender Field -->
            <div class="form-group col-md-6">
                <label for="gender">{{ __('Gender') }} <span>*</span></label>
                <select class="form-control" name="gender" id="gender" required>
                    <option value="">{{ __('Select Gender') }}</option>
                    <option value="1" @if($row->gender == 1) selected @endif>{{ __('Male') }}</option>
                    <option value="2" @if($row->gender == 2) selected @endif>{{ __('Female') }}</option>
                    <option value="3" @if($row->gender == 3) selected @endif>{{ __('Other') }}</option>
                </select>
            </div>

            <!-- Program Field -->
            <div class="form-group col-md-6">
                <label for="program">{{ __('Program') }} <span>*</span></label>
                <select class="form-control" name="program" id="program" required>
                    <option value="">{{ __('Select Program') }}</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" @if($row->program_id == $program->id) selected @endif>{{ $program->title }}</option>
                    @endforeach
                </select>
            </div>
        </div>
    </content>

    <!-- KCSE Results -->
    <h3>{{ __('KCSE Results') }}</h3>
    <content class="form-step">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="kcse_index_no">{{ __('KCSE Index Number') }} <span>*</span></label>
                <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" value="{{ $row->kcse_index_no }}" required>
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_year">{{ __('KCSE Year') }} <span>*</span></label>
                <input type="text" class="form-control" name="kcse_year" id="kcse_year" value="{{ $row->kcse_year }}" required>
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_grade">{{ __('KCSE Grade') }} <span>*</span></label>
                <input type="text" class="form-control" name="kcse_grade" id="kcse_grade" value="{{ $row->kcse_grade }}" required>
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_certificate">{{ __('KCSE Certificate') }} <span>*</span></label>
                <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate">
                @if($row->kcse_certificate)
                    <a href="{{ asset('uploads/'.$path.'/'.$row->kcse_certificate) }}" target="_blank">Current KCSE Certificate</a>
                @endif
            </div>

            <div class="form-group col-md-6">
                <label for="kcse_result_slip">{{ __('KCSE Result Slip') }} <span>*</span></label>
                <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip">
                @if($row->kcse_result_slip)
                    <a href="{{ asset('uploads/'.$path.'/'.$row->kcse_result_slip) }}" target="_blank">Current KCSE Result Slip</a>
                @endif
            </div>
        </div>
    </content>

    <!-- County and Sub-county -->
    <h3>{{ __('Location') }}</h3>
    <content class="form-step">
        <div class="row">
            <div class="form-group col-md-6">
                <label for="county">{{ __('County') }} <span>*</span></label>
                <select class="form-control" name="county" id="county" required>
                    <option value="">{{ __('Select County') }}</option>
                    @foreach($counties as $county)
                        <option value="{{ $county->CountyID }}" @if($row->county_id == $county->CountyID) selected @endif>{{ $county->CountyName }}</option>
                    @endforeach
                </select>
            </div>

           <div class="form-group col-md-6">
            <label for="sub_county">{{ __('Sub-County') }} <span>*</span></label>
            <select class="form-control" name="sub_county" id="sub_county" required>
                <option value="">{{ __('Select Sub-County') }}</option>
                @foreach($sub_counties as $subCounty)
                    <option value="{{ $subCounty->SubCountyID }}" @if($row->sub_county_id == $subCounty->SubCountyID) selected @endif>{{ $subCounty->SubCountyName }}</option>
                @endforeach
            </select>
        </div>
        </div>

        <div class="form-group col-md-6">
    <label for="mode_of_education">{{ __('Mode of Study') }} <span>*</span></label>
    <select class="form-control" name="mode_of_education" id="mode_of_education" required>
        <option value="">{{ __('Select Mode of Study') }}</option>
        <option value="Physical" @if($row->mode_of_study == 'Physical') selected @endif>Physical</option>
        <option value="Online" @if($row->mode_of_study == 'Online') selected @endif>Online</option>
        <option value="Hybrid" @if($row->mode_of_study == 'Hybrid') selected @endif>Hybrid</option>
    </select>
</div>

    </content>

    <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
</form>
<script>
// Dynamic Sub-County Filtering Based on Selected County
    $(document).ready(function () {
        // Store all sub-county options in a variable
        var allSubCounties = $('#sub_county').html();

        $('#county').change(function () {
            var countyId = $(this).val();
            $('#sub_county').html('<option value="">{{ __('Select Sub-County') }}</option>');

            // Filter sub-counties based on the selected county
            $(allSubCounties).filter('option').each(function () {
                if ($(this).data('county-id') == countyId) {
                    $('#sub_county').append($(this).clone());
                }
            });

            // Debugging: Log the selected county ID and filtered sub-counties
            console.log('Selected County ID:', countyId);
            console.log('Filtered Sub-Counties:', $('#sub_county').html());
        });
    });

</script>


@endsection