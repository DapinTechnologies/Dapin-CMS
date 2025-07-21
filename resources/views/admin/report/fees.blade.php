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
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.fees') }}">
                            <div class="row gx-2">
                                @include('common.inc.fees_search_filter')

                                <div class="form-group col-md-3">
                                    <label for="payment_method">{{ __('Payment Method') }}</label>
                                    <select class="form-control" name="payment_method" id="payment_method">
                                        <option value="0">{{ __('All Methods') }}</option>
                                        @foreach($payment_methods as $key => $method)
                                            <option value="{{ $key }}" @if($selected_payment_method == $key) selected @endif>{{ $method }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="start_date">{{ __('From Date') }}</label>
                                    <input type="date" class="form-control date" name="start_date" id="start_date" value="{{ $selected_start_date }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <label for="end_date">{{ __('To Date') }}</label>
                                    <input type="date" class="form-control date" name="end_date" id="end_date" value="{{ $selected_end_date }}">
                                </div>

                                <div class="form-group col-md-2">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('Search') }}</button>
                                    <button type="reset" class="btn btn-secondary" onclick="window.location.href='{{ route($route.'.fees') }}'">{{ __('Reset') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white mb-1">Total Collected Fees</h6>
                                        <h4 class="mb-0 text-white">{{ number_format($payments->sum('amount'), 2) }} {!! $setting->currency_symbol ?? 'KSh' !!}</h4>
                                    </div>
                                    <div class="bg-white text-primary p-3 rounded">
                                        <i class="fas fa-money-bill-wave fa-2x"></i>
                                    </div>
                                </div>
                                <p class="text-white mb-0 mt-2">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ date('d M Y', strtotime($selected_start_date)) }} - {{ date('d M Y', strtotime($selected_end_date)) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white mb-1">Total Transactions Made</h6>
                                        <h4 class="mb-0 text-white">{{ $payments->count() }}</h4>
                                    </div>
                                    <div class="bg-white text-primary p-3 rounded">
                                        <i class="fas fa-exchange-alt fa-2x"></i>
                                    </div>
                                </div>
                                <p class="text-white mb-0 mt-2">
                                    <i class="fas fa-percentage me-1"></i>
                                    {{ $payments->where('status', 'completed')->count() }} Successful
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card stat-card bg-primary text-white">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="text-white mb-1">Average Amount Per Transaction</h6>
                                        <h4 class="mb-0 text-white">{{ $payments->count() > 0 ? number_format($payments->sum('amount') / $payments->count(), 2) : 0 }} {!! $setting->currency_symbol ?? 'KSh' !!}</h4>
                                    </div>
                                    <div class="bg-white text-primary p-3 rounded">
                                        <i class="fas fa-calculator fa-2x"></i>
                                    </div>
                                </div>
                                <p class="text-white mb-0 mt-2">
                                    <i class="fas fa-chart-line me-1"></i>
                                    {{ $payments->where('status', 'completed')->count() }} successful
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Payment Method Distribution Row -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <h5>Payment Method Distribution</h5>
                            </div>
                            <div class="card-block">
                                <div id="payment-method-chart" style="height: 350px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Payment Summary</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered">
                                        <thead class="thead-light">
                                            <tr>
                                                <th class="border-top-0">Method</th>
                                                <th class="border-top-0 text-end">Amount</th>
                                                <th class="border-top-0 text-end">Total %</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalAmount = $payments->sum('amount');
                                            @endphp
                                            @foreach($payment_method_distribution as $method => $amount)
                                            <tr>
                                                <td class="border-top">
                                                    @if($method == 'mpesa')
                                                        <span class="badge badge-primary">Mpesa</span>
                                                    @elseif($method == 'bank')
                                                        <span class="badge badge-info">Bank</span>
                                                    @elseif($method == 'cash')
                                                        <span class="badge badge-success">Cash</span>
                                                    @elseif($method == 'cheque')
                                                        <span class="badge badge-warning">Cheque</span>
                                                    @else
                                                        <span class="badge badge-secondary">Bursary</span>
                                                    @endif
                                                </td>
                                                <td class="text-end border-top">{{ number_format($amount, 2) }} {!! $setting->currency_symbol ?? 'KSh' !!}</td>
                                                <td class="text-end border-top">{{ $totalAmount > 0 ? number_format(($amount / $totalAmount) * 100, 1) : 0 }}%</td>
                                            </tr>
                                            @endforeach
                                            <tr class="fw-bold">
                                                <td class="border-top">Total</td>
                                                <td class="text-end border-top">{{ number_format($totalAmount, 2) }} {!! $setting->currency_symbol ?? 'KSh' !!}</td>
                                                <td class="text-end border-top">100%</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Faculty and Program Collections in Single Row -->
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Fees Collected by Faculty</h5>
                            </div>
                            <div class="card-block">
                                <div id="faculty-collection-chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Fees Collected by Course</h5>
                            </div>
                            <div class="card-block">
                                <div id="program-collection-chart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions Table -->
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5>Payment Transactions</h5>
                        
                    </div>
                    @if(isset($payments))
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        <div class="table-responsive">
                            <table id="report-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('Invoice No') }}</th>
                                        <th>{{ __('Student Name') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                        <th>{{ __('Payment Method') }}</th>
                                        <th>{{ __('Reference/ ID') }}</th>
                                        <th>{{ __('Payment Date') }}</th>
                                        <th>{{ __('Reconciled At') }}</th>
                                        <th>{{ __('Status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($payments as $key => $payment)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            @if($payment->invoice)
                                                INV-{{ ($payment->invoice->id ) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->studentEnroll && $payment->studentEnroll->student)
                                                <div>
                                                    {{ $payment->studentEnroll->student->first_name }} {{ $payment->studentEnroll->student->last_name }}
                                                </div>
                                                <div>
                                                    <a href="{{ route('admin.student.show', $payment->studentEnroll->student->id) }}">
                                                        {{ $payment->studentEnroll->student->student_id ?? 'N/A' }}
                                                    </a>
                                                </div>
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            {{ number_format($payment->amount, 2) }} 
                                            {!! $setting->currency_symbol ?? 'KSh' !!}
                                        </td>
                                        <td>
                                            @if($payment->payment_method == 'mpesa')
                                                <span class="badge badge-primary">Mpesa</span>
                                            @elseif($payment->payment_method == 'bank')
                                                <span class="badge badge-info">Bank</span>
                                            @elseif($payment->payment_method == 'cash')
                                                <span class="badge badge-success">Cash</span>
                                            @elseif($payment->payment_method == 'cheque')
                                                <span class="badge badge-warning">Cheque</span>
                                            @else
                                                <span class="badge badge-secondary">Bursary</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $payment->reference_number ?? $payment->transaction_id ?? 'N/A' }}
                                        </td>
                                        <td>
                                            @if($payment->paid_at)
                                                {{ date('d M Y', strtotime($payment->paid_at)) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->reconciled_at)
                                                {{ date('d M Y H:i', strtotime($payment->reconciled_at)) }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>
                                            @if($payment->status == 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($payment->status == 'pending')
                                                <span class="badge badge-warning">Completed</span>
                                            @elseif($payment->status == 'failed')
                                                <span class="badge badge-danger">Completed</span>
                                            @elseif($payment->status == 'partial')
                                                <span class="badge badge-success">Completed</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="4" style="text-align:right">Total:</th>
                                        <th>{{ number_format($payments->sum('amount'), 2) }} {!! $setting->currency_symbol ?? 'KSh' !!}</th>
                                        <th colspan="5"></th>
                                    </tr>
                                </tfoot>
                                 <caption>
                                    @if(isset($payments))
                                    <div class="total-fees-box" style="background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%); padding: 16px; margin: 20px 0; border-radius: 8px; border-left: 4px solid #4a6cf7; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                        <h5 style="margin: 0; font-family: 'Segoe UI', Roboto, sans-serif; color: #2d3748; font-weight: 600; display: flex; align-items: center; justify-content: space-between;">
                                            <span>
                                                Total Collected Payments: 
                                                <strong style="color: #4a6cf7; font-weight: 700;">
                                                    {{ number_format($payments->sum('amount'), 2) }}
                                                    {!! $setting->currency_symbol ?? 'KSh' !!}
                                                </strong>
                                            </span>
                                            <span style="font-size: 0.85em; color: #718096; background: rgba(113, 128, 150, 0.1); padding: 4px 10px; border-radius: 12px;">
                                                <i class="far fa-calendar-alt" style="margin-right: 6px;"></i>
                                                {{ date('d M Y', strtotime($selected_start_date)) }} - {{ date('d M Y', strtotime($selected_end_date)) }}
                                            </span>
                                        </h5>
                                    </div>
                                    @endif
                                </caption>
                            </table>
                        </div>
                        <!-- [ Data table ] end -->
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

@endsection

@section('page_js')
@include('admin.report.script')

<!-- Load ECharts from CDN -->
<script src="https://cdn.jsdelivr.net/npm/echarts@5.4.3/dist/echarts.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure all DOM elements are loaded before initializing charts
    if (typeof echarts === 'undefined') {
        console.error('ECharts is not loaded');
        return;
    }

    // Helper function to get color based on payment method
    function getMethodColor(method) {
        switch(method) {
            case 'mpesa': return '#4a6cf7';
            case 'bank': return '#6c757d';
            case 'cash': return '#28a745';
            case 'cheque': return '#ffc107';
            case 'bursary': return '#dc3545';
            default: return '#17a2b8';
        }
    }

    // 1. Payment Method Distribution Pie Chart
    const paymentMethodData = @json($payment_method_distribution);
    const paymentMethodChartEl = document.getElementById('payment-method-chart');
    
    if (paymentMethodChartEl) {
        const paymentMethodChart = echarts.init(paymentMethodChartEl);
        
        // Calculate total amount for percentages
        const totalAmount = Object.values(paymentMethodData).reduce((sum, amount) => sum + amount, 0);
        
        const paymentMethodOption = {
            tooltip: {
                trigger: 'item',
                formatter: '{a} <br/>{b}: {c} ({d}%)',
                valueFormatter: (value) => {
                    return '{{ $setting->currency_symbol ?? 'KSh' }}' + value.toLocaleString();
                }
            },
            legend: {
                orient: 'vertical',
                right: 10,
                top: 'center',
                data: Object.keys(paymentMethodData).map(key => {
                    return key.charAt(0).toUpperCase() + key.slice(1);
                })
            },
            series: [
                {
                    name: 'Payment Method',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    center: ['40%', '50%'],
                    avoidLabelOverlap: false,
                    itemStyle: {
                        borderRadius: 10,
                        borderColor: '#fff',
                        borderWidth: 2
                    },
                    label: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        label: {
                            show: true,
                            fontSize: '18',
                            fontWeight: 'bold',
                            formatter: '{b}\n{c} ({d}%)'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: Object.entries(paymentMethodData).map(([key, value]) => {
                        return {
                            name: key.charAt(0).toUpperCase() + key.slice(1),
                            value: value,
                            itemStyle: {
                                color: getMethodColor(key)
                            }
                        }
                    })
                }
            ]
        };
        
        paymentMethodChart.setOption(paymentMethodOption);
        
        // Resize chart when window is resized
        window.addEventListener('resize', function() {
            paymentMethodChart.resize();
        });
    }

    // 2. Faculty Collections Vertical Bar Chart
    const facultyData = @json($faculty_collections);
    const facultyChartEl = document.getElementById('faculty-collection-chart');
    
    if (facultyChartEl) {
        const facultyChart = echarts.init(facultyChartEl);
        
        const facultyOption = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                },
                formatter: function(params) {
                    return params[0].name + '<br/>' + 
                           'Amount: {{ $setting->currency_symbol ?? 'KSh' }}' + params[0].value.toLocaleString();
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: Object.keys(facultyData),
                axisLabel: {
                    interval: 0,
                    rotate: 30 // Rotate labels if they're too long
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: function(value) {
                        return '{{ $setting->currency_symbol ?? 'KSh' }}' + value.toLocaleString();
                    }
                }
            },
            series: [
                {
                    name: 'Collections',
                    type: 'bar',
                    data: Object.values(facultyData),
                    itemStyle: {
                        color: function(params) {
                            const colorList = ['#4a6cf7', '#6c757d', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997', '#e83e8c'];
                            return colorList[params.dataIndex % colorList.length];
                        },
                        borderRadius: [5, 5, 0, 0]
                    },
                    label: {
                        show: true,
                        position: 'top',
                        formatter: function(params) {
                            return '{{ $setting->currency_symbol ?? 'KSh' }}' + params.value.toLocaleString();
                        }
                    }
                }
            ]
        };
        
        facultyChart.setOption(facultyOption);
        
        // Resize chart when window is resized
        window.addEventListener('resize', function() {
            facultyChart.resize();
        });
    }

    // 3. Program Collections Vertical Bar Chart
    const programData = @json($program_collections);
    const programChartEl = document.getElementById('program-collection-chart');
    
    if (programChartEl) {
        const programChart = echarts.init(programChartEl);
        
        const programOption = {
            tooltip: {
                trigger: 'axis',
                axisPointer: {
                    type: 'shadow'
                },
                formatter: function(params) {
                    return params[0].name + '<br/>' + 
                           'Amount: {{ $setting->currency_symbol ?? 'KSh' }}' + params[0].value.toLocaleString();
                }
            },
            grid: {
                left: '3%',
                right: '4%',
                bottom: '3%',
                containLabel: true
            },
            xAxis: {
                type: 'category',
                data: Object.keys(programData),
                axisLabel: {
                    interval: 0,
                    rotate: 30 // Rotate labels if they're too long
                }
            },
            yAxis: {
                type: 'value',
                axisLabel: {
                    formatter: function(value) {
                        return '{{ $setting->currency_symbol ?? 'KSh' }}' + value.toLocaleString();
                    }
                }
            },
            series: [
                {
                    name: 'Collections',
                    type: 'bar',
                    data: Object.values(programData),
                    itemStyle: {
                        color: function(params) {
                            const colorList = ['#4a6cf7', '#6c757d', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6610f2', '#fd7e14', '#20c997', '#e83e8c'];
                            return colorList[params.dataIndex % colorList.length];
                        },
                        borderRadius: [5, 5, 0, 0]
                    },
                    label: {
                        show: true,
                        position: 'top',
                        formatter: function(params) {
                            return '{{ $setting->currency_symbol ?? 'KSh' }}' + params.value.toLocaleString();
                        }
                    }
                }
            ]
        };
        
        programChart.setOption(programOption);
        
        // Resize chart when window is resized
        window.addEventListener('resize', function() {
            programChart.resize();
        });
    }
});
</script>


<style>
    .stat-card {
        margin-bottom: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        border: none;
        color: white;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-card .text-muted {
        color: rgba(255, 255, 255, 0.8) !important;
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.1);
    }
    .table th {
        background-color: #f8f9fa;
    }
    .badge {
        font-size: 12px;
        padding: 5px 10px;
        font-weight: 500;
    }
    .table-bordered {
        border: 1px solid #dee2e6;
    }
    .table-bordered th, 
    .table-bordered td {
        border: 1px solid #dee2e6;
    }
    .table-bordered thead th {
        border-bottom-width: 2px;
    }
    .thead-light th {
        background-color: #f8f9fa;
        color: #495057;
    }
</style>
@endsection