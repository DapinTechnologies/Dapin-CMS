@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <!-- Dashboard Header -->
        <div class="row mb-3">
            <div class="col-sm-12 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold">Examination Dashboard</h5>
                <span class="text-muted" id="live-datetime"></span>
            </div>
        </div>

        <!-- Search Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form class="needs-validation" novalidate method="get" action="{{ route($route . '.index') }}">
                    <div class="row gx-2">
                        <!-- Faculty Filter -->
                        <div class="form-group col-md-4">
                            <label for="faculty">{{ __('Faculty') }}</label>
                            <select class="form-control select2" name="faculty" id="faculty">
                                <option value="">{{ __('All') }}</option>
                                @foreach($faculties as $faculty)
                                    <option value="{{ $faculty->id }}" @if($selected_faculty == $faculty->id) selected @endif>
                                        {{ $faculty->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Program Filter -->
                        <div class="form-group col-md-4">
                            <label for="program">{{ __('Program') }}</label>
                            <select class="form-control select2" name="program" id="program">
                                <option value="">{{ __('All') }}</option>
                                @foreach($programs as $program)
                                    <option value="{{ $program->id }}" @if($selected_program == $program->id) selected @endif>
                                        {{ $program->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Semester Filter -->
                        <div class="form-group col-md-4">
                            <label for="semester">{{ __('Semester') }}</label>
                            <select class="form-control select2" name="semester" id="semester">
                                <option value="">{{ __('All') }}</option>
                                @foreach($semesters as $semester)
                                    <option value="{{ $semester->id }}" @if($selected_semester == $semester->id) selected @endif>
                                        {{ $semester->title }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group col-md-12 text-center mt-3">
                            <button type="submit" class="btn btn-primary btn-filter">
                                <i class="fas fa-search"></i> {{ __('btn_search') }}
                            </button>
                           
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Stat Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Exams Conducted</h6>
                        <h2 class="text-primary">{{ count($exam_routines) }}</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Overall Pass Rate</h6>
                        <h2 class="text-success">{{ $overall_pass_rate }}%</h2>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Pending Exams  for Grading</h6>
                        <h2 class="text-warning">{{ $total_missing_marks }}</h2>
                    </div>
                </div>
            </div>

             <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-body">
                        <h6 class="text-muted">Units Without Exams Schedule</h6>
                        <h2 class="text-warning">{{ $total_missing_cases }}</h2>
                    </div>
                </div>
            </div>

            
        </div>

        <div class="row">
           <!-- Exam Performance Chart -->
<div class="col-md-6">
    <div class="card h-100">
        <div class="card-header">
            <h5>Course Pass Rates</h5>
        </div>
        <div class="card-body">
            <canvas id="programPassRateChart" height="200"></canvas>
        </div>
    </div>
</div>

            <!-- Examination Calendar -->
            <div class="col-md-6">
                <div class="card h-100 shadow-sm rounded-3">
                    <div class="card-header bg-light border-bottom">
                        <h5 class="mb-0">Upcoming Exams</h5>
                    </div>
                    <div class="card-body p-3">
                        <div id='examCalendar'></div>
                        <div class="mt-3">
    <!-- Toggle Button for Exams -->
    <button 
        class="btn btn-sm btn-outline-primary mb-2 d-flex align-items-center" 
        type="button" 
        data-bs-toggle="collapse" 
        data-bs-target="#examListCollapse" 
        aria-expanded="false" 
        aria-controls="examListCollapse"
    >
        <i class="fas fa-calendar-day me-2"></i>
        Upcoming Exams ({{ count($exam_routines) }})
        <i class="fas fa-chevron-right ms-auto transition-all"></i>
    </button>

    <!-- Collapsible Exam List -->
    <div class="collapse" id="examListCollapse">
        <ul class="list-group">
            @forelse($exam_routines as $exam)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $exam['title'] }}
                    <span class="badge bg-primary rounded-pill">
                        {{ \Carbon\Carbon::parse($exam['start'])->format('M d') }}
                    </span>
                </li>
            @empty
                <li class="list-group-item">No upcoming exams</li>
            @endforelse
        </ul>
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>

           <div class="row">
    <!-- Student Feedback -->
    <div class="col-md-6 mt-4">
        <div class="card">
            <div class="card-header"><h5>Student General Feedback</h5></div>
            <div class="card-body text-center">
                <h6>Satisfaction</h6>
                <div class="position-relative d-inline-block" style="width: 100px; height: 100px;">
                    <canvas id="satisfactionChart"></canvas>
                    <div class="position-absolute top-50 start-50 translate-middle fs-5 fw-bold">85%</div>
                </div>
                <p class="text-muted mt-3">Dissatisfaction Rate: 15%</p>
            </div>
        </div>
    </div>

    <!-- Exam Fee Payment -->
    <div class="col-md-6 mt-4">
        <div class="card">
            <div class="card-header"><h5>Exam Fee Payment Report</h5></div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between">
                        February <span class="badge bg-success">KES 3,000 received</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        March <span class="badge bg-warning">KES 500 pending</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        Exam Fee Payment <span class="badge bg-success">KES 500 received</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        March <span class="badge bg-warning">1000 pending</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

       @if(isset($program_stats) && count($program_stats) > 0)
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Results Summary</h5>
            <div class="col-md-3">
                <input type="text" id="searchInput" class="form-control" placeholder="Search...">
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="resultsTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Program Name</th>
                            <th>CAT 1 Avg</th>
                            <th>CAT 2 Avg</th>
                            <th>Mock Exam Avg</th>
                            <th>Passed Students</th>
                            <th>Total Students</th>
                            <th>Pass Rate</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($program_stats as $program)
                            <tr>
                                <td>{{ $program['program_name'] }}</td>
                                <td>{{ $program['cat1_avg'] }}</td>
                                <td>{{ $program['cat2_avg'] }}</td>
                                <td>{{ $program['mock_avg'] }}</td>
                                <td>{{ $program['passed_students'] }}</td>
                                <td>{{ $program['total_students'] }}</td>
                                <td>{{ $program['pass_rate'] }}%</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4">Overall Statistics</th>
                            <th>{{ $total_passing_students }}</th>
                            <th>{{ $total_students }}</th>
                            <th>{{ $overall_pass_rate }}%</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@else
    <div class="alert alert-info">No exam data available for the selected filters.</div>
@endif
    </div>
</div>
@if($missing_marks_students->count() > 0)
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">Students with Missing Marks (Unit-wise)</h5>
        <div class="col-md-3">
            <input type="text" id="missingMarksSearch" class="form-control" placeholder="Search...">
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="missingMarksTable">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Program</th>
                        <th>Semester</th>
                        <th>Subject</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($missing_marks_students as $student)
                    <tr>
                        <td>{{ $student['roll_no'] }}</td>
                        <td>{{ $student['first_name'] }} {{ $student['last_name'] }}</td>
                        <td>{{ $student['program_name'] }}</td>
                        <td>{{ $student['semester_name'] }}</td>
                        <td>{{ $student['subject_name'] }} ({{ $student['subject_code'] }})</td>
                        <td>
                            <span class="badge badge-{{ $student['status'] == 'No Exams' ? 'warning' : 'danger' }}">
                                {{ $student['status'] }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-header">
        <h5 class="card-title">Students with Missing Marks</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">No students found with missing marks for any subjects.</div>
    </div>
</div>
@endif
<!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css' rel='stylesheet' />
<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js'></script>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Initialize FullCalendar
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('examCalendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 300,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: @json($exam_routines)
        });
        calendar.render();
    });

    
    // Update Faculty Programs when Faculty changes
    $('#faculty').change(function() {
        var faculty_id = $(this).val();
        $.ajax({
            url: "{{ route($route.'.index') }}",
            type: "GET",
            data: {
                faculty_id: faculty_id
            },
            success: function(data) {
                $('#program').empty();
                $('#program').append('<option value="">{{ __("All") }}</option>');
                $.each(data, function(key, value) {
                    $('#program').append('<option value="'+value.id+'">'+value.title+'</option>');
                });
            }
        });
    });

    // Live DateTime Update
    function updateDateTime() {
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const year = now.getFullYear();

        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;

        const timeString = `${day}/${month}/${year} ${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
        document.getElementById('live-datetime').textContent = timeString;
    }

    setInterval(updateDateTime, 1000);
    updateDateTime();
</script>

<script>
    function updateDateTime() {
        const now = new Date();
        const day = String(now.getDate()).padStart(2, '0');
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are 0-based
        const year = now.getFullYear();

        let hours = now.getHours();
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');
        const ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12; // Convert to 12-hour format

        const timeString = `${day}/${month}/${year} ${String(hours).padStart(2, '0')}:${minutes}:${seconds} ${ampm}`;
        document.getElementById('live-datetime').textContent = timeString;
    }

    setInterval(updateDateTime, 1000); // Update every second
    updateDateTime(); // Initial call
</script>
<script> // Student Satisfaction Doughnut Chart
    new Chart(document.getElementById('satisfactionChart'), {
        type: 'doughnut',
        data: {
            labels: ['Satisfied', 'Dissatisfied'],
            datasets: [{
                data: [85, 15],
                backgroundColor: ['#28a745', '#dc3545'],
                borderWidth: 1
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Program Pass Rate Chart
    new Chart(document.getElementById('programPassRateChart'), {
        type: 'bar',
        data: {
            labels: @json($chart_programs),
            datasets: [
                {
                    label: 'Pass Rate',
                    data: @json($chart_pass_rates),
                    backgroundColor: '#28a745', // Green color for pass rate
                    stack: 'Stack 0'
                },
                {
                    label: 'Fail Rate',
                    data: @json($chart_fail_rates), // Calculated as (100 - pass rate)
                    backgroundColor: '#dc3545', // Red color for fail rate
                    stack: 'Stack 0'
                }
            ]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    stacked: true,
                },
                y: {
                    stacked: true,
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Percentage (%)'
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.raw + '%';
                        }
                    }
                },
                legend: {
                    position: 'top',
                }
            }
        }
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const table = document.getElementById('resultsTable');
    const rows = table.getElementsByTagName('tr');

    searchInput.addEventListener('keyup', function() {
        const searchText = this.value.toLowerCase();
        
        for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
            const row = rows[i];
            const cells = row.getElementsByTagName('td');
            let found = false;
            
            for (let j = 0; j < cells.length; j++) {
                const cellText = cells[j].textContent.toLowerCase();
                if (cellText.includes(searchText)) {
                    found = true;
                    break;
                }
            }
            
            row.style.display = found ? '' : 'none';
        }
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('missingMarksSearch');
    if (searchInput) {
        const table = document.getElementById('missingMarksTable');
        const rows = table.getElementsByTagName('tr');

        searchInput.addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            
            for (let i = 1; i < rows.length; i++) { // Start from 1 to skip header row
                const row = rows[i];
                const cells = row.getElementsByTagName('td');
                let found = false;
                
                for (let j = 0; j < cells.length; j++) {
                    const cellText = cells[j].textContent.toLowerCase();
                    if (cellText.includes(searchText)) {
                        found = true;
                        break;
                    }
                }
                
                row.style.display = found ? '' : 'none';
            }
        });
    }
});
</script>

@endsection