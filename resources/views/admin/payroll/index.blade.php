@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <!-- Enhanced Summary Cards -->
            <div class="col-xl-3 col-md-6">
                <div class="card bg-primary mb-4">
    <div class="card-body text-white" style="color: white !important;">
        <div class="d-flex justify-content-between">
            <div>
                <h6 style="color: white !important;">Total Employees</h6>
                <h3 style="color: white !important;">{{ $totalEmployees }}</h3>
            </div>
            <div class="align-self-center">
                <i class="fas fa-users fa-2x" style="color: white !important;"></i>
            </div>
        </div>
    </div>
</div>

            </div>
            <div class="col-xl-3 col-md-6">
    <div class="card bg-primary mb-4">
        <div class="card-body text-white" style="color: white !important;">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 style="color: white !important;">Active Payrolls</h6>
                    <h3 style="color: white !important;">{{ $activeRuns }}</h3>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-money-bill fa-2x" style="color: white !important;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-primary mb-4">
        <div class="card-body text-white" style="color: white !important;">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 style="color: white !important;">Pending Payments</h6>
                    <h3 style="color: white !important;">{{ $pendingPayments }}</h3>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-clock fa-2x" style="color: white !important;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-3 col-md-6">
    <div class="card bg-primary mb-4">
        <div class="card-body text-white" style="color: white !important;">
            <div class="d-flex justify-content-between">
                <div>
                    <h6 style="color: white !important;">This Month Net Pay</h6>
                    <h3 style="color: white !important;">KES {{ number_format($currentMonthNet, 2) }}</h3>
                </div>
                <div class="align-self-center">
                    <i class="fas fa-chart-line fa-2x" style="color: white !important;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

        </div>

        <div class="row">
            <!-- Recent Attendance with Internal Scroll -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Recent Attendance</h5>
                        <a href="{{ route('admin.staff-daily-attendance.index') }}" class="btn btn-sm btn-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-sm table-striped">
                                <thead style="position: sticky; top: 0; background: white; z-index: 1;">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Date</th>
                                        <th>Hours</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Get recent attendance from both tables (with conditional hours)
                                    $fixedAttendance = DB::table('staff_attendances')
                                        ->join('users', 'staff_attendances.user_id', '=', 'users.id')
                                        ->select(
                                            'users.first_name',
                                            'users.last_name',
                                            'staff_attendances.date',
                                            'staff_attendances.start_time',
                                            'staff_attendances.end_time',
                                            'staff_attendances.attendance',
                                            DB::raw("'Normal' as type"),
                                            DB::raw('CASE 
                                                WHEN staff_attendances.start_time IS NOT NULL AND staff_attendances.end_time IS NOT NULL 
                                                THEN TIMESTAMPDIFF(HOUR, staff_attendances.start_time, staff_attendances.end_time)
                                                ELSE NULL 
                                            END as hours_worked')
                                        )
                                        ->orderBy('staff_attendances.date', 'desc')
                                        ->limit(10);

                                    $recentAttendance = DB::table('staff_hourly_attendances')
                                        ->join('users', 'staff_hourly_attendances.user_id', '=', 'users.id')
                                        ->select(
                                            'users.first_name',
                                            'users.last_name',
                                            'staff_hourly_attendances.date',
                                            'staff_hourly_attendances.start_time',
                                            'staff_hourly_attendances.end_time',
                                            'staff_hourly_attendances.attendance',
                                            DB::raw("'Hourly' as type"),
                                            DB::raw('CASE 
                                                WHEN staff_hourly_attendances.start_time IS NOT NULL AND staff_hourly_attendances.end_time IS NOT NULL 
                                                THEN TIMESTAMPDIFF(HOUR, staff_hourly_attendances.start_time, staff_hourly_attendances.end_time)
                                                ELSE NULL 
                                            END as hours_worked')
                                        )
                                        ->union($fixedAttendance)
                                        ->orderBy('date', 'desc')
                                        ->limit(20)
                                        ->get();
                                    ?>

                                    @if($recentAttendance->count() > 0)
                                        @foreach($recentAttendance as $attendance)
                                        <tr>
                                            <td>{{ $attendance->first_name }} {{ $attendance->last_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                                            <td>
                                                @if($attendance->hours_worked)
                                                    <span class="badge bg-info">{{ $attendance->hours_worked }}h</span>
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($attendance->type == 'Normal')
                                                <span class="badge bg-primary">Normal</span>
                                                @else
                                                <span class="badge bg-warning">Hourly</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($attendance->attendance == 1)
                                                <span class="badge bg-success">Present</span>
                                                @elseif($attendance->attendance == 2)
                                                <span class="badge bg-danger">Absent</span>
                                                @elseif($attendance->attendance == 3)
                                                <span class="badge bg-info">Leave</span>
                                                @else
                                                <span class="badge bg-secondary">Holiday</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-3">No attendance records found</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enhanced Tax Settings Overview with Direct SQL -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Payroll Components Overview</h5>
                        <a href="{{ route('admin.payroll-components.index') }}" class="btn btn-sm btn-primary">Manage Components</a>
                    </div>
                    <div class="card-body">
                        <?php
                        // Direct SQL queries to get component statistics
                        $componentStats = DB::select("
                            SELECT 
                                type,
                                COUNT(*) as total,
                                SUM(CASE WHEN is_active = 1 THEN 1 ELSE 0 END) as active,
                                SUM(CASE WHEN is_statutory = 1 THEN 1 ELSE 0 END) as statutory,
                                SUM(CASE WHEN is_taxable = 1 THEN 1 ELSE 0 END) as taxable
                            FROM payroll_components 
                            GROUP BY type
                        ");

                        $earningComponents = DB::select("
                            SELECT * FROM payroll_components 
                            WHERE type = 'earning' AND is_active = 1 
                            ORDER BY name
                        ");

                        $deductionComponents = DB::select("
                            SELECT * FROM payroll_components 
                            WHERE type = 'deduction' AND is_active = 1 
                            ORDER BY name
                        ");

                        $calculationTypes = DB::select("
                            SELECT 
                                calculation_type,
                                COUNT(*) as count
                            FROM payroll_components 
                            WHERE is_active = 1
                            GROUP BY calculation_type
                        ");
                        ?>

                        <div class="row text-center mb-3">
                            @foreach($componentStats as $stat)
                            <div class="col-6 mb-3">
                                <div class="border rounded p-3 bg-light">
                                    <h6 class="text-{{ $stat->type == 'earning' ? 'success' : 'danger' }}">
                                        {{ ucfirst($stat->type) }} Components
                                    </h6>
                                    <h4 class="text-{{ $stat->type == 'earning' ? 'success' : 'danger' }}">
                                        {{ $stat->active }}/{{ $stat->total }}
                                    </h4>
                                    <small class="text-muted">
                                        Active: {{ $stat->active }} | 
                                        Statutory: {{ $stat->statutory }} |
                                        Taxable: {{ $stat->taxable }}
                                    </small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        
                        <div class="row text-center mb-3">
                            @foreach($calculationTypes as $calcType)
                            <div class="col-4">
                                <div class="border rounded p-2 bg-white">
                                    <small class="text-muted">{{ ucfirst($calcType->calculation_type) }}</small>
                                    <br>
                                    <strong class="text-primary">{{ $calcType->count }}</strong>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="mt-3">
                            <h6>Active Components Breakdown:</h6>
                            <div class="table-responsive" style="max-height: 200px; overflow-y: auto;">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Component Name</th>
                                            <th>Type</th>
                                            <th>Calculation</th>
                                            <th>Amount/Rate</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($earningComponents as $component)
                                        <tr>
                                            <td>
                                                <strong>{{ $component->name }}</strong>
                                                @if($component->is_statutory)
                                                <br><small class="text-warning">Statutory</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">Earning</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($component->calculation_type) }}</span>
                                            </td>
                                            <td>
                                                @if($component->calculation_type == 'percentage')
                                                {{ $component->percentage }}%
                                                @elseif($component->calculation_type == 'fixed')
                                                KES {{ number_format($component->default_amount, 2) }}
                                                @else
                                                Formula
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        @foreach($deductionComponents as $component)
                                        <tr>
                                            <td>
                                                <strong>{{ $component->name }}</strong>
                                                @if($component->is_statutory)
                                                <br><small class="text-warning">Statutory</small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-danger">Deduction</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">{{ ucfirst($component->calculation_type) }}</span>
                                            </td>
                                            <td>
                                                @if($component->calculation_type == 'percentage')
                                                {{ $component->percentage }}%
                                                @elseif($component->calculation_type == 'fixed')
                                                KES {{ number_format($component->default_amount, 2) }}
                                                @else
                                                Formula
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                        
                                        @if(count($earningComponents) == 0 && count($deductionComponents) == 0)
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">No active components found</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Payroll Runs Summary with Month Filter -->
        <div class="row mt-4">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Monthly Payroll Summary</h5>
                            <div>
                                <!-- Month Filter -->
                                <select id="monthFilter" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                    <option value="">All Months</option>
                                    <?php
                                    // Get unique months from payroll runs for filter
                                    $months = DB::select("
                                        SELECT 
                                            DISTINCT YEAR(run_date) as year,
                                            MONTH(run_date) as month,
                                            DATE_FORMAT(run_date, '%M %Y') as month_name
                                        FROM payroll_runs 
                                        ORDER BY run_date DESC
                                    ");
                                    ?>
                                    @foreach($months as $month)
                                    <option value="{{ $month->year }}-{{ $month->month }}">
                                        {{ $month->month_name }}
                                    </option>
                                    @endforeach
                                </select>
                                
                                <a href="{{ route($route.'.create') }}" class="btn btn-primary btn-sm ms-2">
                                    <i class="fas fa-plus"></i> Generate New Payroll
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($monthlyRuns->count() > 0)
                            @foreach($monthlyRuns as $monthly)
                            <div class="card mb-3 monthly-section" data-month="{{ $monthly->year }}-{{ $monthly->month }}">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">
                                        <i class="fas fa-calendar-alt me-2"></i>
                                        {{ $monthly->month_name }}
                                        <span class="badge bg-primary ms-2">{{ $monthly->run_count }} Run(s)</span>
                                        
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body text-center p-2">
                                                    <strong>Total Gross</strong><br>
                                                    KES {{ number_format($monthly->total_gross, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body text-center p-2">
                                                    <strong>Total Tax</strong><br>
                                                    KES {{ number_format($monthly->total_tax, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body text-center p-2">
                                                    <strong>Total Net Pay</strong><br>
                                                    KES {{ number_format($monthly->total_net, 2) }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card bg-primary text-white">
                                                <div class="card-body text-center p-2">
                                                    <strong>Success Rate</strong><br>
                                                    {{ $monthly->total_employees > 0 ? round(($monthly->successful_entries / $monthly->total_employees) * 100, 1) : 0 }}%
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Individual runs for this month -->
                                    <div class="table-responsive">
                                        <table class="table table-sm table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Run Date</th>
                                                    <th>Period</th>
                                                    <th>Employees</th>
                                                    <th>Gross</th>
                                                    <th>Tax</th>
                                                    <th>Net Pay</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($monthly->runs as $run)
                                                <?php
                                                // Direct SQL to get accurate counts and totals for this run
                                                $runDetails = DB::select("
                                                    SELECT 
                                                        COUNT(*) as employee_count,
                                                        COALESCE(SUM(gross_earnings), 0) as total_gross,
                                                        COALESCE(SUM(paye_net), 0) as total_tax,
                                                        COALESCE(SUM(net_pay), 0) as total_net
                                                    FROM payroll_entries 
                                                    WHERE payroll_run_id = ?
                                                ", [$run->id]);
                                                
                                                $details = $runDetails[0] ?? null;
                                                ?>
                                                <tr>
                                                    <td>{{ $run->run_date->format('d M Y') }}</td>
                                                    <td>{{ $run->period->name ?? 'N/A' }}</td>
                                                    <td>
                                                        <span class="badge bg-primary">{{ $details->employee_count ?? 0 }}</span>
                                                    </td>
                                                    <td>KES {{ number_format($details->total_gross ?? 0, 2) }}</td>
                                                    <td>KES {{ number_format($details->total_tax ?? 0, 2) }}</td>
                                                    <td><strong>KES {{ number_format($details->total_net ?? 0, 2) }}</strong></td>
                                                    <td>
                                                        <span class="badge bg-{{ $run->status == 'computed' ? 'warning' : ($run->status == 'paid' ? 'success' : 'secondary') }}">
                                                            {{ ucfirst($run->status) }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group btn-group-sm">
                                                            <a href="{{ route($route.'.run.show', $run->id) }}" class="btn btn-info" title="View Details">
                                                                <i class="fas fa-eye"></i>
                                                            </a>
                                                            
                                                        </div>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-money-bill-wave fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">No payroll runs found</h5>
                                <p class="text-muted">Generate your first payroll run to see the summary here.</p>
                                <a href="{{ route($route.'.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Generate Payroll
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript for Month Filter -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const monthFilter = document.getElementById('monthFilter');
    
    if (monthFilter) {
        monthFilter.addEventListener('change', function() {
            const selectedMonth = this.value;
            const monthlySections = document.querySelectorAll('.monthly-section');
            
            monthlySections.forEach(section => {
                if (selectedMonth === '' || section.getAttribute('data-month') === selectedMonth) {
                    section.style.display = 'block';
                } else {
                    section.style.display = 'none';
                }
            });
        });
    }
});
</script>

@endsection