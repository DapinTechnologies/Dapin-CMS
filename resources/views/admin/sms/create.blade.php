@extends('admin.layouts.master')
@section('title', $title)
@section('content')
<!-- resources/views/sms/create.blade.php -->

<div class="container">
    <h1>Send New SMS</h1>

    <div class="row">
        <!-- [ Card ] start -->
        @can($access.'-create')
        <div class="col-sm-12">
            <!-- Navigation Tabs -->
            <ul class="nav nav-tabs" id="smsTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sms/create') || Request::is('sms/send') ? 'active' : '' }}" id="group-tab" data-bs-toggle="tab" href="#group" role="tab" aria-controls="group" aria-selected="true">
                        {{ $title }} > {{ __('tab_group') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Request::is('sms/individual') ? 'active' : '' }}" id="individual-tab" data-bs-toggle="tab" href="#individual" role="tab" aria-controls="individual" aria-selected="false">
                        {{ $title }} > {{ __('tab_individual') }}
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="smsTabContent">
                
                <!-- Group SMS Form -->
                <div class="tab-pane fade show active" id="group" role="tabpanel" aria-labelledby="group-tab">
                    <div class="card">
                        <form class="needs-validation" novalidate action="{{ route('sms.send') }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row gx-2">
                                    <!-- Send to All Students Option -->
                                    <div class="form-group col-md-12">
                                        <label for="all_students">
                                            <input type="checkbox" name="all_students" id="all_students" value="1">
                                            {{ __('Send to All Students') }}
                                        </label>
                                    </div>

                                    <!-- Select Individual Students -->
                                    <div class="form-group col-md-12" id="student-select">
                                        <label for="student">{{ __('field_student') }} <span>*</span></label>
                                        <select class="form-control select2" name="students[]" id="student" multiple>
                                            <option value="">{{ __('select') }}</option>
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" @if(old('students') == $student->id) selected @endif>
                                                    {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Message Input -->
                                    <div class="form-group col-md-12">
                                        <label for="message" class="form-label">{{ __('field_message') }} <span>*</span></label>
                                        <textarea class="form-control" name="message" id="message" rows="4" required>{{ old('message') }}</textarea>
                                        <div class="invalid-feedback">
                                            {{ __('required_field') }} {{ __('field_message') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane"></i> {{ __('btn_send') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Individual SMS Form -->
              <!-- Individual SMS Form -->
<div class="tab-pane fade" id="individual" role="tabpanel" aria-labelledby="individual-tab">
    <div class="card">
        <form class="needs-validation" novalidate action="{{ route('sms.sendIndividual') }}" method="post">
            @csrf
            <div class="card-body">
                <div class="row gx-2">
                    <!-- Select Individual Student -->
                    <div class="form-group col-md-12">
                        <label for="student">{{ __('field_student') }} <span>*</span></label>
                        <select class="form-control select2" name="student_id" id="student" required>
                            <option value="">{{ __('select') }}</option>
                            @foreach($students as $student)
                                <option value="{{ $student->id }}" @if(old('student_id') == $student->id) selected @endif>
                                    {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }} - {{ $student->phone }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- API Key Input -->
                   

                    <!-- Message Input -->
                    <div class="form-group col-md-12">
                        <label for="message" class="form-label">{{ __('field_message') }} <span>*</span></label>
                        <textarea class="form-control" name="message" id="message" rows="4" required>{{ old('message') }}</textarea>
                        <div class="invalid-feedback">
                            {{ __('required_field') }} {{ __('field_message') }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-paper-plane"></i> {{ __('btn_send') }}
                </button>
            </div>
        </form>
    </div>
</div>

            </div>
        </div>
        @endcan
        <!-- [ Card ] end -->
    </div>
</div>

<script>
    // Toggle student select visibility based on 'Send to All Students' checkbox
    document.getElementById('all_students').addEventListener('change', function () {
        const studentSelect = document.getElementById('student-select');
        studentSelect.style.display = this.checked ? 'none' : 'block';
    });
</script>
@endsection
