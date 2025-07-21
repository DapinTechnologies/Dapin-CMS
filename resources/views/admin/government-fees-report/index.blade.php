@extends('admin.layouts.master')
@section('title', $title)

@section('page_css')
<!-- Chart.js -->
<script src="{{ asset('dashboard/plugins/chart-chartjs/js/chart.min.js') }}"></script>
<style>
    .chart-container {
        height: 300px;
        width: 100%;
    }
</style>
@endsection

@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <!-- [ Government Fees Report ] start -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <form action="{{ route($route.'.index') }}" method="get" class="d-inline-block float-right">
                            <div class="row">
                                <div class="col-md-2">
                                    <select class="form-control" name="faculty" id="faculty">
                                        <option value="">All Faculties</option>
                                        @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" @if($request->faculty == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="program" id="program">
                                        <option value="">All Programs</option>
                                       
                                            @foreach($programs as $program)
                                            <option value="{{ $program->id }}" @if($request->program == $program->id) selected @endif>{{ $program->title }}</option>
                                            @endforeach
                                        
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" name="semester">
                                        <option value="">All Semesters</option>
                                        @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" @if($request->semester == $semester->id) selected @endif>{{ $semester->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" name="start_date" value="{{ $request->start_date }}">
                                </div>
                                <div class="col-md-2">
                                    <input type="date" class="form-control" name="end_date" value="{{ $request->end_date }}">
                                </div>
                                <div class="col-md-1">
                                    <button type="submit" class="btn btn-info">Filter</button>
                                </div>
                                <div class="col-md-1">
                                    <a href="{{ route($route.'.index') }}" class="btn btn-secondary">Reset</a>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-block">
                        <div class="row">
                           <!-- Summary Cards -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card bg-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Total Invoiced Fees</div>
                    <div class="h5 mb-0 font-weight-bold text-white">KES {{ number_format($chartData['totalExpected'], 2) }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-calendar fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card bg-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Total Collected Fees</div>
                    <div class="h5 mb-0 font-weight-bold text-white">KES {{ number_format($chartData['totalCollected'], 2) }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-wallet fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card bg-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Outstanding Fees</div>
                    <div class="h5 mb-0 font-weight-bold text-white">KES {{ number_format($chartData['totalExpected'] - $chartData['totalCollected'], 2) }}</div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-clipboard-list fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6 mb-4">
    <div class="card bg-primary shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Collection Rate</div>
                    <div class="h5 mb-0 font-weight-bold text-white">
                        {{ $chartData['totalExpected'] > 0 ? number_format(($chartData['totalCollected'] / $chartData['totalExpected']) * 100, 2) : 0 }}%
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-percent fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>
</div>

                        <div class="row">
                            <!-- Pie Chart - Fee Categories -->
                            <div class="col-xl-6 col-lg-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Government Fees Distribution</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="feeCategoriesPie"></canvas>
                                        </div>
                                        <div class="mt-4 text-center small">
                                            @foreach($chartData['categoryAmounts'] as $category)
                                                <span class="mr-2">
                                                    <i class="fas fa-circle" style="color: {{ $category['color'] ?? '#'.dechex(rand(0x000000, 0xFFFFFF)) }}"></i> {{ $category['name'] }}
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pie Chart - Payment Status -->
                            <div class="col-xl-6 col-lg-6">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Payment Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-pie pt-4 pb-2">
                                            <canvas id="paymentStatusPie"></canvas>
                                        </div>
                                        <div class="mt-4 text-center small">
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-success"></i> Paid
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-warning"></i> Partial
                                            </span>
                                            <span class="mr-2">
                                                <i class="fas fa-circle text-danger"></i> Unpaid
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Bar Chart - Expected vs Collected -->
                            <div class="col-xl-12 col-lg-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Invoiced Fees vs Collected Fees by Category</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="expectedVsCollectedBar"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Government Fee Categories</h6>
                                        <a href="{{ route($route.'.export') }}?faculty={{ $request->faculty }}&program={{ $request->program }}&semester={{ $request->semester }}&start_date={{ $request->start_date }}&end_date={{ $request->end_date }}" class="btn btn-sm btn-primary">Export to Excel</a>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>Fee Category</th>
                                                        <th>Type</th>
                                                        
                                                        <th>Invoiced Total Fee</th>
                                                        <th>Collected Fee</th>
                                                        <th>Outstanding Fee</th>
                                                        <th>Collection Rate</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($chartData['categoryAmounts'] as $categoryId => $categoryData)
                                                    @php
                                                        $category = $categories->find($categoryId);
                                                        $balance = $categoryData['expected'] - $categoryData['collected'];
                                                        $rate = $categoryData['expected'] > 0 ? ($categoryData['collected'] / $categoryData['expected']) * 100 : 0;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $categoryData['name'] }} - ( KES {{ number_format($category->amount, 2) }} )</td>
                                                        <td>{{ ucfirst($category->fee_type) }}</td>
                                                        
                                                        <td>KES {{ number_format($categoryData['expected'], 2) }}</td>
                                                        <td>KES {{ number_format($categoryData['collected'], 2) }}</td>
                                                        <td>KES {{ number_format($balance, 2) }}</td>
                                                        <td>
                                                            <div class="progress">
    <div class="progress-bar bg-{{ ($rate ?? 0) >= 80 ? 'success' : (($rate ?? 0) >= 50 ? 'warning' : 'danger') }}" 
         role="progressbar"
         style="width: {{ $rate ?? 0 }}%; min-width: 30px;"
         aria-valuenow="{{ $rate ?? 0 }}"
         aria-valuemin="0"
         aria-valuemax="100">
        {{ number_format($rate ?? 0, 1) }}%
    </div>
