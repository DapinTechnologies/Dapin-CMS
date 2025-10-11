@extends('admin.layouts.master')
@section('title', $title)
@section('content')

<style>
    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }
        .print-modal, .print-modal * {
            visibility: visible;
        }
        .print-modal {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            max-width: 100%;
            box-shadow: none;
            border: none;
        }
        .no-print {
            display: none !important;
        }
        .page-break {
            page-break-after: always;
        }
    }
    
    /* Payslip and Report Styling */
    .payslip-container, .report-container {
        font-family: Arial, sans-serif;
        max-width: 100%;
        margin: 0 auto;
        background: white;
        color: #333;
        overflow-x: hidden;
    }
    
    .payslip-header, .report-header {
        text-align: center;
        border-bottom: 2px solid #333;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    
    .payslip-title, .report-title {
        font-size: 24px;
        font-weight: bold;
        margin-bottom: 5px;
    }
    
    .payslip-subtitle, .report-subtitle {
        font-size: 16px;
        color: #666;
    }
    
    .payslip-section, .report-section {
        margin-bottom: 20px;
        overflow-x: auto;
    }
    
    .payslip-table, .report-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        min-width: 600px; /* Ensure tables don't get too small */
    }
    
    .payslip-table th, .payslip-table td,
    .report-table th, .report-table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: left;
        word-wrap: break-word;
    }
    
    .payslip-table th, .report-table th {
        background-color: #f5f5f5;
        font-weight: bold;
    }
    
    .payslip-totals, .report-totals {
        font-weight: bold;
        background-color: #f9f9f9;
    }
    
    .text-right {
        text-align: right;
    }
    
    .text-center {
        text-align: center;
    }
    
    .employee-info {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 15px;
        gap: 15px;
    }
    
    .info-block {
        flex: 1;
        min-width: 300px;
    }
    
    .info-label {
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 14px;
    }
    
    .modal-xl {
        max-width: 95%;
        margin: 1rem auto;
    }
    
    /* Responsive fixes for mobile */
    @media (max-width: 768px) {
        .modal-xl {
            max-width: 98%;
            margin: 0.5rem auto;
        }
        
        .payslip-table, .report-table {
            font-size: 12px;
        }
        
        .payslip-table th, .payslip-table td,
        .report-table th, .report-table td {
            padding: 6px 4px;
        }
        
        .employee-info {
            flex-direction: column;
        }
        
        .info-block {
            min-width: 100%;
        }
        
        .payslip-title, .report-title {
            font-size: 20px;
        }
        
        .payslip-subtitle, .report-subtitle {
            font-size: 14px;
        }
    }
    
    @media (max-width: 576px) {
        .payslip-table, .report-table {
            font-size: 11px;
            min-width: 500px;
        }
        
        .payslip-table th, .payslip-table td,
        .report-table th, .report-table td {
            padding: 4px 2px;
        }
        
        .modal-xl .modal-body {
            padding: 10px;
        }
    }
    
    /* Fix for modal backdrop and scrolling */
    .modal {
        backdrop-filter: blur(5px);
    }
    
    .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }
    
    /* Ensure proper z-index for modals */
    .modal-backdrop {
        z-index: 1040;
    }
    
    .modal {
        z-index: 1050;
    }
    
    /* Fix for table row collapse conflicts */
    .collapse-row {
        border: none !important;
    }
    
    .collapse-row > td {
        padding: 0 !important;
        border: none !important;
    }
    
    .collapse-row .card {
        margin: 0;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
</style>

<div class="main-body">
    <div class="page-wrapper">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Payroll Run: {{ $run->period->name }}</h5>
                        <div class="float-end">
                            <!-- Master Report and Back buttons at top right -->
                            <div class="btn-group">
    <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#masterReportModal">
        <i class="fas fa-file-excel"></i> Master Report
    </button>
    <button type="button" class="btn btn-light" onclick="window.location='{{ route($route.'.index') }}'">
        <i class="fas fa-arrow-right"></i> Back
    </button>
</div>

                        </div>
                    </div>
                    <div class="card-body">
                        <!-- Enhanced Summary Statistics -->
                        <div class="row mb-4">
                            <div class="col-md-2 col-6 mb-2">
                                <div class="card bg-light">
                                    <div class="card-body text-center p-2">
                                        <strong>Run Date</strong><br>
                                        {{ $run->run_date->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="card bg-light">
                                    <div class="card-body text-center p-2">
                                        <strong>Employees</strong><br>
                                        {{ $run->entries->count() }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center p-2">
                                        <strong>Total Gross</strong><br>
                                        KES {{ number_format($run->entries->sum('gross_earnings'), 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center p-2">
                                        <strong>Total Net Pay</strong><br>
                                        KES {{ number_format($run->entries->sum('net_pay'), 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center p-2">
                                        <strong>Total Deductions</strong><br>
                                        KES {{ number_format($run->entries->sum('total_deductions'), 2) }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6 mb-2">
                                <div class="card bg-{{ $run->entries->where('is_paid', false)->count() > 0 ? 'warning' : 'success' }} text-white">
                                    <div class="card-body text-center p-2">
                                        <strong>Paid</strong><br>
                                        {{ $run->entries->where('is_paid', true)->count() }}/{{ $run->entries->count() }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mb-3">
                            <div class="col-md-12 text-end">
                                <div class="btn-group flex-wrap">
                                    <!-- Bulk Pay Button - Always Active -->
                                    <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#bulkPayModal">
                                        <i class="fas fa-money-bill-wave"></i> Bulk Pay All ({{ $run->entries->where('is_paid', false)->count() }})
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Detailed Payroll Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead class="table-light">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Basic Salary</th>
                                        <th>Allowances</th>
                                        <th>Gross Pay</th>
                                        <th>Taxable Amount</th>
                                        <th>Tax & Deductions</th>
                                        <th>Net Pay</th>
                                        <th>Attendance</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($run->entries as $entry)
                                    @php
                                        // Get the draft data for detailed breakdown
                                        $draft = App\Models\EmployeePayrollDraft::where('user_id', $entry->user_id)
                                            ->where('payroll_period_id', $run->payroll_period_id)
                                            ->first();
                                        
                                        $selectedComponents = $draft ? json_decode($draft->selected_components, true) : [];
                                        $customAllowances = $draft ? json_decode($draft->custom_allowances, true) : [];
                                        $customDeductions = $draft ? json_decode($draft->custom_deductions, true) : [];
                                        
                                        // Calculate attendance ratio
                                        $attendanceRatio = $entry->working_days > 0 ? ($entry->attendance_days / $entry->working_days) * 100 : 0;
                                        $attendanceClass = $attendanceRatio >= 90 ? 'success' : ($attendanceRatio >= 70 ? 'warning' : 'danger');
                                    @endphp
                                    <tr class="{{ $entry->is_paid ? 'table-success' : '' }}">
                                        <td>
                                            <strong>{{ $entry->user->first_name }} {{ $entry->user->last_name }}</strong><br>
                                            <small class="text-muted">{{ $entry->user->staff_id ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            KES {{ number_format($entry->basic_salary, 2) }}
                                            @if($entry->basic_salary != $entry->user->basic_salary && $entry->user->payment_type == 'hourly')
                                            <br><small class="text-muted">(Prorated: {{ $entry->attendance_days }}/{{ $entry->working_days }} days)</small>
                                            @elseif($entry->user->payment_type == 'fixed')
                                            <br><small class="text-muted">(Fixed Salary)</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small>
                                                <strong>Total: KES {{ number_format($entry->taxable_allowances + $entry->non_taxable_allowances, 2) }}</strong><br>
                                                @if($entry->overtime_earnings > 0)
                                                Overtime: KES {{ number_format($entry->overtime_earnings, 2) }}<br>
                                                @endif
                                                @if($entry->bonuses > 0)
                                                Bonuses: KES {{ number_format($entry->bonuses, 2) }}<br>
                                                @endif
                                                <button class="btn btn-sm btn-outline-info mt-1" type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#allowanceDetails{{ $entry->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="allowanceDetails{{ $entry->id }}">
                                                    View Details
                                                </button>
                                            </small>
                                        </td>
                                        <td><strong class="text-primary">KES {{ number_format($entry->gross_earnings, 2) }}</strong></td>
                                        <td>KES {{ number_format($entry->taxable_earnings, 2) }}</td>
                                        <td>
                                            <small>
                                                <strong>Total: KES {{ number_format($entry->total_deductions, 2) }}</strong><br>
                                                @if($entry->paye_net > 0)
                                                PAYE: KES {{ number_format($entry->paye_net, 2) }}<br>
                                                @endif
                                                @if($entry->loan_deductions > 0)
                                                Loans: KES {{ number_format($entry->loan_deductions, 2) }}<br>
                                                @endif
                                                @if($entry->other_deductions > 0)
                                                Others: KES {{ number_format($entry->other_deductions, 2) }}<br>
                                                @endif
                                                <button class="btn btn-sm btn-outline-info mt-1" type="button" 
                                                        data-bs-toggle="collapse" 
                                                        data-bs-target="#deductionDetails{{ $entry->id }}"
                                                        aria-expanded="false"
                                                        aria-controls="deductionDetails{{ $entry->id }}">
                                                    View Details
                                                </button>
                                            </small>
                                        </td>
                                        <td class="text-success"><strong>KES {{ number_format($entry->net_pay, 2) }}</strong></td>
                                        <td>
                                            <span class="badge bg-{{ $attendanceClass }}">
                                                {{ $entry->attendance_days }}/{{ $entry->working_days }} days
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                {{ number_format($attendanceRatio, 1) }}%
                                            </small>
                                        </td>
                                        <td>
                                            @if($entry->is_paid)
                                            <span class="badge bg-success">Paid</span>
                                            <br><small>{{ $entry->paid_at ? $entry->paid_at->format('d M Y') : '' }}</small>
                                            @else
                                            <span class="badge bg-warning">Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                                <!-- Updated Payslip Button to Open Modal -->
                                                <button class="btn btn-info btn-sm" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#payslipModal{{ $entry->id }}" 
                                                        title="View Payslip">
                                                    <i class="fas fa-file-invoice"></i>
                                                </button>

                                                @if(!$entry->is_paid)
                                                    <button class="btn btn-success btn-sm" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#payModal{{ $entry->id }}" 
                                                            title="Record Payment">
                                                        <i class="fas fa-money-bill-wave"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-secondary btn-sm" 
                                                            disabled 
                                                            title="Already Paid">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Allowance Details Collapse -->
                                    <tr class="collapse collapse-row" id="allowanceDetails{{ $entry->id }}">
                                        <td colspan="10">
                                            <div class="card card-body">
                                                <h6>Allowance Breakdown</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Component Allowances:</strong>
                                                        <ul class="list-unstyled">
                                                            @php
                                                                $componentAllowances = array_filter($selectedComponents, function($comp) {
                                                                    return $comp['type'] === 'earning';
                                                                });
                                                            @endphp
                                                            @foreach($componentAllowances as $component)
                                                            <li>
                                                                {{ $component['name'] }}: 
                                                                KES {{ number_format($component['amount'], 2) }}
                                                                @if(isset($component['is_taxable']))
                                                                <span class="badge bg-{{ $component['is_taxable'] ? 'warning' : 'success' }}">
                                                                    {{ $component['is_taxable'] ? 'Taxable' : 'Non-Taxable' }}
                                                                </span>
                                                                @endif
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Custom Allowances:</strong>
                                                        <ul class="list-unstyled">
                                                            @foreach($customAllowances as $allowance)
                                                            <li>
                                                                {{ $allowance['name'] }}: 
                                                                KES {{ number_format($allowance['amount'], 2) }}
                                                                <span class="badge bg-{{ $allowance['is_taxable'] ? 'warning' : 'success' }}">
                                                                    {{ $allowance['is_taxable'] ? 'Taxable' : 'Non-Taxable' }}
                                                                </span>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                        <hr>
                                                        <p><strong>Taxable Allowances:</strong> KES {{ number_format($entry->taxable_allowances, 2) }}</p>
                                                        <p><strong>Non-Taxable Allowances:</strong> KES {{ number_format($entry->non_taxable_allowances, 2) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Deduction Details Collapse -->
                                    <tr class="collapse collapse-row" id="deductionDetails{{ $entry->id }}">
                                        <td colspan="10">
                                            <div class="card card-body">
                                                <h6>Deduction Breakdown</h6>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <strong>Component Deductions:</strong>
                                                        <ul class="list-unstyled">
                                                            @php
                                                                $componentDeductions = array_filter($selectedComponents, function($comp) {
                                                                    return $comp['type'] === 'deduction';
                                                                });
                                                            @endphp
                                                            @foreach($componentDeductions as $component)
                                                            <li>
                                                                {{ $component['name'] }}: 
                                                                KES {{ number_format($component['amount'], 2) }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Custom Deductions:</strong>
                                                        <ul class="list-unstyled">
                                                            @foreach($customDeductions as $deduction)
                                                            <li>
                                                                {{ $deduction['name'] }}: 
                                                                KES {{ number_format($deduction['amount'], 2) }}
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                        <hr>
                                                        <p><strong>PAYE Tax:</strong> KES {{ number_format($entry->paye_net, 2) }}</p>
                                                        <p><strong>Loan Deductions:</strong> KES {{ number_format($entry->loan_deductions, 2) }}</p>
                                                        <p><strong>Other Deductions:</strong> KES {{ number_format($entry->other_deductions, 2) }}</p>
                                                    </div>
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

<!-- Payslip Modals - Moved outside the table loop to prevent conflicts -->
@foreach($run->entries as $entry)
<!-- Payslip Modal for each employee -->
<div class="modal fade print-modal" id="payslipModal{{ $entry->id }}" tabindex="-1" aria-labelledby="payslipModalLabel{{ $entry->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h5 class="modal-title" id="payslipModalLabel{{ $entry->id }}">Payslip - {{ $entry->user->first_name }} {{ $entry->user->last_name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="payslip-container">
                    <!-- Payslip Header -->
                    <div class="payslip-header">
                        <div class="payslip-title">Annani Technical College</div>
                        <div class="payslip-subtitle">Kenya</div>
                        <div class="payslip-subtitle">Salary Slip - {{ $entry->user->first_name }} {{ $entry->user->last_name }} - {{ $run->period->name }}</div>
                    </div>

                   <!-- Employee Information -->
<div class="employee-info">
    <div class="info-block">
        <div class="info-label">EMPLOYEE INFORMATION</div>
        <div>Name: {{ $entry->user->first_name }} {{ $entry->user->last_name }}</div>
        <div>ID: {{ $entry->user->staff_id ?? 'No ID number on the employee !!!' }}</div>
        <div>Job Position: {{ $entry->user->position ?? 'Trainer' }}</div>
        <div>Department: {{ $entry->user->department ?? 'Administration / Teaching Staff' }}</div>
        <div>Marital Status: {{ $entry->user->marital_status ?? 'Single' }}</div>
        
        <!-- New Fields with Advanced PHP Logic -->
        <?php
        $user = $entry->user;
        $hasDeductionInfo = $user->kra_pin || $user->nssf_number || $user->sha_number || $user->nhif;
        
        if ($hasDeductionInfo) {
            echo '<div class="info-label" style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #ccc;">DEDUCTION INFORMATION</div>';
            
            if ($user->kra_pin) {
                echo '<div>KRA Pin: ' . e($user->kra_pin) . '</div>';
            }
            
            if ($user->nssf_number) {
                echo '<div>NSSF Number: ' . e($user->nssf_number) . '</div>';
            }
            
            if ($user->sha_number) {
                echo '<div>SHA Number: ' . e($user->sha_number) . '</div>';
            }
            
            if ($user->nhif) {
                echo '<div>NHIF: ' . e($user->nhif) . '</div>';
            }
        } else {
            echo '<div style="color: #666; font-style: italic;">No deduction information provided</div>';
        }
        ?>
    </div>
    <div class="info-block">
        <div class="info-label">OTHER INFORMATION</div>
        <div>Contract Wage (Monthly): {{ number_format($entry->user->basic_salary, 2) }} KSh</div>
        <div>Pay Period: {{ $run->period->start_date->format('m/d/Y') }} - {{ $run->period->end_date->format('m/d/Y') }}</div>
        <div>Computed On: {{ $run->run_date->format('m/d/Y') }}</div>
        <div>Contract Start Date: {{ $entry->user->contract_start_date ? $entry->user->contract_start_date->format('m/d/Y') : 'N/A' }}</div>
        <div>Contract Type: {{ $entry->user->contract_type ?? 'Permanent' }}</div>
        <div>Working Schedule: 40.0 Hours / Week</div>
    </div>
</div>

                    @php
                        // Get detailed breakdown from database
                        $draft = App\Models\EmployeePayrollDraft::where('user_id', $entry->user_id)
                            ->where('payroll_period_id', $run->payroll_period_id)
                            ->first();
                        
                        $selectedComponents = $draft ? json_decode($draft->selected_components, true) : [];
                        $customAllowances = $draft ? json_decode($draft->custom_allowances, true) : [];
                        $customDeductions = $draft ? json_decode($draft->custom_deductions, true) : [];
                        
                        // Separate components by type
                        $componentAllowances = array_filter($selectedComponents, function($comp) {
                            return $comp['type'] === 'earning';
                        });
                        $componentDeductions = array_filter($selectedComponents, function($comp) {
                            return $comp['type'] === 'deduction';
                        });
                    @endphp

                    <!-- Detailed Earnings Breakdown -->
                    <div class="payslip-section">
                        <h5>Earnings Breakdown</h5>
                        <table class="payslip-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                    <th>Taxable</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Basic Salary -->
                                <tr>
                                    <td>Basic Salary</td>
                                    <td>Basic Salary</td>
                                    <td>{{ number_format($entry->basic_salary, 2) }} KSh</td>
                                    <td>Yes</td>
                                </tr>
                                
                                <!-- Component Allowances -->
                                @foreach($componentAllowances as $component)
                                <tr>
                                    <td>Component Allowance</td>
                                    <td>{{ $component['name'] }}</td>
                                    <td>{{ number_format($component['amount'], 2) }} KSh</td>
                                    <td>{{ $component['is_taxable'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                @endforeach
                                
                                <!-- Custom Allowances -->
                                @foreach($customAllowances as $allowance)
                                <tr>
                                    <td>Custom Allowance</td>
                                    <td>{{ $allowance['name'] }}</td>
                                    <td>{{ number_format($allowance['amount'], 2) }} KSh</td>
                                    <td>{{ $allowance['is_taxable'] ? 'Yes' : 'No' }}</td>
                                </tr>
                                @endforeach
                                
                                <!-- Overtime -->
                                @if($entry->overtime_earnings > 0)
                                <tr>
                                    <td>Overtime</td>
                                    <td>Overtime Earnings</td>
                                    <td>{{ number_format($entry->overtime_earnings, 2) }} KSh</td>
                                    <td>Yes</td>
                                </tr>
                                @endif
                                
                                <!-- Bonuses -->
                                @if($entry->bonuses > 0)
                                <tr>
                                    <td>Bonus</td>
                                    <td>Bonus Payment</td>
                                    <td>{{ number_format($entry->bonuses, 2) }} KSh</td>
                                    <td>Yes</td>
                                </tr>
                                @endif
                                
                                <tr class="payslip-totals">
                                    <td colspan="2"><strong>Total Earnings</strong></td>
                                    <td colspan="2"><strong>{{ number_format($entry->gross_earnings, 2) }} KSh</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Detailed Deductions Breakdown -->
                    <div class="payslip-section">
                        <h5>Deductions Breakdown</h5>
                        <table class="payslip-table">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Component Deductions -->
                                @foreach($componentDeductions as $component)
                                <tr>
                                    <td>Component Deduction</td>
                                    <td>{{ $component['name'] }}</td>
                                    <td>{{ number_format($component['amount'], 2) }} KSh</td>
                                </tr>
                                @endforeach
                                
                                <!-- Custom Deductions -->
                                @foreach($customDeductions as $deduction)
                                <tr>
                                    <td>Custom Deduction</td>
                                    <td>{{ $deduction['name'] }}</td>
                                    <td>{{ number_format($deduction['amount'], 2) }} KSh</td>
                                </tr>
                                @endforeach
                                
                                <!-- PAYE Tax -->
                                @if($entry->paye_net > 0)
                                <tr>
                                    <td>Tax</td>
                                    <td>PAYE</td>
                                    <td>{{ number_format($entry->paye_net, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                <!-- NSSF -->
                                @if($entry->nssf > 0)
                                <tr>
                                    <td>Statutory</td>
                                    <td>NSSF</td>
                                    <td>{{ number_format($entry->nssf, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                <!-- Loan Deductions -->
                                @if($entry->loan_deductions > 0)
                                <tr>
                                    <td>Loan</td>
                                    <td>Loan Deductions</td>
                                    <td>{{ number_format($entry->loan_deductions, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                <!-- Other Deductions -->
                                @if($entry->other_deductions > 0)
                                <tr>
                                    <td>Other</td>
                                    <td>Other Deductions</td>
                                    <td>{{ number_format($entry->other_deductions, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                <tr class="payslip-totals">
                                    <td colspan="2"><strong>Total Deductions</strong></td>
                                    <td><strong>{{ number_format($entry->total_deductions, 2) }} KSh</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Section -->
                    <div class="payslip-section">
                        <table class="payslip-table">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th>Amount (KSh)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Gross Salary</td>
                                    <td>{{ number_format($entry->gross_earnings, 2) }}</td>
                                </tr>
                                <tr>
                                    <td>Total Deductions</td>
                                    <td>{{ number_format($entry->total_deductions, 2) }}</td>
                                </tr>
                                <tr class="payslip-totals" style="background-color: #e8f5e8;">
                                    <td><strong>Net Salary</strong></td>
                                    <td><strong>{{ number_format($entry->net_pay, 2) }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <div>info@dapintechnologies.com</div>
                        <div>Page 1 / 1</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Individual Pay Modal -->
<div class="modal fade" id="payModal{{ $entry->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route($route.'.pay', $entry->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Record Payment - {{ $entry->user->first_name }} {{ $entry->user->last_name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong>Net Pay:</strong><br>
                            <h5 class="text-success">KES {{ number_format($entry->net_pay, 2) }}</h5>
                        </div>
                        <div class="col-6">
                            <strong>Employee ID:</strong><br>
                            {{ $entry->user->staff_id ?? 'N/A' }}
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Amount *</label>
                        <input type="number" class="form-control" name="amount" value="{{ $entry->net_pay }}" step="0.01" max="{{ $entry->net_pay }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method *</label>
                        <select class="form-control" name="payment_method" required>
                            <option value="bank">Bank Transfer</option>
                            <option value="cash">Cash</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Date *</label>
                        <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reference Number</label>
                        <input type="text" class="form-control" name="reference" placeholder="e.g., Transaction ID, Cheque No.">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<!-- Master Report Modal -->
<div class="modal fade print-modal" id="masterReportModal" tabindex="-1" aria-labelledby="masterReportModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header no-print">
                <h5 class="modal-title" id="masterReportModalLabel">Master Report - {{ $run->period->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="report-container">
                    <!-- Report Header -->
                    <div class="report-header">
                        <div class="report-title">Annani Technical College</div>
                        <div class="report-subtitle">Kenya</div>
                        <div class="report-subtitle">Master Report For the period of {{ $run->period->name }}</div>
                    </div>

                    <!-- Summary Section -->
                    <div class="report-section">
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Basic Salary</td>
                                    <td>{{ number_format($run->entries->sum('basic_salary'), 2) }} KSh</td>
                                </tr>
                                
                                <!-- Detailed Allowances Breakdown -->
                                @php
                                    $totalTaxableAllowances = $run->entries->sum('taxable_allowances');
                                    $totalNonTaxableAllowances = $run->entries->sum('non_taxable_allowances');
                                    $totalOvertime = $run->entries->sum('overtime_earnings');
                                    $totalBonuses = $run->entries->sum('bonuses');
                                @endphp
                                
                                @if($totalTaxableAllowances > 0)
                                <tr>
                                    <td>Taxable Allowances</td>
                                    <td>{{ number_format($totalTaxableAllowances, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                @if($totalNonTaxableAllowances > 0)
                                <tr>
                                    <td>Non-Taxable Allowances</td>
                                    <td>{{ number_format($totalNonTaxableAllowances, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                @if($totalOvertime > 0)
                                <tr>
                                    <td>Overtime</td>
                                    <td>{{ number_format($totalOvertime, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                @if($totalBonuses > 0)
                                <tr>
                                    <td>Bonuses</td>
                                    <td>{{ number_format($totalBonuses, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                <tr class="report-totals">
                                    <td>Gross Salary</td>
                                    <td>{{ number_format($run->entries->sum('gross_earnings'), 2) }} KSh</td>
                                </tr>
                                
                                <!-- Detailed Deductions Breakdown -->
                                @php
                                    $totalNSSF = $run->entries->sum('nssf');
                                    $totalPAYE = $run->entries->sum('paye_net');
                                    $totalLoans = $run->entries->sum('loan_deductions');
                                    $totalOtherDeductions = $run->entries->sum('other_deductions');
                                @endphp
                                
                                @if($totalNSSF > 0)
                                <tr>
                                    <td>NSSF</td>
                                    <td>{{ number_format($totalNSSF, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                @if($totalPAYE > 0)
                                <tr>
                                    <td>PAYE</td>
                                    <td>{{ number_format($totalPAYE, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                @if($totalLoans > 0)
                                <tr>
                                    <td>Loan Deductions</td>
                                    <td>{{ number_format($totalLoans, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                @if($totalOtherDeductions > 0)
                                <tr>
                                    <td>Other Deductions</td>
                                    <td>{{ number_format($totalOtherDeductions, 2) }} KSh</td>
                                </tr>
                                @endif
                                
                                <tr class="report-totals">
                                    <td>Total Deductions</td>
                                    <td>{{ number_format($run->entries->sum('total_deductions'), 2) }} KSh</td>
                                </tr>
                                
                                <tr class="report-totals" style="background-color: #e8f5e8;">
                                    <td><strong>Net Pay</strong></td>
                                    <td><strong>{{ number_format($run->entries->sum('net_pay'), 2) }} KSh</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Employee Details Section -->
                    <div class="report-section">
                        <h5>Employee Details</h5>
                        <table class="report-table">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Department</th>
                                    <th>Basic Salary</th>
                                    <th>Gross Salary</th>
                                    <th>Total Deductions</th>
                                    <th>Net Pay</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($run->entries as $entry)
                                <tr>
                                    <td>{{ $entry->user->first_name }} {{ $entry->user->last_name }}</td>
                                    <td>{{ $entry->user->department ?? 'Teaching Staff' }}</td>
                                    <td>{{ number_format($entry->basic_salary, 2) }} KSh</td>
                                    <td>{{ number_format($entry->gross_earnings, 2) }} KSh</td>
                                    <td>{{ number_format($entry->total_deductions, 2) }} KSh</td>
                                    <td>{{ number_format($entry->net_pay, 2) }} KSh</td>
                                    <td>
                                        <span class="badge bg-{{ $entry->is_paid ? 'success' : 'warning' }}">
                                            {{ $entry->is_paid ? 'Paid' : 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4">
                        <div>info@dapintechnologies.com</div>
                        <div>Page 1 / 1</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer no-print">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Pay Modal - Always Active -->
<div class="modal fade" id="bulkPayModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route($route.'.bulk-pay') }}">
                @csrf
                <input type="hidden" name="entry_ids" value="{{ $run->entries->where('is_paid', false)->pluck('id')->implode(',') }}">
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Payment - {{ $run->entries->where('is_paid', false)->count() }} Employees</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i>
                        This will mark all {{ $run->entries->where('is_paid', false)->count() }} pending payments as paid.
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Total Amount to Pay</label>
                        <input type="text" class="form-control bg-light" value="KES {{ number_format($run->entries->where('is_paid', false)->sum('net_pay'), 2) }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method *</label>
                        <select class="form-control" name="payment_method" required>
                            <option value="bank">Bank Transfer</option>
                            <option value="cash">Cash</option>
                            <option value="mpesa">M-Pesa</option>
                            <option value="cheque">Cheque</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Date *</label>
                        <input type="date" class="form-control" name="payment_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Reference Number</label>
                        <input type="text" class="form-control" name="reference" value="BULK-{{ now()->format('YmdHis') }}" required>
                        <small class="form-text text-muted">This reference will be used for all payments in this bulk operation.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Confirm Bulk Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection