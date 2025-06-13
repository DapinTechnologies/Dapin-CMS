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
                        <h5>Individual Student Report</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route('admin.result-repo.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-4">
                                    <label for="student_search">{{ __('field_student_id') }} / {{ __('field_name') }}</label>
                                    <select class="form-control select2" name="student_search" id="student_search">
                                        <option value="0">All</option>
                                        @isset($students)
                                            @foreach($students as $student)
                                                <option value="{{ $student->id }}" 
                                                    @if(isset($student_search) && $student_search == $student->id) selected @endif>
                                                    {{ $student->student_id }} - {{ $student->first_name }} {{ $student->last_name }}
                                                </option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="semester">{{ __('field_semester') }}</label>
                                    <select class="form-control" name="semester" id="semester">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" @if($selected_semester == $semester->id) selected @endif>{{ $semester->title }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
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
                        <a href="{{ route('admin.result-repo.index') }}" class="btn btn-info">
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
                                        <th>{{ __('field_semester') }}</th>
                                        <th>{{ __('field_subject') }}</th>
                                        <th>CAT 1 (30)</th>
                                        <th>CAT 2 (30)</th>
                                        <th>Mock Exam (40)</th>
                                        <th>{{ __('field_total') }}</th>
                                        <th>Points</th>
                                        <th>{{ __('field_grade') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        // Initialize arrays to store data for the chart
                                        $subjectNames = [];
                                        $cat1MarksArray = [];
                                        $cat2MarksArray = [];
                                        $mockExamMarksArray = [];
                                        $totalMarksArray = [];
                                        $pointsArray = [];
                                    @endphp
                                    
                                    @foreach($rows as $studentEnrollId => $subjects)
                                        @foreach($subjects as $subjectId => $data)
                                            @php
                                                $student = $data['student'] ?? null;
                                                $semester = $data['semester'] ?? null;
                                                $subject = $data['subject'] ?? null;
                                                $exams = $data['exams'] ?? [];

                                                // Initialize marks for each exam type
                                                $cat1Marks = 0;
                                                $cat2Marks = 0;
                                                $mockExamMarks = 0;
                                                
                                                foreach($exams as $exam) {
                                                    $examType = strtolower($exam['exam_type_name'] ?? '');
                                                    if(strpos($examType, 'cat 1') !== false) {
                                                        $cat1Marks = $exam['achieve_marks'];
                                                    } elseif(strpos($examType, 'cat 2') !== false) {
                                                        $cat2Marks = $exam['achieve_marks'];
                                                    } elseif(strpos($examType, 'mock exam') !== false) {
                                                        $mockExamMarks = $exam['achieve_marks'];
                                                    }
                                                }

                                                $totalMarks = $cat1Marks + $cat2Marks + $mockExamMarks;
                                                $maxMarks = 100; // CAT1 (30) + CAT2 (30) + Mock (40) = 100

                                                $percentage = $maxMarks > 0 ? round(($totalMarks / $maxMarks) * 100, 2) : 0;

                                                // Initialize grade defaults
                                            $grade = 'N/A';
                                            $points = 0;

                                            // Calculate grade if grades data exists
                                            if(!empty($grades) && is_iterable($grades)) {
                                                foreach ($grades as $g) {
                                                    // Check both possible grade range formats
                                                    if (($percentage >= ($g->min_mark ?? 0)) && 
                                                        ($percentage <= ($g->max_mark ?? 100))) {
                                                        $grade = $g->name ?? $g->grade ?? $g->title ?? 'N/A';
                                                        $points = $g->point ?? $g->points ?? $g->grade_point ?? 0;
                                                        break;
                                                    }
                                                }
                                            }
                                                
                                                // Store data for the chart
                                                $subjectNames[] = $subject->name ?? ($subject->title ?? 'N/A');
                                                $cat1MarksArray[] = $cat1Marks;
                                                $cat2MarksArray[] = $cat2Marks;
                                                $mockExamMarksArray[] = $mockExamMarks;
                                                $totalMarksArray[] = $totalMarks;
                                                $pointsArray[] = $points;
                                            @endphp

                                            <tr>
                                                <td>{{ $semester->title ?? 'N/A' }}</td>
                                                <td>{{ $subject->name ?? ($subject->title ?? 'N/A') }}</td>
                                                <td>{{ $cat1Marks }}</td>
                                                <td>{{ $cat2Marks }}</td>
                                                <td>{{ $mockExamMarks }}</td>
                                                <td>{{ $totalMarks }}</td>
                                                <td>{{ $points }}</td>
                                                 <td>
                                                {{ $grade }}
                                               
                                            </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Performance Graph Section -->
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h4>Performance Overview</h4>
                                <div class="chart-container" style="position: relative; height:400px; width:100%">
                                    <canvas id="performanceChart"></canvas>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Include Chart.js -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var ctx = document.getElementById('performanceChart').getContext('2d');
                                var performanceChart = new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: @json($subjectNames),
                                        datasets: [
                                            {
                                                label: 'CAT 1 Marks',
                                                data: @json($cat1MarksArray),
                                                backgroundColor: 'rgba(255, 99, 132, 0.7)',
                                                borderColor: 'rgba(255, 99, 132, 1)',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'CAT 2 Marks',
                                                data: @json($cat2MarksArray),
                                                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                                                borderColor: 'rgba(54, 162, 235, 1)',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Mock Exam Marks',
                                                data: @json($mockExamMarksArray),
                                                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                                                borderColor: 'rgba(75, 192, 192, 1)',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Total Marks',
                                                data: @json($totalMarksArray),
                                                backgroundColor: 'rgba(153, 102, 255, 0.7)',
                                                borderColor: 'rgba(153, 102, 255, 1)',
                                                borderWidth: 1
                                            },
                                            {
                                                label: 'Points',
                                                data: @json($pointsArray),
                                                backgroundColor: 'rgba(255, 159, 64, 0.7)',
                                                borderColor: 'rgba(255, 159, 64, 1)',
                                                borderWidth: 1,
                                                type: 'line',
                                                fill: false,
                                                yAxisID: 'y1'
                                            }
                                        ]
                                    },
                                    options: {
                                        responsive: true,
                                        maintainAspectRatio: false,
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                max: 100,
                                                title: {
                                                    display: true,
                                                    text: 'Marks'
                                                }
                                            },
                                            y1: {
                                                position: 'right',
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Points'
                                                },
                                                grid: {
                                                    drawOnChartArea: false
                                                }
                                            }
                                        },
                                        plugins: {
                                            title: {
                                                display: true,
                                                text: 'Student Performance Across Subjects'
                                            },
                                            tooltip: {
                                                callbacks: {
                                                    label: function(context) {
                                                        return context.dataset.label + ': ' + context.raw;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                        <script>
                            $(document).ready(function() {
                                $('#student_search').select2({
                                    placeholder: "Search by ID or Name",
                                    allowClear: true,
                                    width: '100%'
                                });
                            });
                        </script>
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