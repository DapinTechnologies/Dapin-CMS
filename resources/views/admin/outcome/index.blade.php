@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0 text-white"><i class="fas fa-chart-line me-2 text-white"></i>Account Dashboard</h5>
                    </div>
                    
                    <div class="card-body">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.index') }}">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('field_start_date') }}</label>
                                    <input type="date" name="start_date" class="form-control" value="{{ isset($start_date)? $start_date : null }}">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_start_date') }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">{{ __('field_end_date') }}</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ isset($end_date)? $end_date : null }}">
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_end_date') }}
                                    </div>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary w-100">
                                        <i class="fas fa-search me-2"></i> {{ __('btn_search') }}
                                    </button>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <div class="dropdown w-100">
                                        <button class="btn btn-outline-primary dropdown-toggle w-100" type="button" id="dropdownCalculation" data-bs-toggle="dropdown" aria-expanded="false">
                                            @if($date_range == 1)
                                            {{ __('cal_1_month') }}
                                            @elseif($date_range == 3)
                                            {{ __('cal_3_months') }}
                                            @elseif($date_range == 6)
                                            {{ __('cal_6_months') }}
                                            @elseif($date_range == 12)
                                            {{ __('cal_1_year') }}
                                            @elseif($date_range == 0)
                                            {{ __('cal_beginning') }}
                                            @else
                                            {{ __('cal_date_range') }}
                                            @endif
                                        </button>
                                        <div class="dropdown-menu w-100" aria-labelledby="dropdownCalculation">
                                            <a class="dropdown-item" href="{{ route($route.'.show', '1') }}">{{ __('cal_1_month') }}</a>
                                            <a class="dropdown-item" href="{{ route($route.'.show', '3') }}">{{ __('cal_3_months') }}</a>
                                            <a class="dropdown-item" href="{{ route($route.'.show', '6') }}">{{ __('cal_6_months') }}</a>
                                            <a class="dropdown-item" href="{{ route($route.'.show', '12') }}">{{ __('cal_1_year') }}</a>
                                            <a class="dropdown-item" href="{{ route($route.'.show', '0') }}">{{ __('cal_beginning') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        

        <!-- Reconciled Data Section -->
        <div class="row mt-2">
            <div class="col-sm-12 mb-3">
                <h4 class="fw-semibold text-primary">Detailed Financial Data Overview</h4>
            </div>
            @php
                $total_outcome = ($total_overall_outcome ?? 0) - ($total_payable_reconciled ?? 0) - ($total_payroll ?? 0);
            @endphp

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 financial-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Bank Balances</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($total_outcome, 2) }}</h3>
                                <div class="mt-3">
                                    <span class="badge  bg-opacity-20 text-white">
                                        <i class="fas fa-university me-1"></i> Calculated Summary
                                    </span>
                                </div>
                            </div>
                            <div class="icon-container bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-university text-white fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 reconciled-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Student Fees Reconciled</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($student_fees_reconciled ?? '0', 2) }}</h3>
                                <small class="text-white">Regular fees only</small>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-2">
                                <i class="fas fa-check-circle text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 reconciled-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Bursaries Reconciled</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($bursaries_reconciled ?? '0', 2) }}</h3>
                                <small class="text-white">Total bursaries: {!! $setting->currency_symbol !!} {{ number_format($bursaries_amount ?? '0', 2) }}</small>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-2">
                                <i class="fas fa-graduation-cap text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 reconciled-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Total Student Fees Reconciled</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($total_student_fees_reconciled ?? '0', 2) }}</h3>
                                <small class="text-white">Fees + Bursaries</small>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-2">
                                <i class="fas fa-calculator text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 financial-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">{{ __('cal_total_payroll') }}</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($total_payroll ?? '0', 2) }}</h3>
                                <div class="mt-3">
                                    <span class="badge  bg-opacity-20 text-white">
                                        <i class="fas fa-users me-1"></i> Payroll
                                    </span>
                                </div>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-users text-white fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 reconciled-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Total Payable Reconciled</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($total_payable_reconciled ?? '0', 2) }}</h3>
                            </div>
                            <div class="icon-container bg-opacity-20 rounded-circle p-2">
                                <i class="fas fa-file-invoice-dollar text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 reconciled-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Receivable Reconciled</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($receivable_reconciled ?? '0', 2) }}</h3>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-2">
                                <i class="fas fa-hand-holding-usd text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 reconciled-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Total Overall Outcome</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($total_overall_outcome ?? '0', 2) }}</h3>
                                <small class="text-white">Student Fees + Receivable</small>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-2">
                                <i class="fas fa-chart-line text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- [ wallet section ] start-->
            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 financial-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Not Reconciled Receivables</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($total_income ?? '0', 2) }}</h3>
                                <div class="mt-3">
                                    <span class="badge  bg-opacity-20 text-white">
                                        <i class="fas fa-arrow-up me-1"></i> Income
                                    </span>
                                </div>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-arrow-circle-up text-white fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3 mb-4">
                <div class="card bg-primary text-white border-0 shadow-sm h-100 financial-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="card-title text-white mb-2">Not Reconciled Payables</h6>
                                <h3 class="fw-bold mb-0 text-white">{!! $setting->currency_symbol !!} {{ number_format($total_expense ?? '0', 2) }}</h3>
                                <div class="mt-3">
                                    <span class="badge  bg-opacity-20 text-white">
                                        <i class="fas fa-arrow-down me-1"></i> Expense
                                    </span>
                                </div>
                            </div>
                            <div class="icon-container  bg-opacity-20 rounded-circle p-3">
                                <i class="fas fa-arrow-circle-down text-white fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            
        </div>

        <!-- Charts Section -->
        <div class="row mt-4">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-semibold">Receivables Breakdown</h6>
                    </div>
                    <div class="card-body position-relative" style="height: 300px;">
                        <div class="chart-container">
                            <canvas id="incomes"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header fw-semibold">Payables Breakdown</h6>
                    </div>
                    <div class="card-body position-relative" style="height: 300px;">
                        <div class="chart-container">
                            <canvas id="expenses"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-semibold">Payroll Breakdown</h6>
                    </div>
                    <div class="card-body position-relative" style="height: 300px;">
                        <div class="chart-container">
                            <canvas id="payroll"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <!-- NEW: Reconciled Data Chart -->
            <div class="col-xl-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-semibold">Reconciled Financial Data Overview</h6>
                    </div>
                    <div class="card-body position-relative" style="height: 400px;">
                        <div class="chart-container">
                            <canvas id="reconciled-data-chart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0 fw-semibold">{{ __('cal_financial_overview') }}</h6>
                    </div>
                    <div class="card-body position-relative" style="height: 400px;">
                        <div class="chart-container">
                            <canvas id="incomes-expenses-payroll"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<style>
