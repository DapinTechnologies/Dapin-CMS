@extends('admin.layouts.master')
@section('title', $title)
@section('content')

@section('page_js')
    <script src="{{ asset('dashboard/plugins/chart-chartjs/js/chart.min.js') }}"></script>

    @include('admin.report.script')
    
    <style>
        /* Add border to all table cells and headers */
        #report-table {
            border-collapse: collapse;
            width: 100%;
        }
        
        #report-table th, 
        #report-table td {
            border: 1px solid #dee2e6;
            padding: 8px;
            text-align: left;
        }
        
        /* Basic reset for consistent spacing */
.summary-card {
    box-sizing: border-box;
}

/* Main card styling without hover effects */
.summary-card {
    border-radius: 10px;
    padding: 20px;
    margin-bottom: 30px; /* This creates the gap below each card */
    background-color: #3498db;
    border-left: 5px solid;
    position: relative;
}

/* If you're using a container for multiple cards */
.card-container {
    display: flex;
    flex-direction: column;
    gap: 30px; /* This adds space between cards */
}

/* If cards are in a grid layout */
.card-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 30px; /* Space between grid items */
    margin-bottom: 30px; /* Space below the grid */
}

/* Content styling */
.summary-card .card-title {
    font-size: 14px;
    color: #fdfeff;
    margin-bottom: 10px;
    font-weight: 600;
    text-transform: uppercase;
}

.summary-card .card-value {
    font-size: 28px;
    color: white;
    font-weight: 700;
    margin: 10px 0;
}

.summary-card .card-percent {
    font-size: 14px;
    display: inline-block;
    padding: 3px 10px;
    border-radius: 20px;
    background: rgba(252, 247, 247, 1);
}

.card-icon {
    font-size: 40px;
    opacity: 0.3;
    position: absolute;
    right: 20px;
    top: 20px;
}

