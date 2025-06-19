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
                        <h5>All Exam Attendance</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <!-- Faculty Filter -->
                                <div class="form-group col-md-3">
                                    <label for="faculty">{{ __('field_faculty') }}</label>
                                    <select class="form-control select2" name="faculty" id="faculty">
                                        <option value="0">All</option>
                                        @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}" @if($selected_faculty == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Program Filter -->
                                <div class="form-group col-md-3">
                                    <label for="program">{{ __('field_program') }}</label>
                                    <select class="form-control select2" name="program" id="program">
                                        <option value="">All</option>
                                        @if(isset($programs))
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" @if($selected_program == $program->id) selected @endif>{{ $program->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Semester Filter -->
                                <div class="form-group col-md-3">
                                    <label for="semester">{{ __('field_semester') }}</label>
                                    <select class="form-control select2" name="semester" id="semester">
                                        <option value="">All</option>
                                        @if(isset($semesters))
                                            @foreach($semesters as $semester)
                                                <option value="{{ $semester->id }}" @if($selected_semester == $semester->id) selected @endif>{{ $semester->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <!-- Exam Type Filter -->
                                <div class="form-group col-md-3">
                                    <label for="type">{{ __('field_type') }}</label>
                                    <select class="form-control select2" name="type" id="type">
                                        <option value="0">All</option>
                                        @foreach($types as $type)
                                            <option value="{{ $type->id }}" @if($selected_type == $type->id) selected @endif>{{ $type->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_search') }}</button>
                                </div>
                            </div>
                        </form>

                        @if(count($attendances) > 0)
                        <div class="card-footer">
                            <button type="button" class="btn btn-dark btn-print">
                                <i class="fas fa-print"></i> {{ __('btn_print') }}
                            </button>
                            <button type="button" class="btn btn-primary btn-export">
                                <i class="fas fa-file-export"></i> {{ __('btn_export') }}
                            </button>
                        </div>
                        @endif

                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table class="display table nowrap table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('field_subject') }}</th>
                                        <th>Exam Type</th>
                                        <th>Exam Date</th>
                                        <th>Total Student</th>
                                        <th>Total Attended</th>
                                        <th>Total Absent</th>
                                        <th>Attendance Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Group attendance data by subject, date, and exam type
                                        $groupedAttendances = [];
                                        foreach($attendances as $attendance) {
                                            $key = $attendance->subject->code.'-'.$attendance->date.'-'.$attendance->exam_type_id;
                                            if (!isset($groupedAttendances[$key])) {
                                                $groupedAttendances[$key] = [
                                                    'subject_code' => $attendance->subject->code ?? '',
                                                    'subject_name' => $attendance->subject->title ?? '',
                                                    'type' => $attendance->exam_type_data->title ?? '',

                                                    'date' => $attendance->date ?? '',
                                                    'total' => 0,
                                                    'attended' => 0,
                                                    'absent' => 0
                                                ];
                                            }
                                            $groupedAttendances[$key]['total']++;
                                            if($attendance->attendance == 1) {
                                                $groupedAttendances[$key]['attended']++;
                                            } else {
                                                $groupedAttendances[$key]['absent']++;
                                            }
                                        }
                                    @endphp

                                    @forelse($groupedAttendances as $attendance)
                                    <tr>
                                        <td>{{ $attendance['subject_code'] }} - {{ $attendance['subject_name'] }}</td>
                                        <td>{{ $attendance['type'] }}</td>
                                        <td>{{ $attendance['date'] }}</td>
                                        <td>{{ $attendance['total'] }}</td>
                                        <td>{{ $attendance['attended'] }}</td>
                                        <td>{{ $attendance['absent'] }}</td>
                                        <td>
                                            @if($attendance['total'] > 0)
                                                {{ round(($attendance['attended'] / $attendance['total']) * 100, 2) }}%
                                            @else
                                                0%
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">{{ __('no_results_found') }}</td>
                                    </tr>
                                    @endforelse
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
@endsection

@section('page_js')
<script type="text/javascript">
    "use strict";
    $(document).ready(function() {
        // Initialize select2
        $('.select2').select2({
            placeholder: "{{ __('select_option') }}",
            allowClear: true
        });

        // Print button functionality
        $('.btn-print').click(function() {
            window.print();
        });
    });
</script>
@endsection
