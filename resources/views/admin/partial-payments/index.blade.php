@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* Make buttons responsive */
        .dt-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .dt-button {
            padding: 0.5rem 1rem;
            border-radius: 4px;
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
        
        .summary-card {
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .summary-card h3 {
            font-size: 24px;
            color: #4e73df;
            margin-bottom: 10px;
        }
        
        .summary-card p {
            font-size: 16px;
            color: #666;
        }
        
        .chart-container {
            background: #fff;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        
        .chart-title {
            font-size: 18px;
            margin-bottom: 15px;
            color: #333;
            text-align: center;
        }
    </style>
    
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dashboard/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
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
                                <i class="fas fa-file-export"></i> Export All Partial Payments
                            </a>
                        </div>
                    </div>
                    
                    <!-- Total Amount Display -->
                    
                    
                    <div class="card-body">
                        <form id="filterForm" action="{{ route($route.'.index') }}" method="get">
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

                        <!-- Charts Row -->
                        <div class="row mb-4">
                            <!-- Pie Chart for Payment Methods -->
                            <div class="col-md-6">
                                <div class="chart-container" style="height: 400px; position: relative;">
                                    <h4 class="chart-title">Payment Methods Distribution</h4>
                                    <canvas id="paymentMethodsChart" style="width: 100%; height: 100%;"></canvas>
                                </div>
                            </div>
                            
                            <!-- Bar Chart for Faculty Performance -->
                            <div class="col-md-6">
                                <div class="chart-container" style="height: 400px; position: relative;">
                                    <h4 class="chart-title">Partial Payments by Faculty</h4>
                                    <canvas id="facultyPerformanceChart" style="width: 100%; height: 100%;"></canvas>
                                </div>
                            </div>
                        </div>

                        <hr>

                        <div class="table-responsive">
                            <table id="partialPaymentsTable" class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>Student Name</th>
                                        <th>Program</th>
                                        <th>Invoice No</th>
                                        <th>Amount Paid</th>
                                        <th>Payment Method</th>
                                        <th>Transaction ID</th>
                                        <th>Payment Date</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($rows as $key => $row)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->studentEnroll->student->student_id ?? '' }}</td>
                                        <td>
                                            @if($row->studentEnroll->student)
                                                {{ $row->studentEnroll->student->first_name }} {{ $row->studentEnroll->student->last_name }}
                                            @endif
                                        </td>
                                        <td>{{ $row->studentEnroll->program->title ?? '' }}</td>
                                        <td>{{ $row->invoice->invoice_no ?? 'N/A' }}</td>
                                        <td>{{ number_format($row->amount, 2) }}</td>
                                        <td>{{ $row->payment_method ?? 'N/A' }}</td>
                                        <td>{{ $row->transaction_id ?? 'N/A' }}</td>
                                        <td>
                                            @if($row->paid_at)
                                                {{ date('d M, Y', strtotime($row->paid_at)) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-warning">Partial Payment</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <caption>
                                    
                        
                            


                            <div class="total-fees-box" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%); padding: 16px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #4a6cf7; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h5 style="margin: 0; font-family: 'Segoe UI', Roboto, sans-serif; color: #2d3748; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
            <span>
                Total Partial Payments Amount
                <strong style="color: #4a6cf7; font-weight: 700;">
                    {{ number_format($totalPartialAmount, 2) }}
                    {!! $setting->currency_symbol ?? 'KSh' !!}
                </strong>
            </span>
            
        </h5>
    </div>
                       
                    
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
            // Initialize DataTable with server-side processing disabled
            var table = $('#partialPaymentsTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true, // Disable DataTables search since we have our own
                "ordering": true,
                "info": true,
                "responsive": false,
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "pageLength": 25
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
            
            // Payment Methods Pie Chart
            var paymentMethodsData = @json($paymentMethodsData);
            var paymentMethodsLabels = paymentMethodsData.map(item => item.payment_method || 'Unknown');
            var paymentMethodsValues = paymentMethodsData.map(item => item.total_amount);
            
            var paymentMethodsCtx = document.getElementById('paymentMethodsChart').getContext('2d');
            var paymentMethodsChart = new Chart(paymentMethodsCtx, {
                type: 'pie',
                data: {
                    labels: paymentMethodsLabels,
                    datasets: [{
                        data: paymentMethodsValues,
                        backgroundColor: [
                            '#4e73df',
                            '#1cc88a',
                            '#36b9cc',
                            '#f6c23e',
                            '#e74a3b',
                            '#858796',
                            '#5a5c69'
                        ],
                        hoverBackgroundColor: [
                            '#2e59d9',
                            '#17a673',
                            '#2c9faf',
                            '#dda20a',
                            '#be2617',
                            '#6b6d7d',
                            '#3a3c4a'
                        ],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.label || '';
                                    var value = context.raw || 0;
                                    var total = context.dataset.data.reduce((a, b) => a + b, 0);
                                    var percentage = Math.round((value / total) * 100);
                                    return `${label}: Ksh ${value.toLocaleString()} (${percentage}%)`;
                                }
                            }
                        },
                        legend: {
                            position: 'right',
                        }
                    }
                }
            });
            
            // Faculty Performance Bar Chart
            var facultyPerformanceData = @json($facultyPerformanceData);
            var facultyLabels = facultyPerformanceData.map(item => item.faculty_title);
            var facultyValues = facultyPerformanceData.map(item => item.total_amount);
            
            var facultyPerformanceCtx = document.getElementById('facultyPerformanceChart').getContext('2d');
            var facultyPerformanceChart = new Chart(facultyPerformanceCtx, {
                type: 'bar',
                data: {
                    labels: facultyLabels,
                    datasets: [{
                        label: "Amount Paid",
                        backgroundColor: "#4e73df",
                        hoverBackgroundColor: "#2e59d9",
                        borderColor: "#4e73df",
                        data: facultyValues,
                    }],
                },
                options: {
                    maintainAspectRatio: false,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    var label = context.dataset.label || '';
                                    var value = context.raw || 0;
                                    return `${label}: Ksh ${value.toLocaleString()}`;
                                }
                            }
                        },
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Faculty'
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Amount (Ksh)'
                            },
                            beginAtZero: true
                        }
                    }
                }
            });

            // Submit form on filter change (except search)
            $('#faculty, #program, #semester').change(function() {
                $('#filterForm').submit();
            });

            // Submit form on search button click
            $('#search').keypress(function(e) {
                if(e.which == 13) { // Enter key
                    $('#filterForm').submit();
                }
            });
        });
    </script>
@endsection