.chart-container {
    height: 300px;
    margin-bottom: 30px; /* Consistent spacing */
    background: white;
    border-radius: 10px;
    padding: 15px;
}
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly Trends Chart - Changed to Line Graph
            const trendsCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
            const monthlyTrendsData = @json($dashboard['monthly_trends']);
            
            const months = Object.keys(monthlyTrendsData);
            const billedData = months.map(month => monthlyTrendsData[month].billed);
            const collectedData = months.map(month => monthlyTrendsData[month].collected);
            const outstandingData = months.map(month => monthlyTrendsData[month].outstanding);
            
            new Chart(trendsCtx, {
                type: 'line',
                data: {
                    labels: months,
                    datasets: [
                        {
                            label: 'Billed Fees',
                            data: billedData,
                            backgroundColor: 'rgba(54, 162, 235, 0.1)',
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Collected Fees',
                            data: collectedData,
                            backgroundColor: 'rgba(75, 192, 192, 0.1)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        },
                        {
                            label: 'Outstanding',
                            data: outstandingData,
                            backgroundColor: 'rgba(255, 99, 132, 0.1)',
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 2,
                            tension: 0.3,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                drawBorder: false,
                                color: 'rgba(0,0,0,0.05)'
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

            // Faculty Distribution Pie Chart - Improved with card layout and consistent styling
const facultyCtx = document.getElementById('facultyDistributionChart').getContext('2d');
const facultyData = @json($dashboard['faculty_distribution']);

const facultyLabels = Object.keys(facultyData);
const facultyValues = Object.values(facultyData);

// Generate consistent, accessible colors
const backgroundColors = [
    '#1dc4e9', '#1de9b6', '#f4c22b', '#f44236', '#a389d4',
    '#04a9f5', '#e3ea39', '#3ebfea', '#4ecc48', '#e67e22',
    '#9b59b6', '#e74c3c', '#3498db', '#2ecc71', '#f39c12'
].slice(0, facultyLabels.length);

const borderColors = [
    '#14a7cc', '#14cc9e', '#ecb50c', '#f22012', '#8e6cc4',
    '#038fcf', '#d4d923', '#2aa3c4', '#3cb035', '#d35400',
    '#8e44ad', '#c0392b', '#2980b9', '#27ae60', '#e67e22'
].slice(0, facultyLabels.length);

new Chart(facultyCtx, {
    type: 'pie',
    data: {
        labels: facultyLabels,
        datasets: [{
            data: facultyValues,
            backgroundColor: backgroundColors,
            borderColor: borderColors,
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: {
                    padding: 15,
                    usePointStyle: true,
                    pointStyle: 'circle',
                    font: {
                        size: 12
                    }
                }
            },
            title: {
                display: true,
                text: 'Faculty Distribution',
                font: {
                    size: 16
                },
                padding: {
                    bottom: 20
                }
            },
            tooltip: {
                callbacks: {
                    label: function(context) {
                        const label = context.label || '';
                        const value = context.raw || 0;
                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                        const percentage = Math.round((value / total) * 100);
                        return `${label}: ${value.toLocaleString()} (${percentage}%)`;
                    }
                }
            }
        },
        cutout: '50%',
        animation: {
            animateScale: true,
            animateRotate: true
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
        });
    </script>
@endsection

<!-- Start Content-->
<div class="main-body">
    <div class="page-wrapper">
        <!-- [ Main Content ] start -->
        <div class="row">
            
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                    </div>
                    <div class="card-block">
                        <form class="needs-validation" novalidate method="get" action="{{ route($route .'.student-fees') }}">
                            <div class="row gx-2">
                                <div class="form-group col-md-2">
                                    <label for="faculty">{{ __('field_faculty') }}</label>
                                    <select class="form-control select2" name="faculty" id="faculty">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($faculties as $faculty)
                                        <option value="{{ $faculty->id }}" @if($selected_faculty == $faculty->id) selected @endif>{{ $faculty->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="program">{{ __('field_program') }}</label>
                                    <select class="form-control select2" name="program" id="program">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($programs as $program)
                                        <option value="{{ $program->id }}" @if($selected_program == $program->id) selected @endif>{{ $program->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="semester">{{ __('field_semester') }}</label>
                                    <select class="form-control select2" name="semester" id="semester">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($semesters as $semester)
                                        <option value="{{ $semester->id }}" @if($selected_semester == $semester->id) selected @endif>{{ $semester->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="fee_category">Fee Category</label>
                                    <select class="form-control select2" name="fee_category" id="fee_category">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach($fee_categories as $category)
                                        <option value="{{ $category->id }}" @if($selected_fee_category == $category->id) selected @endif>{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="status">Payment {{ __('field_status') }}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="all">{{ __('all') }}</option>
                                        <option value="paid" @if($selected_status == 'paid') selected @endif>{{ __('status_paid') }}</option>
                                        <option value="unpaid" @if($selected_status == 'unpaid') selected @endif>{{ __('status_unpaid') }}</option>
                                        <option value="partial" @if($selected_status == 'partial') selected @endif>Partial Payment</option>
                                    </select>
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="start_date">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" id="start_date" value="{{ $selected_start_date }}">
                                </div>
                                
                                <div class="form-group col-md-2">
                                    <label for="end_date">End Date</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" value="{{ $selected_end_date }}">
                                </div>
                                
                                <div class="form-group col-md-2">
    
        <button type="submit" class="btn btn-info btn-filter">
            <i class="fas fa-search"></i> {{ __('btn_search') }}
        </button>
       
   
</div>
 <div class="form-group col-md-2">
     <a href="{{ route($route.'.student-fees') }}" class="btn btn-secondary">
            Reset
        </a>
    </div>


                            </div>
                        </form>
                    </div>
                   <!-- [ Fee Summary Cards ] start-->
<div class="row">
    <div class="col-sm-6 col-md-6 col-xl-3" >
        <div class="summary-card" style="border-left-color: #ffffffff;">
            <h5 class="card-title">TOTAL BILLED FEES</h5>
            <h3 class="card-value">{{ number_format($dashboard['total_billed'], 2) }} {!! $setting->currency_symbol !!}</h3>
            
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6 col-xl-3">
        <div class="summary-card" style="border-left-color: #ffffffff;">
            <h5 class="card-title">FEES COLLECTED</h5>
            <h3 class="card-value">{{ number_format($dashboard['total_collected'], 2) }} {!! $setting->currency_symbol !!}</h3>
            <span class="card-percent {{ $dashboard['collection_rate'] >= 80 ? 'text-success' : ($dashboard['collection_rate'] >= 50 ? 'text-warning' : 'text-danger') }}">
                {{ $dashboard['collection_rate'] }}% collection rate
            </span>
           
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6 col-xl-3">
        <div class="summary-card" style="border-left-color: white;">
            <h5 class="card-title">OUTSTANDING BALANCES</h5>
            <h3 class="card-value">{{ number_format($dashboard['total_outstanding'], 2) }} {!! $setting->currency_symbol !!}</h3>
            <span class="card-percent text-danger">
                {{ $dashboard['total_billed'] > 0 ? round(($dashboard['total_outstanding'] / $dashboard['total_billed']) * 100, 2) : 0 }}% of billed
            </span>
            
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6 col-xl-3">
        <div class="summary-card" style="border-left-color: #fbfffcff;">
            <h5 class="card-title">FULLY PAID STUDENTS</h5>
            <h3 class="card-value">{{ $dashboard['fully_paid_count'] }}</h3>
             <span class="card-percent text-danger">
                {{ $dashboard['fully_paid_percent'] }}% of total
            </span>
            
        </div>
    </div>
    </div>
    <div class="row">
    <div class="col-sm-6 col-md-6 col-xl-3">
        <div class="summary-card" style="border-left-color: #f8f7f3ff;">
            <h5 class="card-title">PARTIAL PAYMENTS</h5>
            <h3 class="card-value">{{ $dashboard['partial_paid_count'] }}</h3>
             <span class="card-percent text-danger">
                {{ $dashboard['partial_paid_percent'] }}% of total
            </span>
            
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6 col-xl-3">
        <div class="summary-card" style="border-left-color: #ffffffff;">
            <h5 class="card-title">BURSARY AWARDS</h5>
            <h3 class="card-value">{{ $dashboard['bursary_count'] }}</h3>
            <span class="card-percent text-danger">
                {{ $dashboard['bursary_percent'] }}% of total
            </span>
            
        </div>
    </div>
    
    <div class="col-sm-6 col-md-6 col-xl-3">
        <div class="summary-card" style="border-left-color: #ffffffff;">
            <h5 class="card-title">UNPAID STUDENTS</h5>
            <h3 class="card-value">{{ $dashboard['unpaid_count'] }}</h3>
<span class="card-percent text-danger">
    {{ $dashboard['unpaid_percent'] }}% of total
</span>
            
        </div>
    </div>
    </div>
</div>
<!-- [ Fee Summary Cards ] end-->
                    
<!-- Charts Section -->
<div class="card-block">
    <div class="row">
        <div class="col-md-8">
            <div class="chart-container">
                <canvas id="monthlyTrendsChart"></canvas>
            </div>
        </div>
        <div class="col-md-4">
            <div class="chart-container">
                <canvas id="facultyDistributionChart"></canvas>
            </div>
        </div>
    </div>
</div>
                    
                    <!-- Data Table Section -->
                    <div class="card-block">
                        <!-- [ Data table ] start -->
                        @isset($rows)
                        <div class="table-responsive">
                            <table id="report-table" class="display table nowrap table-striped table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Student</th>
                                        <th>Session</th>
                                        <th>Semester</th>
                                        <th>Fee Category</th>
                                        <th>Total Fee</th>
                                        <th>Discount</th>
                                        <th>Fine</th>
                                        <th>Amount Paid</th>
                                        <th>Bursary</th>
                                        <th>Balance</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Payment Method</th>
                                        <th>Reference / ID</th>
                                        <th>Reconciled</th>
                                        <th>Payment Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  @foreach($rows as $key => $row)
                                    @php
                                        // Calculate balance
                                        $balance = $row->total_fee - $row->discount_amount + $row->fine_amount - $row->amount_paid - $row->bursary_allocated;
                                        
                                        // Determine status
                                        if ($row->payment_status == 'paid') {
                                            $status = __('status_paid');
                                            $status_class = 'success';
                                        } elseif ($row->payment_status == 'partial') {
                                            $status = __('Partial');
                                            $status_class = 'warning';
                                        } elseif ($row->discount_amount > 0) {
                                            $status = __('Discounted');
                                            $status_class = 'info';
                                        } elseif ($row->fine_amount > 0) {
                                            $status = __('Fined');
                                            $status_class = 'danger';
                                        } else {
                                            $status = __('Unpaid');
                                            $status_class = 'danger';
                                        }
                                    @endphp
                                    
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $row->invoice_no }}</td>
                                        <td>
                                            {{ $row->studentEnroll->student->first_name ?? '' }} {{ $row->studentEnroll->student->last_name ?? '' }}
                                            <br>
                                            <small class="text-muted">{{ $row->studentEnroll->student->student_id ?? '' }}</small>
                                        </td>
                                        <td>{{ $row->studentEnroll->session->title ?? '' }}</td>
                                        <td>{{ $row->studentEnroll->semester->title ?? '' }}</td>
                                        <td class="d-flex flex-column">
    @php
        // Get fees from relationship or direct query
        $fees = $row->fees ?? \App\Models\Fee::where('invoice_id', $row->id)->get();
        
        // Fallback query if still empty
        if ($fees->isEmpty()) {
            $fees = \App\Models\Fee::where('student_enroll_id', $row->student_enroll_id)
                ->where('assign_date', $row->assign_date)
                ->where('due_date', $row->due_date)
                ->get();
        }

        // Generate HTML for each fee category in separate spans
        $categoryList = $fees->map(function($fee) use ($setting) {
            $categoryTitle = $fee->category->title ?? 'Category #' . $fee->category_id;
            $amount = isset($setting->decimal_place) 
                ? number_format($fee->category->amount ?? $fee->amount, $setting->decimal_place) 
                : number_format($fee->category->amount ?? $fee->amount, 2);
            
            return sprintf(
                '<div class="mb-1"><span class="badge badge-info">%s (%s %s)</span></div>',
                $categoryTitle,
                $amount,
                $setting->currency_symbol ?? ''
            );
        })->implode('');

        if ($fees->isEmpty()) {
            $categoryList = '<span class="text-danger">No fees assigned</span>';
        }
    @endphp
    {!! $categoryList !!}
</td>
                                        <td>
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$row->total_fee, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$row->total_fee, 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                        </td>
                                        <td>
    {{ number_format((float)$row->discount_amount, $setting->decimal_place ?? 2, '.', '') }}{!! $setting->currency_symbol !!}
    @if($row->adjustment_type == 'discount' && $row->adjustment_notes)
        @php
            $noteWords = str_word_count($row->adjustment_notes, 1);
            $firstTwoWords = implode(' ', array_slice($noteWords, 0, 2));
            $remainingWords = implode(' ', array_slice($noteWords, 2));
        @endphp
        <br><small class="text-muted">{{ $firstTwoWords }}
        @if($remainingWords) <br>{{ $remainingWords }} @endif
        </small>
    @endif
</td>
                                        <td>
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$row->fine_amount, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$row->fine_amount, 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                            @if($row->adjustment_type == 'fine' && $row->adjustment_notes)
                                                <br><small class="text-muted">{{ $row->adjustment_notes }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $totalPaid = 0;
                                                if($row->payments->count() > 0) {
                                                    foreach($row->payments as $payment) {
                                                        $totalPaid += $payment->amount;
                                                    }
                                                }
                                            @endphp
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$totalPaid, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$totalPaid, 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                        </td>
                                        <td>
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$row->bursary_allocated, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$row->bursary_allocated, 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                            @if($row->bursary_notes || $row->bursary_type)
                                                <br><small class="text-muted">{{ $row->bursary_type ?? '' }} {{ $row->bursary_notes ? '- '.$row->bursary_notes : '' }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if(isset($setting->decimal_place))
                                            {{ number_format((float)$balance, $setting->decimal_place, '.', '') }} 
                                            @else
                                            {{ number_format((float)$balance, 2, '.', '') }} 
                                            @endif 
                                            {!! $setting->currency_symbol !!}
                                        </td>
                                        <td>
                                            @if(isset($setting->date_format))
                                            {{ date($setting->date_format, strtotime($row->due_date)) }}
                                            @else
                                            {{ date("Y-m-d", strtotime($row->due_date)) }}
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-pill badge-{{ $status_class }}">{{ $status }}</span>
                                        </td>
                                        <td>
                                            @if($row->payments->count() > 0)
                                                @foreach($row->payments as $payment)
                                                    @php
                                                        $paymentMethod = strtoupper($payment->payment_method);
                                                        if(!in_array($paymentMethod, ['MPESA', 'CASH', 'CHEQUE', 'BANK'])) {
                                                            $paymentMethod = 'BURSARY';
                                                        }
                                                    @endphp
                                                    {{ ucfirst($paymentMethod) }}<br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->payments->count() > 0)
                                                @foreach($row->payments as $payment)
                                                    {{ $payment->reference_number ?? $payment->transaction_id }}<br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->payments->count() > 0)
                                                @foreach($row->payments as $payment)
                                                    @if($payment->is_reconciled)
                                                        <span class="badge badge-pill badge-success">Reconciled</span>
                                                    @else
                                                        <span class="badge badge-pill badge-warning">Not Reconciled</span>
                                                    @endif
                                                    <br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($row->payments->count() > 0)
                                                @foreach($row->payments as $payment)
                                                    @if(isset($setting->date_format))
                                                    {{ date($setting->date_format, strtotime($payment->paid_at)) }}
                                                    @else
                                                    {{ date("Y-m-d", strtotime($payment->paid_at)) }}
                                                    @endif
                                                    <br>
                                                @endforeach
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                  @endforeach
                                </tbody>

                
                            </table>
                        </div>
                        @endisset
                        <!-- [ Data table ] end -->
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
@endsection