.financial-card, .reconciled-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-left: 4px solid transparent !important;
}

.financial-card:hover, .reconciled-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
}

.icon-container {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
}

.card-header {
    border-bottom: 1px solid rgba(0,0,0,0.05);
}

/* Chart container responsive styles */
.chart-container {
    position: relative;
    height: 100%;
    width: 100%;
}

/* Ensure charts are responsive and don't cause scrolling */
canvas {
    max-width: 100% !important;
    height: auto !important;
}

/* Fix for doughnut charts - prevent overflow */
.card-body {
    overflow: hidden;
}

@media (max-width: 768px) {
    .icon-container {
        width: 50px;
        height: 50px;
    }
    
    .icon-container i {
        font-size: 1.5rem !important;
    }
    
    h3.fw-bold {
        font-size: 1.5rem;
    }
    
    .card-body {
        padding: 1rem;
    }

    /* Adjust chart heights for mobile */
    .card-body[style*="height: 300px"] {
        height: 250px !important;
    }
    
    .card-body[style*="height: 400px"] {
        height: 300px !important;
    }
}

@media (max-width: 576px) {
    .icon-container {
        width: 40px;
        height: 40px;
        padding: 0.5rem !important;
    }
    
    .icon-container i {
        font-size: 1.25rem !important;
    }
    
    .card-body {
        padding: 0.75rem;
    }

    /* Further adjust chart heights for small mobile */
    .card-body[style*="height: 300px"] {
        height: 200px !important;
    }
    
    .card-body[style*="height: 400px"] {
        height: 250px !important;
    }
}
</style>

