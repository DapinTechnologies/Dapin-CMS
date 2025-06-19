@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Top Students by Program</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.result2-repo.index') }}">
    <div class="row gx-2">
        <div class="form-group col-md-3">
            <label for="faculty">{{ __('field_faculty') }}</label>
            <select class="form-control" name="faculty" id="faculty">
                <option value="">{{ __('all') }}</option>
                @foreach($faculties as $faculty)
                <option value="{{ $faculty->id }}" @if($selected_faculty == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="program">{{ __('field_program') }}</label>
            <select class="form-control" name="program" id="program">
                <option value="">{{ __('all') }}</option>
                @if(isset($selected_faculty))
                    @foreach($programs->where('faculty_id', $selected_faculty) as $program)
                    <option value="{{ $program->id }}" @if($selected_program == $program->id) selected @endif>{{ $program->title }}</option>
                    @endforeach
                @else
                    @foreach($programs as $program)
                    <option value="{{ $program->id }}" @if($selected_program == $program->id) selected @endif>{{ $program->title }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        <div class="form-group col-md-3">
            <label for="semester">{{ __('field_semester') }}</label>
            <select class="form-control" name="semester" id="semester">
                <option value="">{{ __('all') }}</option>
                @foreach($semesters as $semester)
                <option value="{{ $semester->id }}" @if($selected_semester == $semester->id) selected @endif>{{ $semester->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-3">
            <button type="submit" class="btn btn-info btn-filter mt-4">
                <i class="fas fa-search"></i> {{ __('btn_search') }}
            </button>
        </div>
    </div>
</form>
                    </div>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('admin.result2-repo.index') }}" class="btn btn-info">
                            <i class="fas fa-sync-alt"></i> {{ __('btn_refresh') }}
                        </a>
                        <button type="button" class="btn btn-dark btn-print">
                            <i class="fas fa-print"></i> {{ __('btn_print') }}
                        </button>
                    </div>

                    <div class="card-block">
                        @if(count($rows) > 0)
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover printable">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Student Name</th>
                                        <th>Course</th>
                                        <th>Average Grade</th>
                                        <th>Performance Trend</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $index => $row)
                                        <tr>
                                            <td>
                                                @if($index + 1 == 1)
                                                    <span class="badge bg-warning text-dark" style="background: linear-gradient(to right, #FFD700, #D4AF37) !important;">
                                                        <i class="fas fa-trophy"></i> 1st
                                                    </span>
                                                @elseif($index + 1 == 2)
                                                    <span class="badge bg-secondary" style="background: linear-gradient(to right, #C0C0C0, #A8A8A8) !important;">
                                                        <i class="fas fa-medal"></i> 2nd
                                                    </span>
                                                @elseif($index + 1 == 3)
                                                    <span class="badge bg-danger" style="background: linear-gradient(to right, #CD7F32, #B87333) !important;">
                                                        <i class="fas fa-award"></i> 3rd
                                                    </span>
                                                @else
                                                    {{ $index + 1 }}
                                                @endif
                                            </td>
                                        <td>
    <div class="d-flex align-items-center">
        @php
            // Default avatar path
            $photoPath = asset('dashboard/images/user/avatar-2.jpg');
            
            // If student has photo
            if ($row['student']->photo) {
                if (Str::startsWith($row['student']->photo, 'http')) {
                    $photoPath = $row['student']->photo;
                } else {
                    $photoPath = asset('storage/' . ltrim($row['student']->photo, '/'));
                }
            }
        @endphp
        
        <div class="student-avatar me-2">
            <img src="{{ $photoPath }}" 
                 class="rounded-circle" 
                 alt="{{ $row['student']->first_name }}"
                 onerror="this.onerror=null;this.src='{{ asset('dashboard/images/user/avatar-2.jpg') }}'">
        </div>
        <div>
            {{ $row['student']->first_name }} {{ $row['student']->last_name }}
            @if(!$row['student']->photo)
                <small class="text-muted d-block">No photo uploaded</small>
            @endif
        </div>
    </div>
</td>
                                            <td>
                                                {{ $row['program']->title }}
                                                @php
                                                    $percentage = $row['total_marks'];
                                                    $color = 'bg-danger'; // red by default
                                                    if ($percentage >= 70) {
                                                        $color = 'bg-success'; // green
                                                    } elseif ($percentage >= 40) {
                                                        $color = 'bg-warning'; // yellow
                                                    }
                                                @endphp
                                                <div class="progress mt-2" style="height: 10px;">
                                                    <div class="progress-bar {{ $color }}" role="progressbar" style="width: {{ $percentage }}%;" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                               
                                            </td>
                                            <td>{{ $row['total_marks'] }}%</td>
                                            <td>
    <a href="{{ route('admin.result-repo.index') }}" class="btn btn-sm btn-primary">
        <i class="fas fa-file-alt"></i> View Results
    </a>
</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @else
                        <div class="card-block">
                            <h5>{{ __('no_result_found') }}</h5>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection