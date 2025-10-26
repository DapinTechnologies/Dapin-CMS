<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <title>{{ $applicationSetting->title ?? $title }}</title>
    @include('admin.layouts.common.header_script')
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/toastr/css/toastr.min.css') }}">
    <style>
        .is-invalid { border-color: #dc3545; }
        .invalid-feedback { display: none; color: #dc3545; font-size: 0.875em; }
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .was-validated .form-control:invalid ~ .invalid-feedback,
        .form-control.is-invalid ~ .invalid-feedback { display: block; }
        .debug-info { background: #f8f9fa; padding: 10px; margin: 10px 0; border-left: 4px solid #007bff; }
    </style>
</head>
<body>

@php
    use App\Models\Program;
    use App\Models\County;
    use App\Models\SubCounty;

    $programs = Program::all();
    $counties = County::all();
    $subCounties = SubCounty::all();

    // Debug: Log available data
    // \Log::info('Application Form Loaded', [
    //     'programs_count' => $programs->count(),
    //     'counties_count' => $counties->count(),
    //     'subCounties_count' => $subCounties->count(),
    //     'old_data' => old()
    // ]);
@endphp

@isset($applicationSetting)
<div class="main-body">
    <div class="page-wrapper">
        <!-- Debug Information -->
        <div class="debug-info">
            <strong>Debug Info:</strong> 
            Programs: {{ $programs->count() }}, 
            Counties: {{ $counties->count() }}, 
            SubCounties: {{ $subCounties->count() }}
            @if($errors->any())
                <br><strong>Errors:</strong> {{ $errors->count() }} validation errors
            @endif
        </div>

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
                    <form id="wizard-advanced-form" class="needs-validation" action="{{ route($route.'.store') }}" method="post" enctype="multipart/form-data">
                    @csrf

                    <!-- Hidden debug field to test submission -->
                    <input type="hidden" name="debug_test" value="debug_value_123">

                        <!-- Basic Information -->
                        <h3>{{ __('tab_basic_info') }}</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>Personal Information</legend>
                                
                                <div class="col-md-6">
                                    <label for="first_name">{{ __('First Name') }} <span>*</span></label>
                                    <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                                           name="first_name" id="first_name" 
                                           value="{{ old('first_name') }}"
                                           required minlength="2" maxlength="50" pattern="[A-Za-z\s\-']+"
                                           title="Only letters, spaces, hyphens and apostrophes allowed">
                                    <div class="invalid-feedback">
                                        @error('first_name') {{ $message }} @else Please enter a valid first name (2-50 characters) @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="last_name">{{ __('Last Name') }} <span>*</span></label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                           name="last_name" id="last_name" 
                                           value="{{ old('last_name') }}"
                                           required minlength="2" maxlength="50" pattern="[A-Za-z\s\-']+"
                                           title="Only letters, spaces, hyphens and apostrophes allowed">
                                    <div class="invalid-feedback">
                                        @error('last_name') {{ $message }} @else Please enter a valid last name (2-50 characters) @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="dob">{{ __('Date of Birth') }} <span>*</span></label>
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" 
                                           name="dob" id="dob" 
                                           value="{{ old('dob') }}"
                                           required max="{{ now()->subYears(16)->format('Y-m-d') }}"
                                           min="{{ now()->subYears(70)->format('Y-m-d') }}">
                                    <div class="invalid-feedback">
                                        @error('dob') {{ $message }} @else You must be between 16 and 70 years old @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="phone">{{ __('Phone Number') }} <span>*</span></label>
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                           name="phone" id="phone" 
                                           value="{{ old('phone') }}"
                                           required pattern="^(?:254|\+254|0)?(7|1)\d{8}$"
                                           title="Please enter a valid Kenyan phone number">
                                    <div class="invalid-feedback">
                                        @error('phone') {{ $message }} @else Please enter a valid Kenyan phone number @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="email">{{ __('Email Address') }} <span>*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" id="email" 
                                           value="{{ old('email') }}"
                                           required pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$">
                                    <div class="invalid-feedback">
                                        @error('email') {{ $message }} @else Please enter a valid email address @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="national_id">{{ __('National ID/Parent ID') }} <span>*</span></label>
                                    <input type="text" class="form-control @error('national_id') is-invalid @enderror" 
                                           name="national_id" id="national_id" 
                                           value="{{ old('national_id') }}"
                                           required minlength="6" maxlength="20" pattern="[A-Za-z0-9\-]+"
                                           title="Only letters, numbers and hyphens allowed">
                                    <div class="invalid-feedback">
                                        @error('national_id') {{ $message }} @else Please enter a valid ID number @enderror
                                    </div>
                                </div>

                                <!-- Gender Field -->
                                <div class="col-md-6">
                                    <label for="gender">{{ __('Gender') }} <span>*</span></label>
                                    <select class="form-control @error('gender') is-invalid @enderror" name="gender" id="gender" required>
                                        <option value="">{{ __('Select Gender') }}</option>
                                        <option value="1" {{ old('gender') == '1' ? 'selected' : '' }}>{{ __('Male') }}</option>
                                        <option value="2" {{ old('gender') == '2' ? 'selected' : '' }}>{{ __('Female') }}</option>
                                        <option value="3" {{ old('gender') == '3' ? 'selected' : '' }}>{{ __('Other') }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('gender') {{ $message }} @else Please select your gender @enderror
                                    </div>
                                </div>

                                <!-- Program Field -->
                                <div class="col-md-6">
                                    <label for="program">{{ __('Program') }} <span>*</span></label>
                                    <select class="form-control @error('program') is-invalid @enderror" name="program" id="program" required>
                                        <option value="">{{ __('Select Program') }}</option>
                                        @foreach($programs as $program)
                                            <option value="{{ $program->id }}" {{ old('program') == $program->id ? 'selected' : '' }}>{{ $program->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('program') {{ $message }} @else Please select a program @enderror
                                    </div>
                                </div>
                            </fieldset>
                        </content>

                        <!-- KCSE Results -->
                        <h3>{{ __('KCSE Results') }}</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>KCSE Results</legend>

                            <div class="col-md-6">
    <label for="kcse_index_no">{{ __('KCSE Index Number') }} <span>*</span></label>
    <input type="text" class="form-control @error('kcse_index_no') is-invalid @enderror" 
           name="kcse_index_no" id="kcse_index_no" 
           value="{{ old('kcse_index_no') }}"
           required pattern="^[0-9]+$" title="Please enter numbers only"
           oninput="this.value = this.value.replace(/[^0-9]/g, '')">
    <div class="invalid-feedback">
        @error('kcse_index_no') {{ $message }} @else Please enter a valid KCSE index number (numbers only) @enderror
    </div>
</div>

                                <div class="col-md-6">
                                    <label for="kcse_year">{{ __('KCSE Year') }} <span>*</span></label>
                                    <input type="text" class="form-control @error('kcse_year') is-invalid @enderror" 
                                           name="kcse_year" id="kcse_year" 
                                           value="{{ old('kcse_year') }}"
                                           required pattern="^(19|20)\d{2}$" min="1989" max="{{ date('Y') }}"
                                           title="Enter a valid year between 1989 and current year">
                                    <div class="invalid-feedback">
                                        @error('kcse_year') {{ $message }} @else Please enter a valid KCSE year @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="kcse_overall_grade">{{ __('Overall KCSE Grade') }} <span>*</span></label>
                                    <input type="text" class="form-control @error('kcse_grade') is-invalid @enderror" 
                                           name="kcse_grade" id="kcse_overall_grade" 
                                           value="{{ old('kcse_grade') }}"
                                           required pattern="^[A-E][+-]?$|^[A-E][1-8]$" title="Valid grades: A, A-, B+, B, etc.">
                                    <div class="invalid-feedback">
                                        @error('kcse_grade') {{ $message }} @else Please enter a valid KCSE grade (A to E) @enderror
                                    </div>
                                </div>

                                <!-- KCSE Certificate Upload -->
                                <div class="col-md-6">
                                    <label for="kcse_certificate">{{ __('KCSE Certificate') }} <span>*</span></label>
                                    <input type="file" class="form-control @error('kcse_certificate') is-invalid @enderror" 
                                           name="kcse_certificate" id="kcse_certificate" required
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="invalid-feedback">
                                        @error('kcse_certificate') {{ $message }} @else Please upload a valid KCSE certificate (PDF, JPG, PNG up to 2MB) @enderror
                                    </div>
                                </div>

                                <!-- KCSE Result Slip Upload -->
                                <div class="col-md-6">
                                    <label for="kcse_result_slip">{{ __('KCSE Result Slip') }} <span>*</span></label>
                                    <input type="file" class="form-control @error('kcse_result_slip') is-invalid @enderror" 
                                           name="kcse_result_slip" id="kcse_result_slip" required
                                           accept=".pdf,.jpg,.jpeg,.png">
                                    <div class="invalid-feedback">
                                        @error('kcse_result_slip') {{ $message }} @else Please upload a valid KCSE result slip (PDF, JPG, PNG up to 2MB) @enderror
                                    </div>
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
                                    <select class="form-control @error('county') is-invalid @enderror" name="county" id="county" required>
                                        <option value="">{{ __('Select County') }}</option>
                                        @foreach($counties as $county)
                                            <option value="{{ $county->CountyID }}" {{ old('county') == $county->CountyID ? 'selected' : '' }}>
                                                {{ $county->CountyName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('county') {{ $message }} @else Please select your county @enderror
                                    </div>
                                </div>

                                <!-- Sub-County Dropdown -->
                                <div class="col-md-6">
                                    <label for="sub_county">{{ __('Sub-County') }} <span>*</span></label>
                                    <select class="form-control @error('sub_county') is-invalid @enderror" name="sub_county" id="sub_county" required>
                                        <option value="">{{ __('Select Sub-County') }}</option>
                                        @foreach($subCounties as $subCounty)
                                            <option value="{{ $subCounty->SubCountyID }}" 
                                                    data-county-id="{{ $subCounty->CountyID }}"
                                                    {{ old('sub_county') == $subCounty->SubCountyID && old('county') == $subCounty->CountyID ? 'selected' : '' }}>
                                                {{ $subCounty->SubCountyName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('sub_county') {{ $message }} @else Please select your sub-county @enderror
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="physical_address">{{ __('Physical Address') }}</label>
                                    <input type="text" class="form-control @error('physical_address') is-invalid @enderror" 
                                           name="physical_address" id="physical_address"
                                           value="{{ old('physical_address') }}"
                                           maxlength="255">
                                    <div class="invalid-feedback">
                                        @error('physical_address') {{ $message }} @enderror
                                    </div>
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
                                    <select class="form-control @error('mode_of_education') is-invalid @enderror" name="mode_of_education" id="mode_of_study" required>
                                        <option value="">{{ __('Select Mode of Study') }}</option>
                                        <option value="Physical" {{ old('mode_of_education') == 'Physical' ? 'selected' : '' }}>Physical</option>
                                        <option value="Online" {{ old('mode_of_education') == 'Online' ? 'selected' : '' }}>Online</option>
                                        <option value="Hybrid" {{ old('mode_of_education') == 'Hybrid' ? 'selected' : '' }}>Hybrid</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        @error('mode_of_education') {{ $message }} @else Please select your preferred mode of study @enderror
                                    </div>
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
<script src="{{ asset('dashboard/plugins/toastr/js/toastr.min.js') }}"></script>

@toastr_render

<script type="text/javascript">
    @if($errors->any())
        @foreach($errors->all() as $error)
            toastr["error"]("{{ $error }}");
        @endforeach
    @endif
</script>

<script>
    "use strict";
    $(document).ready(function () {
        console.log('Form initialization started');
        
        // Initialize form steps
        var form = $("#wizard-advanced-form").show();
        
        // Debug: Log form data before submission
        form.on('submit', function(e) {
            console.log('Form submitted');
            
            // Log all form data
            var formData = new FormData(this);
            console.log('Form data being submitted:');
            for (var pair of formData.entries()) {
                console.log(pair[0] + ': ' + pair[1]);
            }
            
            // Log validation status
            console.log('Form validation status:', this.checkValidity());
            
            if (this.checkValidity() === false) {
                e.preventDefault();
                e.stopPropagation();
                console.log('Form validation failed');
            } else {
                console.log('Form validation passed, submitting...');
            }
            $(this).addClass('was-validated');
        });

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            labels: {
                finish: "{{ __('btn_finish') }}",
                next: "{{ __('btn_next') }}",
                previous: "{{ __('btn_previous') }}",
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                console.log('Step changing from', currentIndex, 'to', newIndex);
                
                // Always allow going backward
                if (currentIndex > newIndex) {
                    return true;
                }
                
                // Validate current step before proceeding
                var form = $(this);
                var isValid = true;
                
                if (currentIndex < newIndex) {
                    $(".form-step").eq(currentIndex).find("[required]").each(function() {
                        if (!$(this).val()) {
                            console.log('Validation failed for:', $(this).attr('name'));
                            $(this).addClass("is-invalid");
                            isValid = false;
                        } else {
                            $(this).removeClass("is-invalid");
                        }
                    });
                }
                
                if (!isValid) {
                    form.steps("show", currentIndex);
                    console.log('Step validation failed, staying on current step');
                }
                
                return isValid;
            },
            onFinished: function () {
                console.log('Form finished, submitting...');
                $("#wizard-advanced-form").submit();
            }
        });

        // Store all sub-county options in a variable
        var allSubCounties = $('#sub_county').html();
        console.log('Sub-counties loaded:', $('#sub_county option').length);

        // Dynamic Sub-County Filtering Based on Selected County
        $('#county').change(function () {
            var countyId = $(this).val();
            var $subCountySelect = $('#sub_county');
            
            console.log('County changed to:', countyId);
            
            // Clear current options except the first one
            $subCountySelect.html('<option value="">{{ __('Select Sub-County') }}</option>');

            // If no county selected, return
            if (!countyId) return;

            // Filter and append matching sub-counties
            var matchedCount = 0;
            $(allSubCounties).filter('option').each(function() {
                if ($(this).data('county-id') == countyId) {
                    $subCountySelect.append($(this).clone());
                    matchedCount++;
                }
            });
            
            console.log('Matched sub-counties:', matchedCount);
        });

        // Initialize county/sub-county if returning with errors
        @if(old('county'))
            console.log('Initializing with old county value:', '{{ old('county') }}');
            $('#county').val('{{ old('county') }}').trigger('change');
            // Need a small delay to ensure the change event has processed
            setTimeout(function() {
                $('#sub_county').val('{{ old('sub_county') }}');
                console.log('Set sub-county to:', '{{ old('sub_county') }}');
            }, 100);
        @endif

        // Real-time validation for phone number
        $('#phone').on('input', function(e) {
            this.value = this.value.replace(/[^0-9+]/g, '');
        });

        // File validation for uploads
        $('#kcse_certificate, #kcse_result_slip').on('change', function(e) {
            const file = this.files[0];
            const allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
            const maxSize = 2 * 1024 * 1024; // 2MB
            
            console.log('File selected:', file ? file.name : 'none');
            
            if (file && !allowedTypes.includes(file.type)) {
                console.log('Invalid file type:', file.type);
                this.setCustomValidity('Only JPG, PNG or PDF files are allowed');
                this.reportValidity();
                this.value = '';
            } else if (file && file.size > maxSize) {
                console.log('File too large:', file.size);
                this.setCustomValidity('File size must be less than 2MB');
                this.reportValidity();
                this.value = '';
            } else {
                console.log('File validation passed');
                this.setCustomValidity('');
            }
        });

        console.log('Form initialization completed');
    });
</script>
</body>
</html>