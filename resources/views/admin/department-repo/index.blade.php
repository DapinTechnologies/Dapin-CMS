@extends('admin.layouts.master') 

@section('title', $title)

@section('content')
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">

            {{-- Filter Form --}}
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header"><h5>Department Summary</h5></div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route . '.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-4">
                                    <label for="faculty">{{ __('field_faculty') }}</label>
                                    <select class="form-control" name="faculty" id="faculty">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}" 
                                                @if($selected_faculty == $faculty->id) selected @endif>
                                                {{ $faculty->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="program">{{ __('field_program') }}</label>
                                    <select class="form-control" name="program" id="program">
                                        <option value="">{{ __('all') }}</option>
                                        @isset($programs)
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" 
                                                    @if($selected_program == $program->id) selected @endif>
                                                    {{ $program->title }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>
                               

                                <div class="form-group col-md-4">
                                    <label for="teacher">{{ __('field_teacher') }}</label>
                                    <select class="form-control select2" name="teacher" id="teacher">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($teachers as $teacher)
                                            <option value="{{ $teacher->id }}" 
                                                @if($selected_teacher == $teacher->id) selected @endif>
                                                {{ $teacher->first_name }} {{ $teacher->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="exam_type">{{ __('field_type') }}</label>
                                    <select class="form-control" name="exam_type" id="exam_type">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($exam_types as $type)
                                            <option value="{{ $type->id }}" 
                                                @if($selected_exam_type == $type->id) selected @endif>
                                                {{ $type->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info mt-4">
                                        <i class="fas fa-search"></i> {{ __('btn_search') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

          @if(count($rows) > 0)
<div class="col-sm-12 mb-4">
    <div class="row">
        {{-- Total Teachers Card --}}
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-left-primary shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #e6f3ff 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Trainers</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $uniqueTeachers = collect($rows)->unique('teacher.id')->count();
                                @endphp
                                {{ $uniqueTeachers }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Average Pass Rate Card --}}
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-left-success shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #e6f8f0 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Average Pass Rate</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                @php
                                    $totalPassRate = collect($rows)->avg('pass_rate');
                                @endphp
                                {{ round($totalPassRate, 2) }}%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-percentage fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Best Performing Teacher Card --}}
        <div class="col-md-3 mb-3 mb-md-0">
            <div class="card border-left-info shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #e6f6ff 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Best Performing Trainer</div>
                            @php
                                $bestTeacher = collect($rows)->groupBy('teacher.id')->map(function($courses) {
                                    return [
                                        'teacher' => $courses->first()['teacher'],
                                        'avg_pass_rate' => $courses->avg('pass_rate'),
                                        'total_courses' => $courses->count()
                                    ];
                                })->sortByDesc('avg_pass_rate')->first();
                            @endphp
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $bestTeacher['teacher']->name ?? 'N/A' }} ({{ round($bestTeacher['avg_pass_rate'] ?? 0, 2) }}%)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trophy fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Lowest Performing Teacher Card --}}
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2" style="background: linear-gradient(to right, #f8f9fc 0%, #fff8e6 100%);">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Lowest Performing Trainer</div>
                            @php
                                $worstTeacher = collect($rows)->groupBy('teacher.id')->map(function($courses) {
                                    return [
                                        'teacher' => $courses->first()['teacher'],
                                        'avg_pass_rate' => $courses->avg('pass_rate'),
                                        'total_courses' => $courses->count()
                                    ];
                                })->sortBy('avg_pass_rate')->first();
                            @endphp
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{ $worstTeacher['teacher']->name ?? 'N/A' }} ({{ round($worstTeacher['avg_pass_rate'] ?? 0, 2) }}%)
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
            {{-- Report Table --}}
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route($route . '.index') }}" class="btn btn-info">
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
                                        <th>Trainer</th>
                                        <th>{{ __('field_type') }}</th>
                                        <th>{{ __('field_subject') }}</th>
                                        <th>Total Students</th>
                                        <th>Passed</th>
                                        <th>Failed</th>
                                        <th>Pass Rate (%)</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $row)
                                        <tr>
                                            <td>{{ $row['teacher']->name ?? 'N/A' }}</td>
                                            <td>{{ $row['exam_type'] ?? 'N/A' }}</td>
                                            <td>{{ $row['subject']->name ?? 'N/A' }} ({{ $row['subject']->code ?? '' }})</td>
                                            <td>{{ $row['total_students'] }}</td>
                                            <td>{{ $row['passed'] }}</td>
                                            <td>{{ $row['failed'] }}</td>
                                            <td>{{ $row['pass_rate'] }}%</td>
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