@extends('admin.layouts.master')
@section('title', $title)

@section('content')
@php
use App\Models\Session;
use App\Models\Semester;
use App\Models\Section;

$sessions = Session::where('status', 1)->get();
$semesters = Semester::where('status', 1)->get();
$sections = Section::where('status', 1)->get();

$selectedStatuses = [];
if (isset($student) && $student) {
    if (!$student->relationLoaded('statusTypes')) {
        $student->load('statusTypes');
    }
    $selectedStatuses = $student->statusTypes->pluck('id')->toArray();
}
@endphp

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ __('modal_edit') }} {{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <a href="{{ route($route.'.index') }}" class="btn btn-primary"><i class="fas fa-arrow-left"></i> {{ __('btn_back') }}</a>
                    </div>

                    <div class="card-block">
                        <!-- SIMPLE FORM WITHOUT WIZARD -->
                        <form class="needs-validation" novalidate action="{{ route($route.'.update', $row->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="registration_no" value="{{ $row->registration_no }}">
                            <input type="hidden" name="national_id" value="{{ $row->national_id }}">
                            @if($row->status == 1)
                                <input type="hidden" name="is_approval" value="1">
                            @endif

                            <div class="row">
                                <!-- Personal Information -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{ __('Personal Information') }}</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="form-group">
                                                <label for="first_name">{{ __('field_first_name') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="first_name" id="first_name" value="{{ old('first_name', $row->first_name) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_first_name') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="last_name">{{ __('field_last_name') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="last_name" id="last_name" value="{{ old('last_name', $row->last_name) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_last_name') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">{{ __('field_phone') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $row->phone) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_phone') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="email">{{ __('field_email') }} <span>*</span></label>
                                                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $row->email) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_email') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="gender">{{ __('field_gender') }} <span>*</span></label>
                                                <select class="form-control" name="gender" id="gender" required>
                                                    <option value="">{{ __('select') }}</option>
                                                    <option value="1" @if(old('gender', $row->gender) == 1) selected @endif>{{ __('gender_male') }}</option>
                                                    <option value="2" @if(old('gender', $row->gender) == 2) selected @endif>{{ __('gender_female') }}</option>
                                                    <option value="3" @if(old('gender', $row->gender) == 3) selected @endif>{{ __('gender_other') }}</option>
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_gender') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="dob">{{ __('field_dob') }} <span>*</span></label>
                                                <input type="date" class="form-control date" name="dob" id="dob" value="{{ old('dob', $row->dob) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_dob') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="admission_date">{{ __('field_admission_date') }} <span>*</span></label>
                                                <input type="date" class="form-control date" name="admission_date" id="admission_date" value="{{ old('admission_date', $student->admission_date ?? date('Y-m-d')) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_admission_date') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="present_address">{{ __('field_present_address') }}</label>
                                                <textarea class="form-control" name="present_address" id="present_address" rows="3">{{ old('present_address', $row->present_address) }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Information -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{ __('Academic Information') }}</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="form-group">
                                                <label for="student_id">{{ __('field_student_id') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="student_id" id="student_id" value="{{ old('student_id', $student->student_id ?? '') }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_student_id') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="batch">{{ __('field_batch') }} <span>*</span></label>
                                                <select class="form-control" name="batch" id="batch" required>
                                                    <option value="">{{ __('select') }}</option>
                                                    @foreach($batches as $batch)
                                                    <option value="{{ $batch->id }}" @if(old('batch', $row->batch_id) == $batch->id) selected @endif>{{ $batch->title }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_batch') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="program">{{ __('field_program') }} <span>*</span></label>
                                                <select class="form-control" name="program" id="program" required>
                                                    <option value="">{{ __('select') }}</option>
                                                    @foreach($programs as $program)
                                                    <option value="{{ $program->id }}" @if(old('program', $row->program_id) == $program->id) selected @endif>{{ $program->title }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_program') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="section">{{ __('field_section') }} <span>*</span></label>
                                                <select class="form-control" name="section" id="section" required>
                                                    <option value="">{{ __('select') }}</option>
                                                    @foreach($sections as $section)
                                                    <option value="{{ $section->id }}" @if(old('section', $row->section_id) == $section->id) selected @endif>{{ $section->title }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_section') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="semester">{{ __('field_semester') }} <span>*</span></label>
                                                <select class="form-control" name="semester" id="semester" required>
                                                    <option value="">{{ __('select') }}</option>
                                                    @foreach($semesters as $semester)
                                                    <option value="{{ $semester->id }}" @if(old('semester', $row->semester_id) == $semester->id) selected @endif>{{ $semester->title }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_semester') }}</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="session">{{ __('field_session') }} <span>*</span></label>
                                                <select class="form-control" name="session" id="session" required>
                                                    <option value="">{{ __('select') }}</option>
                                                    @foreach($sessions as $session)
                                                    <option value="{{ $session->id }}" @if(old('session', $row->session_id) == $session->id) selected @endif>{{ $session->title }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} {{ __('field_session') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- KCSE Information -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{ __('KCSE Results') }}</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="form-group">
                                                <label for="kcse_index_no">{{ __('KCSE Index Number') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="kcse_index_no" id="kcse_index_no" value="{{ old('kcse_index_no', $row->kcse_index_no) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} KCSE Index Number</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kcse_year">{{ __('KCSE Year') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="kcse_year" id="kcse_year" value="{{ old('kcse_year', $row->kcse_year) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} KCSE Year</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kcse_grade">{{ __('KCSE Grade') }} <span>*</span></label>
                                                <input type="text" class="form-control" name="kcse_grade" id="kcse_grade" value="{{ old('kcse_grade', $row->kcse_grade) }}" required>
                                                <div class="invalid-feedback">{{ __('required_field') }} KCSE Grade</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="kcse_certificate">{{ __('KCSE Certificate') }}</label>
                                                <input type="file" class="form-control" name="kcse_certificate" id="kcse_certificate">
                                                @if($row->kcse_certificate)
                                                    <a href="{{ asset('storage/'.$row->kcse_certificate) }}" target="_blank" class="btn btn-sm btn-info mt-1">{{ __('View Current Certificate') }}</a>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="kcse_result_slip">{{ __('KCSE Result Slip') }}</label>
                                                <input type="file" class="form-control" name="kcse_result_slip" id="kcse_result_slip">
                                                @if($row->kcse_result_slip)
                                                    <a href="{{ asset('storage/'.$row->kcse_result_slip) }}" target="_blank" class="btn btn-sm btn-info mt-1">{{ __('View Current Result Slip') }}</a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Location & Status -->
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5>{{ __('Location & Status') }}</h5>
                                        </div>
                                        <div class="card-block">
                                            <div class="form-group">
                                                <label for="county">{{ __('County') }} <span>*</span></label>
                                                <select class="form-control" name="county" id="county" required>
                                                    <option value="">{{ __('Select County') }}</option>
                                                    @foreach($counties as $county)
                                                        <option value="{{ $county->CountyID }}" @if(old('county', $row->county_id) == $county->CountyID) selected @endif>{{ $county->CountyName }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} County</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="sub_county">{{ __('Sub-County') }} <span>*</span></label>
                                                <select class="form-control" name="sub_county" id="sub_county" required>
                                                    <option value="">{{ __('Select Sub-County') }}</option>
                                                    @foreach($sub_counties as $subCounty)
                                                        <option value="{{ $subCounty->SubCountyID }}" @if(old('sub_county', $row->sub_county_id) == $subCounty->SubCountyID) selected @endif>{{ $subCounty->SubCountyName }}</option>
                                                    @endforeach
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} Sub-County</div>
                                            </div>

                                            <div class="form-group">
                                                <label for="status_types">{{ __('field_status') }}</label>
                                                <select class="form-control" name="status_types[]" id="status_types" multiple>
                                                    @foreach($statusTypes as $status)
                                                        <option value="{{ $status->id }}" @if(in_array($status->id, $selectedStatuses)) selected @endif>{{ $status->title }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="mode_of_education">{{ __('Mode of Study') }} <span>*</span></label>
                                                <select class="form-control" name="mode_of_education" id="mode_of_education" required>
                                                    <option value="">{{ __('Select Mode of Study') }}</option>
                                                    <option value="Physical" @if(old('mode_of_education', $row->mode_of_study) == 'Physical') selected @endif>Physical</option>
                                                    <option value="Online" @if(old('mode_of_education', $row->mode_of_study) == 'Online') selected @endif>Online</option>
                                                    <option value="Hybrid" @if(old('mode_of_education', $row->mode_of_study) == 'Hybrid') selected @endif>Hybrid</option>
                                                </select>
                                                <div class="invalid-feedback">{{ __('required_field') }} Mode of Study</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class="fas fa-check"></i> {{ __('Approve Application & Create Student') }}
                                </button>
                                <a href="{{ route($route.'.index') }}" class="btn btn-danger">{{ __('btn_cancel') }}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Content-->

<script>
// County and Sub-county dynamic filtering
document.addEventListener('DOMContentLoaded', function() {
    const countySelect = document.getElementById('county');
    const subCountySelect = document.getElementById('sub_county');

    if (countySelect) {
        countySelect.addEventListener('change', function() {
            const countyId = this.value;
            
            if (countyId) {
                fetch(`/admin/filter/sub-counties/${countyId}`)
                    .then(response => response.json())
                    .then(data => {
                        subCountySelect.innerHTML = '<option value="">{{ __("select") }}</option>';
                        data.forEach(subCounty => {
                            const option = document.createElement('option');
                            option.value = subCounty.SubCountyID;
                            option.textContent = subCounty.SubCountyName;
                            subCountySelect.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error loading sub-counties:', error);
                    });
            } else {
                subCountySelect.innerHTML = '<option value="">{{ __("select") }}</option>';
            }
        });
    }

    // Form validation
    const forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form) {
        form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
</script>

@endsection