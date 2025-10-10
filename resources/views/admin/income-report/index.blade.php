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
                        <h5>Receivable Report</h5>
                    </div>
                    <div class="card-block">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                @can($access.'-create')
                                <a href="{{ route('admin.income.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Receivable
                                </a>
                                @endcan
                            </div>
                            <div>
                                <button type="button" class="btn btn-info" onclick="printReport()">
                                    <i class="fas fa-print"></i> Print
                                </button>
                                
                                <a href="{{ route($route.'.index') }}" class="btn btn-dark">
                                    <i class="fas fa-sync-alt"></i> Refresh
                                </a>
                            </div>
                        </div>

                        <!-- Filter Form -->
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-2">
                                    <label for="category">Category</label>
                                    <select class="form-control" name="category" id="category">
                                        <option value="all">All Categories</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            @if($selected_category == $category->id) selected @endif>
                                            {{ $category->title }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="payment_method">Payment Method</label>
                                    <select class="form-control" name="payment_method" id="payment_method">
                                        <option value="all">All Methods</option>
                                        <option value="1" @if($selected_payment_method == 1) selected @endif>Card</option>
                                        <option value="2" @if($selected_payment_method == 2) selected @endif>Cash</option>
                                        <option value="3" @if($selected_payment_method == 3) selected @endif>Cheque</option>
                                        <option value="4" @if($selected_payment_method == 4) selected @endif>Bank Transfer</option>
                                        <option value="5" @if($selected_payment_method == 5) selected @endif>E-Wallet</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="start_date">From Date</label>
                                    <input type="date" class="form-control" name="start_date" 
                                           value="{{ $selected_start_date }}" required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="end_date">To Date</label>
                                    <input type="date" class="form-control" name="end_date" 
                                           value="{{ $selected_end_date }}" required>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="group_by">Group By</label>
                                    <select class="form-control" name="group_by" id="group_by">
                                        <option value="day" @if($selected_group_by == 'day') selected @endif>Daily</option>
                                        <option value="week" @if($selected_group_by == 'week') selected @endif>Weekly</option>
                                        <option value="month" @if($selected_group_by == 'month') selected @endif>Monthly</option>
                                        <option value="category" @if($selected_group_by == 'category') selected @endif>By Category</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="chart_type">Chart Type</label>
                                    <select class="form-control" name="chart_type" id="chart_type">
                                        <option value="line" @if($selected_chart_type == 'line') selected @endif>Line Chart</option>
                                        <option value="bar" @if($selected_chart_type == 'bar') selected @endif>Bar Chart</option>
                                        <option value="pie" @if($selected_chart_type == 'pie') selected @endif>Pie Chart</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-12">
                                    <button type="submit" class="btn btn-info">
                                        <i class="fas fa-search"></i> Generate Report
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
<div class="col-lg-3 col-md-6">
    <div class="card bg-primary text-white">
        <div class="card-body text-white" style="color: #fff !important;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-1" style="color: #fff !important;">
                        {{ number_format($total_income, 2) }}
                    </h4>
                    <p class="mb-0" style="color: #fff !important;">Total Receivable</p>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-money-bill-wave fa-2x" style="color: #fff !important;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card bg-primary text-white">
        <div class="card-body text-white" style="color: #fff !important;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-1" style="color: #fff !important;">{{ $incomes->count() }}</h4>
                    <p class="mb-0" style="color: #fff !important;">Total Transactions</p>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-receipt fa-2x" style="color: #fff !important;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card bg-primary text-white">
        <div class="card-body text-white" style="color: #fff !important;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-1" style="color: #fff !important;">
                        {{ number_format($incomes->avg('amount') ?? 0, 2) }}
                    </h4>
                    <p class="mb-0" style="color: #fff !important;">Average Receivable</p>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-chart-line fa-2x" style="color: #fff !important;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-lg-3 col-md-6">
    <div class="card bg-primary text-white">
        <div class="card-body text-white" style="color: #fff !important;">
            <div class="d-flex justify-content-between">
                <div>
                    <h4 class="mb-1" style="color: #fff !important;">{{ $categories->count() }}</h4>
                    <p class="mb-0" style="color: #fff !important;">Categories</p>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-tags fa-2x" style="color: #fff !important;"></i>
                </div>
            </div>
        </div>
    </div>
</div>


            <!-- Charts Section -->
            <div class="col-lg-8 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Receivable Trends</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="incomeChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Receivable by Category</h5>
                    </div>
                    <div class="card-block">
                        <div class="chart-container">
                            <canvas id="categoryChart" height="300"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Data Table -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Receivable Details</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive">
                            <table id="incomeTable" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Invoice ID</th>
                                        <th>Amount</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Reference</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($incomes as $key => $income)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $income->title }}</td>
                                        <td>{{ $income->category->title ?? 'N/A' }}</td>
                                        <td>{{ $income->invoice_id ?? 'N/A' }}</td>
                                        <td>{{ number_format($income->amount, 2) }}</td>
                                        <td>{{ date('M d, Y', strtotime($income->date)) }}</td>
                                        <td>
                                            @switch($income->payment_method)
                                                @case(1) Card @break
                                                @case(2) Cash @break
                                                @case(3) Cheque @break
                                                @case(4) Bank Transfer @break
                                                @case(5) E-Wallet @break
                                                @default Unknown
                                            @endswitch
                                        </td>
                                        <td>{{ $income->reference ?? 'N/A' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-light">
                                        <th colspan="4" class="text-end">Total:</th>
                                        <th>{{ number_format($total_income, 2) }}</th>
                                        <th colspan="3"></th>
                                    </tr>
                                </tfoot>
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
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Initialize Charts
let incomeChart, categoryChart;

function initializeCharts() {
    const ctx1 = document.getElementById('incomeChart').getContext('2d');
    const ctx2 = document.getElementById('categoryChart').getContext('2d');

    // Destroy existing charts
    if (incomeChart) incomeChart.destroy();
    if (categoryChart) categoryChart.destroy();

    // Main Income Chart
    incomeChart = new Chart(ctx1, {
        type: '{{ $selected_chart_type }}',
        data: {
            labels: {!! json_encode(array_keys($chart_data->toArray())) !!},
            datasets: [{
                label: 'Income',
                data: {!! json_encode(array_values($chart_data->toArray())) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Income Trend'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '{{ $setting->currency_symbol ?? "$" }}' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Category Pie Chart
    const categoryData = {!! json_encode($incomes->groupBy('category_id')->map(function($group) {
        return [
            'name' => $group->first()->category ? $group->first()->category->title : 'Unknown',
            'amount' => $group->sum('amount')
        ];
    })) !!};

    categoryChart = new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: Object.values(categoryData).map(item => item.name),
            datasets: [{
                data: Object.values(categoryData).map(item => item.amount),
                backgroundColor: [
                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
                    '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                title: {
                    display: true,
                    text: 'Income Distribution by Category'
                }
            }
        }
    });
}

// Print Report
function printReport() {
    const params = new URLSearchParams({
        category: '{{ $selected_category }}',
        payment_method: '{{ $selected_payment_method }}',
        start_date: '{{ $selected_start_date }}',
        end_date: '{{ $selected_end_date }}'
    });
    
    window.open('{{ route($route . ".print") }}?' + params.toString(), '_blank');
}

// Initialize charts when page loads
document.addEventListener('DOMContentLoaded', function() {
    initializeCharts();
    
    // Update charts when filters change
    document.getElementById('group_by').addEventListener('change', updateCharts);
    document.getElementById('chart_type').addEventListener('change', updateCharts);
});

// Update charts via AJAX
function updateCharts() {
    const formData = new FormData();
    formData.append('category', '{{ $selected_category }}');
    formData.append('payment_method', '{{ $selected_payment_method }}');
    formData.append('start_date', '{{ $selected_start_date }}');
    formData.append('end_date', '{{ $selected_end_date }}');
    formData.append('group_by', document.getElementById('group_by').value);
    formData.append('chart_type', document.getElementById('chart_type').value);

    fetch('{{ route($route . ".chart-data") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        updateChartData(data);
    });
}

function updateChartData(data) {
    incomeChart.data.labels = data.labels;
    incomeChart.data.datasets[0].data = data.data;
    incomeChart.update();
}
</script>
@endsection