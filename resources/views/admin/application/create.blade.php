
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>

    <title>{{ $applicationSetting->title ?? $title }}</title>
    @include('admin.layouts.common.header_script')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
</head>
<body>

    @php
    use App\Models\Program;
    use App\Models\County;
    use App\Models\SubCounty;

    // Fetch data directly in the view
    $programs = Program::all();
    $counties = County::all();
    $subCounties = SubCounty::all();
@endphp




@isset($applicationSetting)
<div class="main-body">
    <div class="page-wrapper">
        <div class="card">
            <div class="card-block">
                <div class="row mt-5 mb-5">
                    <div class="col-sm-8 text-center">
                        <h2>{{ $applicationSetting->title }}</h2>
                        <p>{!! strip_tags($applicationSetting->body, '<br><b><i><strong><u><a><span><del>') !!}</p>
                    </div>
                </div>
                @if (session('success'))
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-double"></i> {{ trans_choice('module_application', 1) }} {{ session('success') }}
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                        <!-- Basic Information -->
                        <h3>{{ __('tab_basic_info') }}</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>Personal Information</legend>
                                
                                <div class="col-md-6">
                                    <label for="first_name">{{ __('First Name') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="last_name">{{ __('Last Name') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="dob">{{ __('Date of Birth') }} <span>*</span></label>
                                    <input type="date" class="form-control" name="dob" id="dob" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone">{{ __('Phone Number') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="phone" id="phone" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="email">{{ __('Email Address') }} <span>*</span></label>
                                    <input type="email" class="form-control" name="email" id="email" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="national_id">{{ __('National ID/Parent ID') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="national_id" id="national_id" required>
                                </div>

                                <!-- Gender Field -->
                                <div class="col-md-6">
                                    <label for="gender">{{ __('Gender') }} <span>*</span></label>
                                    <select class="form-control" name="gender" id="gender" required>
                                        <option value="">{{ __('Select Gender') }}</option>
                                        <option value="1">{{ __('Male') }}</option>
                                        <option value="2">{{ __('Female') }}</option>
                                        <option value="3">{{ __('Other') }}</option>
                                    </select>
                                </div>

                                <!-- Program Field (Populated from Model) -->
                                <div class="col-md-6">
                                    <label for="program">{{ __('Program') }} <span>*</span></label>
                                    <select class="form-control" name="program" id="program" required>
                                        <option value="">{{ __('Select Program') }}</option>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}">{{ $program->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </fieldset>
                        </content>

                        <!-- KCSE Results -->
                       <!-- KCSE Results -->
<h3>{{ __('KCSE Results') }}</h3>
<content class="form-step">
    <fieldset class="row scheduler-border">
        <legend>KCSE Results</legend>

        <div class="col-md-6">
            <label for="kcse_index_no">{{ __('KCSE Index Number') }} <span>*</span></label>
            <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" required>
        </div>

        <div class="col-md-6">
            <label for="kcse_year">{{ __('KCSE Year') }} <span>*</span></label>
            <input type="text" class="form-control" name="kcse_year" id="kcse_year" required>
        </div>

        <div class="col-md-6">
            <label for="kcse_overall_grade">{{ __('Overall KCSE Grade') }} <span>*</span></label>
            <input type="text" class="form-control" name="kcse_grade" id="kcse_overall_grade" required>
        </div>

        <!-- KCSE Certificate Upload -->
        <div class="col-md-6">
            <label for="kcse_certificate">{{ __('KCSE Certificate') }} <span>*</span></label>
            <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate" required>
        </div>

        <!-- KCSE Result Slip Upload -->
        <div class="col-md-6">
            <label for="kcse_result_slip">{{ __('KCSE Result Slip') }} <span>*</span></label>
            <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip" required>
        </div>
    </fieldset>
</content>

                        <!-- Location Information -->
                        <h3>Location</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>Location Details</legend>

                                <!-- County Dropdown -->
                                <div class="col-md-6">
                                    <label for="county">{{ __('County') }} <span>*</span></label>
                                    <select class="form-control" name="county" id="county" required>
                                        <option value="">{{ __('Select County') }}</option>
                                        @foreach($counties as $county)
                                            <option value="{{ $county->CountyID }}">{{ $county->CountyName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Sub-County Dropdown -->
                                <div class="col-md-6">
                                    <label for="sub_county">{{ __('Sub-County') }} <span>*</span></label>
                                    <select class="form-control" name="sub_county" id="sub_county" required>
                                        <option value="">{{ __('Select Sub-County') }}</option>
                                        @foreach($subCounties as $subCounty)
                                            <option value="{{ $subCounty->SubCountyID }}" data-county-id="{{ $subCounty->CountyID }}">{{ $subCounty->SubCountyName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="physical_address">{{ __('Physical Address') }}</label>
                                    <input type="text" class="form-control" name="physical_address" id="physical_address">
                                </div>
                            </fieldset>
                        </content>

                        <!-- Mode of Study -->
                        <h3>Mode of Study</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>Preferred Mode of Study</legend>

                                <div class="col-md-6">
                                    <label for="mode_of_study">{{ __('Mode of Study') }} <span>*</span></label>
                                    <select class="form-control" name="mode_of_education" id="mode_of_study" required>
                                        <option value="">{{ __('Select Mode of Study') }}</option>
                                        <option value="Physical">Physical</option>
                                        <option value="Online">Online</option>
                                        <option value="Hybrid">Hybrid</option>
                                        
                                    </select>
                                </div>
                            </fieldset>
                        </content>

                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset
@include('admin.layouts.common.footer_script')
<script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>

<script>
    "use strict";
    var form = $("#wizard-advanced-form").show();
    form.steps({
        headerTag: "h3",
        bodyTag: "content",
        transitionEffect: "slideLeft",
        labels: {
            finish: "{{ __('btn_finish') }}",
            next: "{{ __('btn_next') }}",
            previous: "{{ __('btn_previous') }}",
        },
        onFinished: function () {
            $("#wizard-advanced-form").submit();
        }
    });

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

</body>
</html>