</div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- [ Government Fees Report ] end -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
<script>
// Pie Chart - Fee Categories
var ctx = document.getElementById("feeCategoriesPie");
var feeCategoriesPie = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [
            @foreach($chartData['categoryAmounts'] as $category)
                "{{ $category['name'] }}",
            @endforeach
        ],
        datasets: [{
            data: [
                @foreach($chartData['categoryAmounts'] as $category)
                    {{ $category['expected'] }},
                @endforeach
            ],
            backgroundColor: [
                @foreach($chartData['categoryAmounts'] as $category)
                    '{{ $category['color'] ?? '#'.dechex(rand(0x000000, 0xFFFFFF)) }}',
                @endforeach
            ],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.labels[tooltipItem.index] || '';
                    var value = data.datasets[0].data[tooltipItem.index];
                    return label + ': KES ' + value.toLocaleString();
                }
            }
        },
        legend: {
            display: false
        },
        cutoutPercentage: 80,
    },
});

// Pie Chart - Payment Status
var ctx2 = document.getElementById("paymentStatusPie");
var paymentStatusPie = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ["Paid", "Partial", "Unpaid"],
        datasets: [{
            data: [
                {{ $chartData['paymentStatusData']['paid'] }},
                {{ $chartData['paymentStatusData']['partial'] }},
                {{ $chartData['paymentStatusData']['unpaid'] }}
            ],
            backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b'],
            hoverBackgroundColor: ['#17a673', '#dda20a', '#be2617'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.labels[tooltipItem.index] || '';
                    var value = data.datasets[0].data[tooltipItem.index];
                    return label + ': ' + value + ' invoices';
                }
            }
        },
        legend: {
            display: false
        },
    },
});

// Bar Chart - Expected vs Collected
var ctx3 = document.getElementById("expectedVsCollectedBar");
var expectedVsCollectedBar = new Chart(ctx3, {
    type: 'bar',
    data: {
        labels: [
            @foreach($chartData['categoryAmounts'] as $category)
                "{{ $category['name'] }}",
            @endforeach
        ],
        datasets: [
            {
                label: "Invoiced Fees",
                backgroundColor: "#4e73df",
                hoverBackgroundColor: "#2e59d9",
                borderColor: "#4e73df",
                data: [
                    @foreach($chartData['categoryAmounts'] as $category)
                        {{ $category['expected'] }},
                    @endforeach
                ],
            },
            {
                label: "Collected Fees",
                backgroundColor: "#1cc88a",
                hoverBackgroundColor: "#17a673",
                borderColor: "#1cc88a",
                data: [
                    @foreach($chartData['categoryAmounts'] as $category)
                        {{ $category['collected'] }},
                    @endforeach
                ],
            }
        ],
    },
    options: {
        maintainAspectRatio: false,
        scales: {
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxRotation: 45,
                    minRotation: 45
                }
            }],
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    callback: function(value) {
                        return 'KES ' + value.toLocaleString();
                    }
                },
                gridLines: {
                    color: "rgb(234, 236, 244)",
                    zeroLineColor: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }],
        },
        legend: {
            display: true
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var label = data.datasets[tooltipItem.datasetIndex].label || '';
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return label + ': KES ' + value.toLocaleString();
                }
            }
        }
    }
});

// AJAX for program dropdown
$(document).ready(function() {
    $('#faculty').change(function() {
        var faculty_id = $(this).val();
        if(faculty_id) {
            $.ajax({
                url: "{{ route('admin.get-programs') }}",
                type: "GET",
                data: {'faculty_id': faculty_id},
                success: function(data) {
                    $('#program').empty();
                    $('#program').append('<option value="">All Programs</option>');
                    $.each(data, function(key, value) {
                        $('#program').append('<option value="'+key+'">'+value+'</option>');
                    });
                }
            });
        } else {
            $('#program').empty();
            $('#program').append('<option value="">All Programs</option>');
        }
    });
});
</script>
@endsection