@endsection

@section('page_js')
    <!-- chartjs js -->
    <script src="{{ asset('dashboard/plugins/chart-chartjs/js/chart.min.js') }}"></script>
    
    <script type="text/javascript">
        'use strict';
        $(document).ready(function() {
            // Initialize all charts with proper responsive configuration
            function initializeCharts() {
                // [ bar-chart ] start
                var labels =  <?php echo $months ?>;
                var monthly_incomes =  <?php echo $monthly_incomes ?>;
                var monthly_expenses =  <?php echo $monthly_expenses ?>;
                var monthly_payroll =  <?php echo $monthly_payroll ?>;

                var bar = document.getElementById("incomes-expenses-payroll").getContext('2d');
                
                var calcul = {
                    labels: labels,
                    datasets: [{
                        label: "Overall Receivable",
                        data: monthly_incomes,
                        backgroundColor: 'rgba(13, 110, 253, 0.7)',
                        borderColor: 'rgba(13, 110, 253, 1)',
                        borderWidth: 1
                    }, {
                        label: "Overall Payable",
                        data: monthly_expenses,
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: 'rgba(220, 53, 69, 1)',
                        borderWidth: 1
                    }, {
                        label: "{{ __('cal_total_payroll') }}",
                        data: monthly_payroll,
                        backgroundColor: 'rgba(253, 126, 20, 0.7)',
                        borderColor: 'rgba(253, 126, 20, 1)',
                        borderWidth: 1
                    }]
                };
                
                var myBarChart = new Chart(bar, {
                    type: 'bar',
                    data: calcul,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                // NEW: Reconciled Data Chart
                var reconciledChart = document.getElementById("reconciled-data-chart").getContext('2d');
                var monthly_student_fees_reconciled = <?php echo $monthly_student_fees_reconciled ?>;
                var monthly_bursaries_reconciled = <?php echo $monthly_bursaries_reconciled ?>;
                var monthly_total_student_fees_reconciled = <?php echo $monthly_total_student_fees_reconciled ?>;
                var monthly_total_payable_reconciled = <?php echo $monthly_total_payable_reconciled ?>;
                var monthly_receivable_reconciled = <?php echo $monthly_receivable_reconciled ?>;
                var monthly_total_overall_outcome = <?php echo $monthly_total_overall_outcome ?>;

                var reconciledData = {
                    labels: labels,
                    datasets: [{
                        label: "Student Fees Reconciled",
                        data: monthly_student_fees_reconciled,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    }, {
                        label: "Bursaries Reconciled",
                        data: monthly_bursaries_reconciled,
                        backgroundColor: 'rgba(23, 162, 184, 0.7)',
                        borderColor: 'rgba(23, 162, 184, 1)',
                        borderWidth: 1
                    }, {
                        label: "Total Student Fees Reconciled",
                        data: monthly_total_student_fees_reconciled,
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }, {
                        label: "Total Payable Reconciled",
                        data: monthly_total_payable_reconciled,
                        backgroundColor: 'rgba(255, 193, 7, 0.7)',
                        borderColor: 'rgba(255, 193, 7, 1)',
                        borderWidth: 1
                    }, {
                        label: "Receivable Reconciled",
                        data: monthly_receivable_reconciled,
                        backgroundColor: 'rgba(108, 117, 125, 0.7)',
                        borderColor: 'rgba(108, 117, 125, 1)',
                        borderWidth: 1
                    }, {
                        label: "Total Overall Outcome",
                        data: monthly_total_overall_outcome,
                        borderColor: '#343a40',
                        backgroundColor: 'rgba(52, 58, 64, 0.1)',
                        borderWidth: 2,
                        type: 'line',
                        fill: true
                    }]
                };

                var myReconciledChart = new Chart(reconciledChart, {
                    type: 'bar',
                    data: reconciledData,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'top',
                            },
                            title: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        }
                    }
                });

                // [ doughnut-chart ] start - Incomes
                var incomeChart = document.getElementById("incomes").getContext('2d');
                var incomes = {
                    labels: [
                        @foreach($income_categories as $income_category)
                        '{{ $income_category->title }}', 
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                        @foreach($income_categories as $income_category)
                        {{ $income_category->incomes->where('status', '1')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->sum('amount') }}, 
                        @endforeach
                        ],
                        backgroundColor: [
                            "#0d6efd", "#6f42c1", "#d63384", "#fd7e14", "#20c997",
                            "#0dcaf0", "#ffc107", "#6610f2", "#6c757d", "#198754"
                        ],
                        borderWidth: 1
                    }]
                };
                var myPieChart = new Chart(incomeChart, {
                    type: 'doughnut',
                    data: incomes,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 15,
                                    usePointStyle: true
                                }
                            }
                        },
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10
                            }
                        }
                    }
                });

                // [ doughnut-chart ] start - Expenses
                var expenseChart = document.getElementById("expenses").getContext('2d');
                var expenses = {
                    labels: [
                        @foreach($expense_categories as $expense_category)
                        '{{ $expense_category->title }}', 
                        @endforeach
                    ],
                    datasets: [{
                        data: [
                        @foreach($expense_categories as $expense_category)
                        {{ $expense_category->expenses->where('status', '1')->where('date', '>=', $start_date)->where('date', '<=', $end_date)->sum('amount') }}, 
                        @endforeach
                        ],
                        backgroundColor: [
                            "#dc3545", "#fd7e14", "#ffc107", "#20c997", "#0dcaf0",
                            "#0d6efd", "#6f42c1", "#d63384", "#6c757d", "#198754"
                        ],
                        borderWidth: 1
                    }]
                };
                var myExpenseChart = new Chart(expenseChart, {
                    type: 'doughnut',
                    data: expenses,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 15,
                                    usePointStyle: true
                                }
                            }
                        },
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10
                            }
                        }
                    }
                });

                // [ doughnut-chart ] start - Payroll
                var payrollChart = document.getElementById("payroll").getContext('2d');
                var payroll = {
                    labels: ['Net Pay', 'Taxes', 'Gross Pay'],
                    datasets: [{
                        data: [
                            {{ $total_payroll ?? 0 }},
                            {{ $total_payroll_taxes ?? 0 }},
                            {{ $total_gross_payroll ?? 0 }}
                        ],
                        backgroundColor: [
                            "#fd7e14", "#dc3545", "#ffc107"
                        ],
                        borderWidth: 1
                    }]
                };
                var myPayrollChart = new Chart(payrollChart, {
                    type: 'doughnut',
                    data: payroll,
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    padding: 15,
                                    usePointStyle: true
                                }
                            }
                        },
                        layout: {
                            padding: {
                                top: 10,
                                bottom: 10
                            }
                        }
                    }
                });
            }

            // Initialize charts
            initializeCharts();

            // Reinitialize charts on window resize for better responsiveness
            let resizeTimer;
            window.addEventListener('resize', function() {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(function() {
                    // Destroy existing charts and reinitialize
                    Chart.helpers.each(Chart.instances, function(instance) {
                        instance.destroy();
                    });
                    initializeCharts();
                }, 250);
            });
        });
    </script>
@endsection