@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Wizard css -->
    <link rel="stylesheet" href="{{ asset('dashboard/css/pages/wizard.css') }}">
@endsection

@section('content')
@php
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;

// Get all sessions, semesters, and sections directly here
$sessions = Session::where('status', 1)->get();
$semesters = Semester::where('status', 1)->get();
$sections = Section::where('status', 1)->get();
@endphp

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

                    <div class="wizard-sec-bg">
                    <form id="wizard-advanced-form" class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    @method('PUT')

                        <input type="hidden" name="registration_no" value="{{ $row->registration_no }}">

                        <h3>{{ __('tab_basic_info') }}</h3>
                        <content class="form-step">
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="row scheduler-border">
                                        <div class="form-group col-md-6">
                                            <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $row->first_name) }}" required>
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_first_name') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="last_name">{{ __('field_last_name') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $row->last_name) }}" required>
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_last_name') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                            <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $row->phone) }}" required>
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_phone') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="email">{{ __('field_email') }} <span>*</span></label>
                                            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $row->email) }}" required>
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_email') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="gender">{{ __('field_gender') }} <span>*</span></label>
                                            <select class="form-control" name="gender" id="gender" required>
                                                <option value="">{{ __('select') }}</option>
                                                <option value="1" @if(old('gender', $row->gender) == 1) selected @endif>{{ __('gender_male') }}</option>
                                                <option value="2" @if(old('gender', $row->gender) == 2) selected @endif>{{ __('gender_female') }}</option>
                                                <option value="3" @if(old('gender', $row->gender) == 3) selected @endif>{{ __('gender_other') }}</option>
                                            </select>
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_gender') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                            <input type="date" class="form-control date" name="dob" id="dob" value="{{ old('dob', $row->dob) }}" required>
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_dob') }}
                                            </div>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="admission_date">{{ __('field_admission_date') }} <span>*</span></label>
                                            <input type="date" class="form-control date" name="admission_date" id="admission_date" value="{{ old('admission_date', $row->admission_date ?? date('Y-m-d')) }}" required>
                                            <div class="invalid-feedback">
                                              {{ __('required_field') }} {{ __('field_admission_date') }}
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </content>

                        <h3>{{ __('tab_educational_info') }}</h3>
                        <content class="form-step">
                            <fieldset class="row scheduler-border">
                                <legend>{{ __('field_academic_information') }}</legend>
                                <div class="form-group col-md-6">
                                    <label for="student_id">{{ __('field_student_id') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="student_id" id="student_id" value="{{ old('student_id', $row->student_id) }}" required>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_student_id') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="batch">{{ __('field_batch') }} <span>*</span></label>
                                    <select class="form-control" name="batch" id="batch" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($batches as $batch)
                                        <option value="{{ $batch->id }}" @if(old('batch', $row->batch_id) == $batch->id) selected @endif>{{ $batch->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_batch') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="program">{{ __('field_program') }} <span>*</span></label>
                                    <select class="form-control" name="program" id="program" required>
                                      <option value="">{{ __('select') }}</option>
                                      @foreach($programs as $program)
                                        <option value="{{ $program->id }}" @if(old('program', $row->program_id) == $program->id) selected @endif>{{ $program->title }}</option>
                                      @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_program') }}
                                    </div>
                                </div>

                                <!-- Section Field -->
                                <div class="form-group col-md-6">
                                    <label for="section">{{ __('field_section') }} <span>*</span></label>
                                    <select class="form-control" name="section" id="section" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($sections as $section)
                                        <option value="{{ $section->id }}" @if(old('section', $row->section_id) == $section->id) selected @endif>{{ $section->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_section') }}
                                    </div>
                                </div>

                                <!-- Semester Field -->
                                <div class="form-group col-md-6">
                                    <label for="semester">{{ __('field_semester') }} <span>*</span></label>
                                    <select class="form-control" name="semester" id="semester" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" @if(old('semester', $row->semester_id) == $semester->id) selected @endif>{{ $semester->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_semester') }}
                                    </div>
                                </div>

                                <!-- Session Field -->
                                <div class="form-group col-md-6">
                                    <label for="session">{{ __('field_session') }} <span>*</span></label>
                                    <select class="form-control" name="session" id="session" required>
                                        <option value="">{{ __('select') }}</option>
                                        @foreach($sessions as $session)
                                        <option value="{{ $session->id }}" @if(old('session', $row->session_id) == $session->id) selected @endif>{{ $session->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_session') }}
                                    </div>
                                </div>
                            </fieldset>
                        </content>

                        <h3>{{ __('KCSE Results') }}</h3>
                        <content class="form-step">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="kcse_index_no">{{ __('KCSE Index Number') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" value="{{ old('kcse_index_no', $row->kcse_index_no) }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('KCSE Index Number') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kcse_year">{{ __('KCSE Year') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="kcse_year" id="kcse_year" value="{{ old('kcse_year', $row->kcse_year) }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('KCSE Year') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kcse_grade">{{ __('KCSE Grade') }} <span>*</span></label>
                                    <input type="text" class="form-control" name="kcse_grade" id="kcse_grade" value="{{ old('kcse_grade', $row->kcse_grade) }}" required>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('KCSE Grade') }}
                                    </div>
                                </div>
@if($row->status == 1) {{-- Only show for pending applications --}}
    <input type="hidden" name="is_approval" value="1">
@endif
                                <div class="form-group col-md-6">
                                    <label for="kcse_certificate">{{ __('KCSE Certificate') }}</label>
                                    <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate">
                                    @if($row->kcse_certificate)
                                        <a href="{{ asset('uploads/'.$path.'/'.$row->kcse_certificate) }}" target="_blank">{{ __('View Current Certificate') }}</a>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="kcse_result_slip">{{ __('KCSE Result Slip') }}</label>
                                    <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip">
                                    @if($row->kcse_result_slip)
                                        <a href="{{ asset('uploads/'.$path.'/'.$row->kcse_result_slip) }}" target="_blank">{{ __('View Current Result Slip') }}</a>
                                    @endif
                                </div>
                            </div>
                        </content>

                        <h3>{{ __('Location') }}</h3>
                        <content class="form-step">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="county">{{ __('County') }} <span>*</span></label>
                                    <select class="form-control" name="county" id="county" required>
                                        <option value="">{{ __('Select County') }}</option>
                                        @foreach($counties as $county)
                                            <option value="{{ $county->CountyID }}" @if(old('county', $row->county_id) == $county->CountyID) selected @endif>{{ $county->CountyName }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('County') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="sub_county">{{ __('Sub-County') }} <span>*</span></label>
                                    <select class="form-control" name="sub_county" id="sub_county" required>
                                        <option value="">{{ __('Select Sub-County') }}</option>
                                        @foreach($sub_counties as $subCounty)
                                            <option value="{{ $subCounty->SubCountyID }}" @if(old('sub_county', $row->sub_county_id) == $subCounty->SubCountyID) selected @endif>{{ $subCounty->SubCountyName }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Sub-County') }}
                                    </div>
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="mode_of_education">{{ __('Mode of Study') }} <span>*</span></label>
                                    <select class="form-control" name="mode_of_education" id="mode_of_education" required>
                                        <option value="">{{ __('Select Mode of Study') }}</option>
                                        <option value="Physical" @if(old('mode_of_education', $row->mode_of_education) == 'Physical') selected @endif>Physical</option>
                                        <option value="Online" @if(old('mode_of_education', $row->mode_of_education) == 'Online') selected @endif>Online</option>
                                        <option value="Hybrid" @if(old('mode_of_education', $row->mode_of_education) == 'Hybrid') selected @endif>Hybrid</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        {{ __('required_field') }} {{ __('Mode of Study') }}
                                    </div>
                                </div>
                            </div>
                        </content>
                    </form>
                    </div>
                </div>
            </div>
            <!-- [ Card ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
    <!-- validate Js -->
    <script src="{{ asset('dashboard/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>

    <!-- Wizard Js -->
    <script src="{{ asset('dashboard/js/pages/jquery.steps.js') }}"></script>

    <script type="text/javascript">
        "use strict";
        var form = $("#wizard-advanced-form").show();

        form.steps({
            headerTag: "h3",
            bodyTag: "content",
            transitionEffect: "slideLeft",
            labels: 
            {
                finish: "{{ __('btn_finish') }}",
                next: "{{ __('btn_next') }}",
                previous: "{{ __('btn_previous') }}",
            },
            onStepChanging: function (event, currentIndex, newIndex)
            {
                if (currentIndex > newIndex)
                {
                    return true;
                }
                if (currentIndex < newIndex)
                {
                    form.find(".body:eq(" + newIndex + ") label.error").remove();
                    form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
                }
                form.validate().settings.ignore = ":disabled,:hidden";
                return form.valid();
            },
            onStepChanged: function (event, currentIndex, priorIndex)
            {
                
            },
            onFinishing: function (event, currentIndex)
            {
                form.validate().settings.ignore = ":disabled";
                return form.valid();
            },
            onFinished: function (event, currentIndex)
            {
                $("#wizard-advanced-form").submit();
            }
        }).validate({
            errorPlacement: function errorPlacement(error, element) { element.before(error); },
            rules: {

            }
        });

        // County and Sub-county dynamic filtering
        $(document).ready(function() {
            $('#county').on('change', function() {
                var countyId = $(this).val();
                if (countyId) {
                    $.ajax({
                        type: "GET",
                        url: "{{ url('admin/filter/sub-counties') }}/" + countyId,
                        success: function (response) {
                            $('#sub_county').empty();
                            $('#sub_county').append('<option value="">{{ __("select") }}</option>');
                            $.each(response, function(key, value) {
                                $('#sub_county').append('<option value="'+ value.SubCountyID +'">'+ value.SubCountyName +'</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_county').empty();
                    $('#sub_county').append('<option value="">{{ __("select") }}</option>');
                }
            });
        });
    </script>
@endsection