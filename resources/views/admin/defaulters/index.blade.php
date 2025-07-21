@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
<style>
    /* Make buttons responsive */
    .dt-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0rem;
        margin-bottom: 1rem;
    }

    .dt-button {
        padding: 7rem 10rem;
        border-radius: 7px;
        background-color: #4e73df;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 0.875rem;
        transition: background-color 0.3s;
    }

    .dt-button:hover {
        background-color: #2e59d9;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .dt-buttons {
            justify-content: center;
        }
        
        .dt-button {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 576px) {
        .dt-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .dt-button {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }

    .chart-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
        margin-bottom: 30px;
    }

    .chart-box {
        flex: 1;
        min-width: 300px;
        background: white;
        padding: 15px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .total-amount {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 1.2rem;
        font-weight: bold;
        text-align: center;
    }
</style>
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endsection

@section('content')
<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>{{ $title }}</h5>
                        <div>
                            <a href="{{ route($route.'.export', request()->all()) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-file-export"></i> Export All Defaulters
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route($route.'.index') }}" method="get">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="faculty">{{ __('Faculty') }}</label>
                                        <select class="form-control select2" name="faculty" id="faculty">
                                            <option value="">{{ __('All') }}</option>
                                            @foreach($faculties as $faculty)
                                            <option value="{{ $faculty->id }}" @if(request('faculty') == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="program">{{ __('Program') }}</label>
                                        <select class="form-control select2" name="program" id="program">
                                            <option value="">{{ __('All') }}</option>
                                            @foreach($programs as $program)
                                                <option value="{{ $program->id }}" @if(request('program') == $program->id) selected @endif>{{ $program->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="semester">{{ __('Semester') }}</label>
                                        <select class="form-control select2" name="semester" id="semester">
                                            <option value="">{{ __('All') }}</option>
                                            @foreach($semesters as $semester)
                                            <option value="{{ $semester->id }}" @if(request('semester') == $semester->id) selected @endif>{{ $semester->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="search">{{ __('Search') }}</label>
                                        <input type="text" class="form-control" name="search" id="search" value="{{ request('search') }}" placeholder="Student ID/Name">
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                                    <a href="{{ route($route.'.index') }}" class="btn btn-secondary">{{ __('Reset') }}</a>
                                </div>
                            </div>
                        </form>

                        <hr>

                        

                        <!-- Charts Section -->
                        <div class="chart-container">
                            <div class="chart-box">
                                <h5>Defaulters by Faculty</h5>
                                <canvas id="facultyChart" height="250"></canvas>
                            </div>
                            <div class="chart-box">
                                <h5>Defaulters by Program</h5>
                                <canvas id="programChart" height="250"></canvas>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table id="defaultersTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Faculty</th>
                                        <th>Program</th>
                                        <th>Invoice No</th>
                                        <th>Total Fee</th>
                                        <th>Amount Due</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                    @if($row->due_date && date('Y-m-d') > $row->due_date)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->studentEnroll->student->student_id ?? '' }}</td>
                                        <td>
                                            @if($row->studentEnroll->student)
                                                {{ $row->studentEnroll->student->first_name }} {{ $row->studentEnroll->student->last_name }}
                                            @endif
                                        </td>
                                        <td>{{ $row->studentEnroll->program->faculty->title ?? '' }}</td>
                                        <td>{{ $row->studentEnroll->program->title ?? '' }}</td>
                                        <td>{{ $row->invoice_no }}</td>
                                        <td>{{ number_format($row->total_fee, 2) }}</td>
                                        <td>{{ number_format($row->amount_due, 2) }}</td>
                                        <td>
                                            {{ date('d M, Y', strtotime($row->due_date)) }}
                                            <span class="badge badge-danger">Overdue</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-danger">Unpaid</span>
                                        </td>
                                    </tr>
                                    @endif
                                    @endforeach
                                </tbody>
                                <caption>
                             
                            Total Amount Due: {{ number_format($totalAmountDue, 2) }}
                       
                                </caption>
                            </table>
                        </div>
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
    <!-- DataTables -->
    <script src="{{ asset('dashboard/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(function () {
            $('#defaultersTable').DataTable({
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "dom": 'Bfrtip',
                "buttons": ['copy', 'csv', 'excel', 'pdf', 'print']
            });

            // Faculty change event to load programs
            $('#faculty').change(function() {
                var faculty_id = $(this).val();
                var option = '<option value="">{{ __("All") }}</option>';
                
                if(faculty_id != '') {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('admin.get-programs') }}",
                        data: { faculty_id: faculty_id },
                        success: function(data) {
                            if(data.status == true) {
                                $.each(data.programs, function(key, program) {
                                    option += '<option value="'+program.id+'"' + 
                                        (program.id == "{{ request('program') }}" ? ' selected' : '') + 
                                        '>'+program.title+'</option>';
                                });
                            }
                            $('#program').html(option);
                        }
                    });
                } else {
                    $('#program').html(option);
                }
            });

            // Charts
            var facultyData = @json($facultyData);
            var programData = @json($programData);

            // Faculty Chart (Bar)
            var facultyCtx = document.getElementById('facultyChart').getContext('2d');
            var facultyChart = new Chart(facultyCtx, {
                type: 'bar',
                data: {
                    labels: facultyData.labels,
                    datasets: [{
                        label: 'Number of Defaulters',
                        data: facultyData.data,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            precision: 0
                        }
                    }
                }
            });

            // Program Chart (Pie)
            var programCtx = document.getElementById('programChart').getContext('2d');
            var programChart = new Chart(programCtx, {
                type: 'pie',
                data: {
                    labels: programData.labels,
                    datasets: [{
                        data: programData.data,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.7)',
                            'rgba(54, 162, 235, 0.7)',
                            'rgba(255, 206, 86, 0.7)',
                            'rgba(75, 192, 192, 0.7)',
                            'rgba(153, 102, 255, 0.7)',
                            'rgba(255, 159, 64, 0.7)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
        });
    </script>
@endsection