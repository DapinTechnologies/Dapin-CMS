<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Payslip - {{ $entry->user->first_name }} {{ $entry->user->last_name }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        .container { width: 100%; margin: 0 auto; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .section { margin-bottom: 15px; }
        .section-title { background: #f8f9fa; padding: 5px; font-weight: bold; border-left: 3px solid #007bff; }
        .row { display: flex; flex-wrap: wrap; margin: 0 -10px; }
        .col-6 { flex: 0 0 50%; padding: 0 10px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { padding: 6px; border: 1px solid #ddd; text-align: left; }
        .table th { background: #f8f9fa; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row { background: #e9ecef; font-weight: bold; }
        .page-break { page-break-after: always; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h2>PAYSLIP</h2>
            <h3>{{ $entry->run->period->name }}</h3>
            <p>Generated on: {{ date('d M Y') }}</p>
        </div>

        <!-- Employee Details -->
        <div class="section">
            <div class="section-title">Employee Information</div>
            <div class="row">
                <div class="col-6">
                    <strong>Name:</strong> {{ $entry->user->first_name }} {{ $entry->user->last_name }}<br>
                    <strong>Employee ID:</strong> {{ $entry->user->staff_id }}<br>
                    <strong>Department:</strong> {{ $entry->user->department->name ?? 'N/A' }}
                </div>
                <div class="col-6">
                    <strong>Pay Period:</strong> {{ $entry->run->period->start_date->format('d M Y') }} - {{ $entry->run->period->end_date->format('d M Y') }}<br>
                    <strong>Attendance:</strong> {{ $entry->attendance_days }}/{{ $entry->working_days }} days ({{ $entry->attendance_hours }} hours)<br>
                    <strong>Payment Status:</strong> {{ $entry->is_paid ? 'Paid' : 'Pending' }}
                </div>
            </div>
        </div>

        <!-- Earnings -->
        <div class="section">
            <div class="section-title">Earnings</div>
            <table class="table">
                <tr>
                    <th>Description</th>
                    <th class="text-right">Amount (KES)</th>
                </tr>
                <tr>
                    <td>Basic Salary</td>
                    <td class="text-right">{{ number_format($entry->basic_salary, 2) }}</td>
                </tr>
                <tr>
                    <td>Taxable Allowances</td>
                    <td class="text-right">{{ number_format($entry->taxable_allowances, 2) }}</td>
                </tr>
                <tr>
                    <td>Non-Taxable Allowances</td>
                    <td class="text-right">{{ number_format($entry->non_taxable_allowances, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Gross Earnings</strong></td>
                    <td class="text-right"><strong>{{ number_format($entry->gross_earnings, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Deductions -->
        <div class="section">
            <div class="section-title">Deductions</div>
            <table class="table">
                <tr>
                    <th>Description</th>
                    <th class="text-right">Employee</th>
                    <th class="text-right">Employer</th>
                </tr>
                <tr>
                    <td>NSSF</td>
                    <td class="text-right">{{ number_format($entry->nssf_employee, 2) }}</td>
                    <td class="text-right">{{ number_format($entry->nssf_employer, 2) }}</td>
                </tr>
                <tr>
                    <td>NHIF</td>
                    <td class="text-right">{{ number_format($entry->nhif, 2) }}</td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>PAYE (Gross Tax)</td>
                    <td class="text-right">{{ number_format($entry->paye_gross, 2) }}</td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Personal Relief</td>
                    <td class="text-right">-{{ number_format($entry->personal_relief, 2) }}</td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td><strong>PAYE (Net)</strong></td>
                    <td class="text-right"><strong>{{ number_format($entry->paye_net, 2) }}</strong></td>
                    <td class="text-right">-</td>
                </tr>
                <tr>
                    <td>Other Deductions</td>
                    <td class="text-right">{{ number_format($entry->loan_deductions, 2) }}</td>
                    <td class="text-right">-</td>
                </tr>
                <tr class="total-row">
                    <td><strong>Total Deductions</strong></td>
                    <td class="text-right"><strong>{{ number_format($entry->total_deductions, 2) }}</strong></td>
                    <td class="text-right"><strong>{{ number_format($entry->nssf_employer, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <!-- Summary -->
        <div class="section">
            <div class="section-title">Summary</div>
            <div class="row">
                <div class="col-6">
                    <table class="table">
                        <tr>
                            <td><strong>Taxable Earnings:</strong></td>
                            <td class="text-right">{{ number_format($entry->taxable_earnings, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Total Deductions:</strong></td>
                            <td class="text-right">{{ number_format($entry->total_deductions, 2) }}</td>
                        </tr>
                        <tr class="total-row">
                            <td><strong>NET PAY:</strong></td>
                            <td class="text-right"><strong>KES {{ number_format($entry->net_pay, 2) }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <!-- Tax Deduction Card -->
        <div class="section">
            <div class="section-title">Tax Deduction Card</div>
            <table class="table">
                <tr>
                    <th>Description</th>
                    <th class="text-right">Monthly</th>
                    <th class="text-right">Annual</th>
                </tr>
                <tr>
                    <td>Gross Taxable Pay</td>
                    <td class="text-right">{{ number_format($entry->taxable_earnings, 2) }}</td>
                    <td class="text-right">{{ number_format($entry->taxable_earnings * 12, 2) }}</td>
                </tr>
                <tr>
                    <td>PAYE Before Relief</td>
                    <td class="text-right">{{ number_format($entry->paye_gross, 2) }}</td>
                    <td class="text-right">{{ number_format($entry->paye_gross * 12, 2) }}</td>
                </tr>
                <tr>
                    <td>Personal Relief</td>
                    <td class="text-right">{{ number_format($entry->personal_relief, 2) }}</td>
                    <td class="text-right">{{ number_format($entry->personal_relief * 12, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td><strong>PAYE Payable</strong></td>
                    <td class="text-right"><strong>{{ number_format($entry->paye_net, 2) }}</strong></td>
                    <td class="text-right"><strong>{{ number_format($entry->paye_net * 12, 2) }}</strong></td>
                </tr>
            </table>
        </div>

        <div class="footer text-center" style="margin-top: 30px; border-top: 1px solid #333; padding-top: 10px;">
            <p>This is a computer generated payslip and does not require a signature.</p>
        </div>
    </div>
</body>
</html>