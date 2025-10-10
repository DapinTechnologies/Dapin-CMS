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
                        <form class="needs-validation" novalidate method="get" action="{{ route($route.'.report') }}">
                            <div class="row gx-2">
                                <!-- Filter form fields remain the same -->
                                <div class="form-group col-md-3">
                                    <label for="salary_type">{{ __('field_salary_type') }} <span>*</span></label>
                                    <select class="form-control" name="salary_type" id="salary_type" required>
                                        <option value="">{{ __('select') }}</option>
                                        <option value="1" @if($selected_salary_type == 1) selected @endif>{{ __('salary_type_fixed') }}</option>
                                        <option value="2" @if($selected_salary_type == 2) selected @endif>{{ __('salary_type_hourly') }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_salary_type') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="department">{{ __('field_department') }}</label>
                                    <select class="form-control" name="department" id="department">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach( $departments as $department )
                                        <option value="{{ $department->id }}" @if( $selected_department == $department->id) selected @endif>{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_department') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="designation">{{ __('field_designation') }}</label>
                                    <select class="form-control" name="designation" id="designation">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach( $designations as $designation )
                                        <option value="{{ $designation->id }}" @if( $selected_designation == $designation->id) selected @endif>{{ $designation->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_designation') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="contract_type">{{ __('field_contract_type') }} </label>
                                    <select class="form-control" name="contract_type" id="contract_type">
                                        <option value="">{{ __('all') }}</option>
                                        <option value="1" {{ $selected_contract == 1 ? 'selected' : '' }}>{{ __('contract_type_full_time') }}</option>
                                        <option value="2" {{ $selected_contract == 2 ? 'selected' : '' }}>{{ __('contract_type_part_time') }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_contract_type') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="shift">{{ __('field_work_shift') }}</label>
                                    <select class="form-control" name="shift" id="shift">
                                        <option value="">{{ __('all') }}</option>
                                        @foreach( $work_shifts as $shift )
                                        <option value="{{ $shift->id }}" @if( $selected_shift == $shift->id) selected @endif>{{ $shift->title }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_work_shift') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="month">{{ __('field_month') }} <span>*</span></label>
                                    <select class="form-control" name="month" id="month" required>
                                        <option value="1" @if($selected_month == 1) selected @endif>{{ __('month_january') }}</option>
                                        <option value="2" @if($selected_month == 2) selected @endif>{{ __('month_february') }}</option>
                                        <option value="3" @if($selected_month == 3) selected @endif>{{ __('month_march') }}</option>
                                        <option value="4" @if($selected_month == 4) selected @endif>{{ __('month_april') }}</option>
                                        <option value="5" @if($selected_month == 5) selected @endif>{{ __('month_may') }}</option>
                                        <option value="6" @if($selected_month == 6) selected @endif>{{ __('month_june') }}</option>
                                        <option value="7" @if($selected_month == 7) selected @endif>{{ __('month_july') }}</option>
                                        <option value="8" @if($selected_month == 8) selected @endif>{{ __('month_august') }}</option>
                                        <option value="9" @if($selected_month == 9) selected @endif>{{ __('month_september') }}</option>
                                        <option value="10" @if($selected_month == 10) selected @endif>{{ __('month_october') }}</option>
                                        <option value="11" @if($selected_month == 11) selected @endif>{{ __('month_november') }}</option>
                                        <option value="12" @if($selected_month == 12) selected @endif>{{ __('month_december') }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_month') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="year">{{ __('field_year') }} <span>*</span></label>
                                    <select class="form-control" name="year" id="year" required>
                                        <option value="{{ date("Y") }}" @if($selected_year == date("Y")) selected @endif>{{ date("Y") }}</option>
                                        <option value="{{ date("Y") - 1 }}" @if($selected_year == date("Y") - 1) selected @endif>{{ date("Y") - 1 }}</option>
                                        <option value="{{ date("Y") - 2 }}" @if($selected_year == date("Y") - 2) selected @endif>{{ date("Y") - 2 }}</option>
                                        <option value="{{ date("Y") - 3 }}" @if($selected_year == date("Y") - 3) selected @endif>{{ date("Y") - 3 }}</option>
                                        <option value="{{ date("Y") - 4 }}" @if($selected_year == date("Y") - 4) selected @endif>{{ date("Y") - 4 }}</option>
                                        <option value="{{ date("Y") - 5 }}" @if($selected_year == date("Y") - 5) selected @endif>{{ date("Y") - 5 }}</option>
                                        <option value="{{ date("Y") - 6 }}" @if($selected_year == date("Y") - 6) selected @endif>{{ date("Y") - 6 }}</option>
                                        <option value="{{ date("Y") - 7 }}" @if($selected_year == date("Y") - 7) selected @endif>{{ date("Y") - 7 }}</option>
                                        <option value="{{ date("Y") - 8 }}" @if($selected_year == date("Y") - 8) selected @endif>{{ date("Y") - 8 }}</option>
                                        <option value="{{ date("Y") - 9 }}" @if($selected_year == date("Y") - 9) selected @endif>{{ date("Y") - 9 }}</option>
                                    </select>
                                    <div class="invalid-feedback">
                                      {{ __('required_field') }} {{ __('field_year') }}
                                    </div>
                                </div>
                                <div class="form-group col-md-3">
                                    <button type="submit" class="btn btn-info btn-filter"><i class="fas fa-search"></i> {{ __('btn_filter') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Enhanced Report Dashboard -->
            @if(isset($report_data))
            <div class="col-sm-12">
                <!-- Summary Statistics Cards -->
                <div class="row">
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-purple">{{ number_format($report_data['summary']['total_net_pay'] ?? 0, 2) }}</h4>
                                        <h6 class="text-muted m-b-0">{{ __('Total Net Pay') }}</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fas fa-wallet f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-green">{{ $report_data['summary']['total_employees'] ?? 0 }}</h4>
                                        <h6 class="text-muted m-b-0">{{ __('Total Employees') }}</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fas fa-users f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-red">{{ number_format($report_data['summary']['total_deductions'] ?? 0, 2) }}</h4>
                                        <h6 class="text-muted m-b-0">{{ __('Total Deductions') }}</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fas fa-hand-holding-usd f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6">
                        <div class="card">
                            <div class="card-block">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="text-c-blue">{{ number_format($report_data['summary']['average_salary'] ?? 0, 2) }}</h4>
                                        <h6 class="text-muted m-b-0">{{ __('Average Salary') }}</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fas fa-chart-line f-28"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts and Graphs Section -->
                <div class="row">
                    <!-- Department-wise Distribution -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Department-wise Salary Distribution') }}</h5>
                            </div>
                            <div class="card-block">
                                <canvas id="departmentChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Comparison -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Monthly Salary Comparison') }} ({{ $selected_year }})</h5>
                            </div>
                            <div class="card-block">
                                <canvas id="monthlyChart" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deduction Type Performance Table -->
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Deduction Type Performance Summary') }}</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Deduction Type') }}</th>
                                                <th>{{ __('Total Amount') }}</th>
                                                <th>{{ __('Average per Employee') }}</th>
                                                <th>{{ __('Employee Count') }}</th>
                                                <th>{{ __('% of Total Deductions') }}</th>
                                                <th>{{ __('Status') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalDeductions = $report_data['summary']['total_deductions'] ?? 0;
                                                $deductionTypes = $report_data['deduction_analysis'] ?? [];
                                            @endphp
                                            
                                            @forelse($deductionTypes as $deduction)
                                            <tr>
                                                <td>{{ $deduction->deduction_name ?? $deduction->component_name ?? 'N/A' }}</td>
                                                <td>{{ number_format($deduction->total_amount ?? 0, 2) }}</td>
                                                <td>{{ number_format($deduction->average_amount ?? 0, 2) }}</td>
                                                <td>{{ $deduction->employee_count ?? 0 }}</td>
                                                <td>
                                                    @php
                                                        $percentage = $totalDeductions > 0 ? (($deduction->total_amount ?? 0) / $totalDeductions) * 100 : 0;
                                                    @endphp
                                                    {{ number_format($percentage, 1) }}%
                                                </td>
                                                <td>
                                                    @php
                                                        $employeeCount = $deduction->employee_count ?? 0;
                                                        $totalEmployees = $report_data['summary']['total_employees'] ?? 1;
                                                        $coveragePercentage = ($employeeCount / $totalEmployees) * 100;
                                                    @endphp
                                                    @if($coveragePercentage >= 80)
                                                        <span class="badge badge-success">{{ __('High Coverage') }}</span>
                                                    @elseif($coveragePercentage >= 50)
                                                        <span class="badge badge-warning">{{ __('Medium Coverage') }}</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ __('Low Coverage') }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">{{ __('No deduction data available') }}</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                        @if(count($deductionTypes) > 0)
                                        <tfoot>
                                            <tr class="table-primary">
                                                <td><strong>{{ __('Total') }}</strong></td>
                                                <td><strong>{{ number_format($totalDeductions, 2) }}</strong></td>
                                                <td><strong>{{ number_format($totalDeductions / ($report_data['summary']['total_employees'] ?? 1), 2) }}</strong></td>
                                                <td><strong>{{ $report_data['summary']['total_employees'] ?? 0 }}</strong></td>
                                                <td><strong>100%</strong></td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detailed Tables Section -->
                <div class="row">
                    <!-- Staff Analysis by Department -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Staff Analysis by Department') }}</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Department') }}</th>
                                                <th>{{ __('Employee Count') }}</th>
                                                <th>{{ __('Total Gross') }}</th>
                                                <th>{{ __('Total Net') }}</th>
                                                <th>{{ __('Average Salary') }}</th>
                                                <th>{{ __('Total Deductions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($report_data['department_analysis'] as $dept)
                                            <tr>
                                                <td>{{ $dept->department_name }}</td>
                                                <td>{{ $dept->employee_count }}</td>
                                                <td>{{ number_format($dept->total_gross, 2) }}</td>
                                                <td>{{ number_format($dept->total_net, 2) }}</td>
                                                <td>{{ number_format($dept->avg_salary, 2) }}</td>
                                                <td>{{ number_format($dept->total_deductions, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Teacher/Staff Detailed Information -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{ __('Staff Detailed Information') }}</h5>
                            </div>
                            <div class="card-block">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>{{ __('Staff ID') }}</th>
                                                <th>{{ __('Name') }}</th>
                                                <th>{{ __('Department') }}</th>
                                                <th>{{ __('Designation') }}</th>
                                                <th>{{ __('Gross Salary') }}</th>
                                                <th>{{ __('Net Salary') }}</th>
                                                <th>{{ __('Contract Type') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($report_data['staff_analysis'] as $staff)
                                            <tr>
                                                <td>#{{ $staff->staff_id }}</td>
                                                <td>{{ $staff->first_name }} {{ $staff->last_name }}</td>
                                                <td>{{ $staff->department }}</td>
                                                <td>{{ $staff->designation }}</td>
                                                <td>{{ number_format($staff->gross_salary, 2) }}</td>
                                                <td>{{ number_format($staff->current_salary, 2) }}</td>
                                                <td>
                                                    @if($staff->contract_type == 1)
                                                    {{ __('Full Time') }}
                                                    @elseif($staff->contract_type == 2)
                                                    {{ __('Part Time') }}
                                                    @endif
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
            @endif

            <!-- Original Payroll Table (Keep existing functionality) -->
            
        </div>
        <!-- [ Main Content ] end -->
    </div>
</div>
<!-- End Content-->

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(isset($report_data))
    // Department Chart
    const deptCtx = document.getElementById('departmentChart').getContext('2d');
    const deptChart = new Chart(deptCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($report_data['department_analysis']->pluck('department_name')) !!},
            datasets: [{
                label: 'Total Net Salary',
                data: {!! json_encode($report_data['department_analysis']->pluck('total_net')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Monthly Comparison Chart
    const monthlyCtx = document.getElementById('monthlyChart').getContext('2d');
    const monthlyChart = new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(collect($report_data['monthly_comparison'])->pluck('month')) !!},
            datasets: [{
                label: 'Net Salary',
                data: {!! json_encode(collect($report_data['monthly_comparison'])->pluck('total_net')) !!},
                borderColor: 'rgba(75, 192, 192, 1)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.4
            }]
        },
        options: {
            responsive: true
        }
    });
    @endif
});
</script>

@endsection