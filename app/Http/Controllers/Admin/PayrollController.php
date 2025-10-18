<?php
// app/Http/Controllers/Admin/PayrollController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollPeriod;
use App\Models\PayrollRun;
use App\Models\Department;
use App\Models\Designation;
use App\Models\WorkShiftType;
use App\Models\PrintSetting;
use App\Models\PayrollEntry;
use App\Models\PayrollComponent;
use App\Models\EmployeePayrollDraft;
use App\Models\StaffAttendance;
use App\Models\User;
use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Excel;
use App\Exports\PayrollExport;
use App\Exports\MasterReportExport;
use App\Exports\PayslipExport;

class PayrollController extends Controller
{
    public function __construct()
    {
        $this->title = 'Payroll Management';
        $this->route = 'admin.payroll';
        $this->view = 'admin.payroll';
        $this->path = 'payroll';
        $this->access = 'payroll';
    }

    public function index(Request $request)
{
    $data['title'] = $this->title;
    $data['route'] = $this->route;
    $data['view'] = $this->view;
    
    // Get grouped periods by year
    $data['periods'] = PayrollPeriod::orderBy('start_date', 'desc')->get();
    $data['groupedPeriods'] = $data['periods']->groupBy(function($period) {
        return Carbon::parse($period->start_date)->format('Y');
    });
    
    // Get payroll runs grouped by month with enhanced statistics
    $data['monthlyRuns'] = PayrollRun::with(['entries', 'period'])
        ->selectRaw('
            YEAR(run_date) as year,
            MONTH(run_date) as month,
            COUNT(*) as run_count,
            SUM(total_employees) as total_employees,
            SUM(COALESCE(successful_entries, 0)) as successful_entries,
            SUM(COALESCE(failed_entries, 0)) as failed_entries
        ')
        ->groupBy('year', 'month')
        ->orderBy('year', 'desc')
        ->orderBy('month', 'desc')
        ->get()
        ->map(function($monthly) {
            // Get detailed run info for this month
            $runs = PayrollRun::with(['entries'])
                ->whereYear('run_date', $monthly->year)
                ->whereMonth('run_date', $monthly->month)
                ->get();
                
            $monthly->total_gross = $runs->sum(function($run) {
                return $run->entries->sum('gross_earnings');
            });
            $monthly->total_tax = $runs->sum(function($run) {
                return $run->entries->sum('paye_net');
            });
            $monthly->total_net = $runs->sum(function($run) {
                return $run->entries->sum('net_pay');
            });
            $monthly->month_name = Carbon::create($monthly->year, $monthly->month, 1)->format('F Y');
            $monthly->runs = $runs;
            
            return $monthly;
        });
    
    // Individual runs for detailed table
    $data['runs'] = PayrollRun::withCount(['entries'])
        ->with(['entries', 'period'])
        ->orderBy('run_date', 'desc')
        ->paginate(20);
    
    // Enhanced Statistics for dashboard
    $data['totalEmployees'] = User::where('status', 1)->count();
    $data['activeRuns'] = PayrollRun::where('status', 'computed')->count();
    $data['pendingPayments'] = PayrollEntry::where('is_paid', false)->count();
    $data['activeComponents'] = PayrollComponent::where('is_active', true)->count();
    
    // Current month statistics
    $currentMonthRuns = PayrollRun::whereHas('period', function($q) {
        $q->where('start_date', '>=', now()->startOfMonth());
    })->with('entries')->get();
    
    $data['currentMonthNet'] = $currentMonthRuns->sum(function($run) {
        return $run->entries->sum('net_pay');
    });
    $data['currentMonthGross'] = $currentMonthRuns->sum(function($run) {
        return $run->entries->sum('gross_earnings');
    });
    $data['currentMonthTax'] = $currentMonthRuns->sum(function($run) {
        return $run->entries->sum('paye_net');
    });
    
    // Recent attendance
    $data['recentAttendance'] = StaffAttendance::with('user')
        ->orderBy('date', 'desc')
        ->limit(10)
        ->get();
    
    // Component statistics
    $data['earningComponents'] = PayrollComponent::where('type', 'earning')->where('is_active', true)->count();
    $data['deductionComponents'] = PayrollComponent::where('type', 'deduction')->where('is_active', true)->count();
    
    // Tax component statistics
    $data['taxComponents'] = PayrollComponent::where('is_statutory', true)->where('is_active', true)->get();
    
    // Draft statistics
    $data['totalDrafts'] = EmployeePayrollDraft::count();
    $data['activeDrafts'] = EmployeePayrollDraft::where('is_locked', false)->count();
    
    return view($this->view.'.index', $data);
}

    public function create()
    {
        $data['title'] = 'Generate Payroll';
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        // Get or create current month period
        $currentPeriod = $this->getOrCreateCurrentPeriod();
        
        // Get grouped periods by year
        $periods = PayrollPeriod::where('is_locked', false)
            ->orderBy('start_date', 'desc')
            ->get();
            
        $data['groupedPeriods'] = $periods->groupBy(function($period) {
            return Carbon::parse($period->start_date)->format('Y');
        });
        
        $data['periods'] = $periods;
        $data['currentPeriod'] = $currentPeriod;
        $data['employees'] = User::where('status', 1)->get();
        
        // Get all payroll components for the draft modal
        $data['payrollComponents'] = PayrollComponent::where('is_active', true)->get();
        
        return view($this->view.'.create', $data);
    }

    private function getOrCreateCurrentPeriod()
    {
        $currentYear = now()->year;
        $currentMonth = now()->month;
        $periodId = $currentYear . '-' . str_pad($currentMonth, 2, '0', STR_PAD_LEFT);
        
        $period = PayrollPeriod::where('period_id', $periodId)->first();
        
        if (!$period) {
            $startDate = Carbon::create($currentYear, $currentMonth, 1);
            $endDate = $startDate->copy()->endOfMonth();
            
            $period = PayrollPeriod::create([
                'name' => $startDate->format('F Y'),
                'period_id' => $periodId,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'is_locked' => false
            ]);
        }
        
        return $period;
    }

   // Save payroll draft for individual employee
public function saveDraft(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'payroll_period_id' => 'required|exists:payroll_periods,id',
        'basic_salary' => 'required|numeric|min:0',
        'components' => 'sometimes|array',
        'custom_allowances' => 'sometimes|array',
        'custom_deductions' => 'sometimes|array'
    ]);

    try {
        DB::beginTransaction();

        $basicSalary = $request->basic_salary;
        $selectedComponents = [];
        $totalAllowances = 0;
        $totalDeductions = 0;

        // Process selected components
        if ($request->has('components')) {
            foreach ($request->components as $componentId => $data) {
                $component = PayrollComponent::find($componentId);
                if ($component) {
                    $amount = $this->calculateComponentAmountFromData($component, $data, $basicSalary);
                    
                    $selectedComponents[] = [
                        'component_id' => $componentId,
                        'name' => $component->name,
                        'type' => $component->type,
                        'calculation_type' => $component->calculation_type,
                        'amount' => $amount,
                        'input_data' => $data,
                        'is_taxable' => $component->is_taxable,
                        'is_statutory' => $component->is_statutory,
                        'category' => $component->category
                    ];

                    if ($component->type === 'earning') {
                        $totalAllowances += $amount;
                    } else {
                        $totalDeductions += $amount;
                    }
                }
            }
        }

        // Process custom allowances with validation
        $customAllowances = [];
        if ($request->has('custom_allowances')) {
            foreach ($request->custom_allowances as $allowance) {
                if (!empty($allowance['name'])) {
                    $amount = $allowance['amount'] ?? 0;
                    $customAllowances[] = [
                        'name' => $allowance['name'],
                        'amount' => $amount,
                        'is_taxable' => $allowance['is_taxable'] ?? true
                    ];
                    $totalAllowances += $amount;
                }
            }
        }

        // Process custom deductions with validation
        $customDeductions = [];
        if ($request->has('custom_deductions')) {
            foreach ($request->custom_deductions as $deduction) {
                if (!empty($deduction['name'])) {
                    $amount = $deduction['amount'] ?? 0;
                    $customDeductions[] = [
                        'name' => $deduction['name'],
                        'amount' => $amount,
                        'minimum_amount' => $deduction['minimum_amount'] ?? null
                    ];
                    $totalDeductions += $amount;
                }
            }
        }

        $grossEarnings = $basicSalary + $totalAllowances;
        $netPay = $grossEarnings - $totalDeductions;

        // Check if draft already exists
        $existingDraft = EmployeePayrollDraft::where('user_id', $request->user_id)
            ->where('payroll_period_id', $request->payroll_period_id)
            ->first();

        if ($existingDraft) {
            // Update existing draft
            $existingDraft->update([
                'basic_salary' => $basicSalary,
                'selected_components' => json_encode($selectedComponents),
                'custom_allowances' => json_encode($customAllowances),
                'custom_deductions' => json_encode($customDeductions),
                'gross_earnings' => $grossEarnings,
                'total_deductions' => $totalDeductions,
                'net_pay' => $netPay,
                'updated_by' => auth()->id(),
                'updated_at' => now()
            ]);
            
            $draft = $existingDraft;
        } else {
            // Create new draft with manual ID generation
            $lastId = EmployeePayrollDraft::max('id') ?? 0;
            $newId = $lastId + 1;
            
            // Ensure the ID doesn't exist
            $maxAttempts = 10;
            $attempt = 0;
            
            while (EmployeePayrollDraft::where('id', $newId)->exists() && $attempt < $maxAttempts) {
                $newId++;
                $attempt++;
            }
            
            if ($attempt >= $maxAttempts) {
                throw new \Exception("Unable to find available ID after {$maxAttempts} attempts");
            }
            
            $draft = EmployeePayrollDraft::create([
                'id' => $newId,
                'user_id' => $request->user_id,
                'payroll_period_id' => $request->payroll_period_id,
                'basic_salary' => $basicSalary,
                'selected_components' => json_encode($selectedComponents),
                'custom_allowances' => json_encode($customAllowances),
                'custom_deductions' => json_encode($customDeductions),
                'gross_earnings' => $grossEarnings,
                'total_deductions' => $totalDeductions,
                'net_pay' => $netPay,
                'created_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        DB::commit();

        return response()->json([
            'success' => true,
            'message' => 'Payroll draft saved successfully',
            'draft_id' => $draft->id
        ]);

    } catch (\Exception $e) {
        DB::rollBack();
        \Log::error('Error saving payroll draft: ' . $e->getMessage(), [
            'user_id' => $request->user_id,
            'period_id' => $request->payroll_period_id,
            'error' => $e->getMessage()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Error saving draft: ' . $e->getMessage()
        ], 500);
    }
}

    // Restart/delete draft
public function restartDraft($userId, $periodId)
{
    try {
        $draft = EmployeePayrollDraft::where('user_id', $userId)
            ->where('payroll_period_id', $periodId)
            ->first();

        if ($draft) {
            $draft->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Payroll draft restarted successfully'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error restarting draft: ' . $e->getMessage()
        ], 500);
    }
}

    private function calculateComponentAmountFromData($component, $data, $basicSalary)
    {
        switch ($component->calculation_type) {
            case 'percentage':
                $percentage = $data['percentage'] ?? $component->percentage ?? 0;
                return $basicSalary * ($percentage / 100);
                
            case 'fixed':
                return $data['amount'] ?? $component->default_amount ?? 0;
                
            case 'formula':
                return $this->evaluateFormula($component->formula ?? '', $data, $basicSalary);
                
            default:
                return $component->default_amount ?? 0;
        }
    }

    private function evaluateFormula($formula, $data, $basicSalary)
    {
        if (empty($formula)) {
            return 0;
        }

        try {
            // Replace common variables with actual values
            $formula = str_replace('{basic_salary}', $basicSalary, $formula);
            $formula = str_replace('{days_worked}', $data['days_worked'] ?? 22, $formula);
            $formula = str_replace('{hours_worked}', $data['hours_worked'] ?? 176, $formula);
            
            // Remove any potentially dangerous functions
            $formula = preg_replace('/[^0-9+\-*\/().% ]/', '', $formula);
            
            // Evaluate the formula safely
            $result = eval("return {$formula};");
            return is_numeric($result) ? $result : 0;
            
        } catch (\Exception $e) {
            \Log::error("Formula evaluation failed: Formula: {$formula} - Error: " . $e->getMessage());
            return 0;
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'payroll_period_id' => 'required|exists:payroll_periods,id',
            'employee_ids' => 'required|array',
            'employee_ids.*' => 'exists:users,id'
        ]);

        try {
            DB::beginTransaction();

            $payrollRun = PayrollRun::create([
                'payroll_period_id' => $request->payroll_period_id,
                'run_date' => now(),
                'status' => 'draft',
                'generated_by' => auth()->id(),
                'total_employees' => count($request->employee_ids)
            ]);

            $successCount = 0;
            $errorCount = 0;
            $errors = [];

            foreach ($request->employee_ids as $employeeId) {
                try {
                    $this->generatePayrollFromDraft($employeeId, $payrollRun->id, $request->payroll_period_id);
                    $successCount++;
                } catch (\Exception $e) {
                    $errorCount++;
                    $errors[] = "Employee ID {$employeeId}: " . $e->getMessage();
                    \Log::error("Payroll generation failed for employee {$employeeId}: " . $e->getMessage());
                }
            }

            $payrollRun->update([
                'status' => $errorCount > 0 ? 'partial' : 'computed',
                'successful_entries' => $successCount,
                'failed_entries' => $errorCount
            ]);

            DB::commit();

            $message = "Payroll generated successfully for {$successCount} employees";
            if ($errorCount > 0) {
                $message .= " with {$errorCount} errors. " . implode('; ', array_slice($errors, 0, 3));
            }

            return redirect()->route('admin.payroll.run.show', $payrollRun->id)
                ->with($errorCount > 0 ? 'warning' : 'success', $message);
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error generating payroll: ' . $e->getMessage());
        }
    }

    // Updated bulkGenerate method to include pay option
public function bulkGenerate(Request $request)
{
    $request->validate([
        'payroll_period_id' => 'required|exists:payroll_periods,id',
        'auto_pay' => 'sometimes|boolean'
    ]);

    try {
        DB::beginTransaction();

        $payrollRun = PayrollRun::create([
            'payroll_period_id' => $request->payroll_period_id,
            'run_date' => now(),
            'status' => 'draft',
            'generated_by' => auth()->id()
        ]);

        $activeEmployees = User::where('status', 1)->get();
        $successCount = 0;
        $errorCount = 0;

        foreach ($activeEmployees as $employee) {
            try {
                $this->generatePayrollFromDraft($employee->id, $payrollRun->id, $request->payroll_period_id);
                $successCount++;
            } catch (\Exception $e) {
                $errorCount++;
                \Log::error("Bulk payroll generation failed for employee {$employee->id}: " . $e->getMessage());
            }
        }

        // Auto pay if requested
        $autoPay = $request->has('auto_pay') && $request->auto_pay;
        if ($autoPay && $successCount > 0) {
            $this->processBulkPayment($payrollRun->id, $request->payroll_period_id);
        }

        $payrollRun->update([
            'status' => $errorCount > 0 ? 'partial' : 'computed',
            'total_employees' => $activeEmployees->count(),
            'successful_entries' => $successCount,
            'failed_entries' => $errorCount,
            'is_paid' => $autoPay
        ]);

        DB::commit();

        $message = "Bulk payroll generated for {$successCount} employees";
        if ($autoPay) {
            $message .= " and payments processed";
        }
        if ($errorCount > 0) {
            $message .= " with {$errorCount} errors";
        }

        return redirect()->route('admin.payroll.run.show', $payrollRun->id)
            ->with($errorCount > 0 ? 'warning' : 'success', $message);
            
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Error generating bulk payroll: ' . $e->getMessage());
    }
}

private function processBulkPayment($payrollRunId, $periodId)
{
    $entries = PayrollEntry::where('payroll_run_id', $payrollRunId)->get();
    
    foreach ($entries as $entry) {
        $entry->update([
            'is_paid' => true,
            'paid_at' => now()
        ]);

        // Create payment record
        $entry->payments()->create([
            'amount' => $entry->net_pay,
            'payment_method' => 'bank', // Default method
            'payment_date' => now(),
            'reference' => 'BULK-' . now()->format('YmdHis') . '-' . $entry->user->staff_id
        ]);
    }
}

    private function generatePayrollFromDraft($employeeId, $payrollRunId, $periodId)
    {
        $employee = User::findOrFail($employeeId);
        $period = PayrollPeriod::findOrFail($periodId);

        // Check if draft exists for this employee and period
        $draft = EmployeePayrollDraft::where('user_id', $employeeId)
            ->where('payroll_period_id', $periodId)
            ->first();

        if (!$draft) {
            throw new \Exception("No payroll draft found for employee {$employee->name}. Please create a draft first.");
        }

        // Check if payroll entry already exists for this run
        $existingEntry = PayrollEntry::where('payroll_run_id', $payrollRunId)
            ->where('user_id', $employeeId)
            ->first();
            
        if ($existingEntry) {
            throw new \Exception("Payroll entry already exists for this employee in the current run.");
        }

        // Get attendance data
        $attendance = $this->getAttendanceData($employeeId, $period);
        
        // Calculate payroll using draft data
        $calculations = $this->calculatePayrollFromDraft($employee, $draft, $attendance);
        
        // Create payroll entry
        PayrollEntry::create(array_merge([
            'payroll_run_id' => $payrollRunId,
            'user_id' => $employeeId,
            'attendance_days' => $attendance['days'],
            'attendance_hours' => $attendance['hours'],
            'working_days' => 22,
            'working_hours' => 176,
            'calculated_at' => now(),
        ], $calculations));
    }

    private function getAttendanceData($employeeId, $period)
    {
        $attendances = StaffAttendance::where('user_id', $employeeId)
            ->whereBetween('date', [$period->start_date, $period->end_date])
            ->get();

        $presentDays = $attendances->where('attendance', 1)->count();
        $totalHours = $attendances->where('attendance', 1)->sum('hours_worked');

        return [
            'days' => $presentDays,
            'hours' => $totalHours
        ];
    }

    private function calculatePayrollFromDraft($employee, $draft, $attendance)
{
    $basicSalary = $draft->basic_salary;
    
    // Check payment type and prorate only for hourly employees
    $paymentType = $employee->payment_type ?? 'fixed'; // default to fixed
    
    if ($paymentType === 'hourly') {
        // Prorate basic salary based on attendance for hourly employees
        $workingDays = 22;
        $attendanceRatio = $workingDays > 0 ? $attendance['days'] / $workingDays : 0;
        $proratedBasic = $basicSalary * $attendanceRatio;
    } else {
        // Fixed salary employees get full basic salary regardless of attendance
        $proratedBasic = $basicSalary;
        $workingDays = 22;
        $attendanceRatio = 1; // 100% for fixed salary
    }

    // Calculate allowances and deductions from draft with custom items
    $allowances = $this->calculateAllowancesFromDraft($draft, $proratedBasic);
    $deductions = $this->calculateDeductionsFromDraft($draft, $proratedBasic);

    $grossEarnings = $proratedBasic + $allowances['total'];
    $totalDeductions = $deductions['total'];
    $netPay = $grossEarnings - $totalDeductions;

    // Validate calculations
    if ($netPay < 0) {
        \Log::warning("Negative net pay calculated for employee {$employee->name}: {$netPay}");
    }

    return [
        'basic_salary' => round($proratedBasic, 2),
        'taxable_allowances' => round($allowances['taxable_total'], 2),
        'non_taxable_allowances' => round($allowances['non_taxable_total'], 2),
        'overtime_earnings' => round($allowances['overtime_total'], 2),
        'bonuses' => round($allowances['bonus_total'], 2),
        'gross_earnings' => round($grossEarnings, 2),
        'taxable_earnings' => round($proratedBasic + $allowances['taxable_total'], 2),
        'nssf_employee' => round($deductions['nssf_total'], 2),
        'nssf_employer' => round($deductions['nssf_employer_total'], 2),
        'nhif' => round($deductions['nhif_total'], 2),
        'paye_gross' => round($deductions['paye_gross_total'], 2),
        'personal_relief' => round($deductions['personal_relief_total'], 2),
        'paye_net' => round($deductions['paye_net_total'], 2),
        'loan_deductions' => round($deductions['loan_total'], 2),
        'other_deductions' => round($deductions['other_total'], 2),
        'total_deductions' => round($totalDeductions, 2),
        'net_pay' => round($netPay, 2),
        'payment_type' => $paymentType,
        // Store custom items for display
        'custom_allowances_total' => round($allowances['custom_total'], 2),
        'custom_deductions_total' => round($deductions['custom_total'], 2),
    ];
}
    private function calculateAllowancesFromDraft($draft, $basicSalary)
{
    $selectedComponents = json_decode($draft->selected_components, true) ?? [];
    $customAllowances = json_decode($draft->custom_allowances, true) ?? [];

    $taxableTotal = 0;
    $nonTaxableTotal = 0;
    $overtimeTotal = 0;
    $bonusTotal = 0;
    $customTotal = 0;
    $total = 0;

    // Process selected components
    foreach ($selectedComponents as $component) {
        if ($component['type'] === 'earning') {
            $amount = $component['amount'] ?? 0;
            
            // Categorize based on component configuration
            if ($component['category'] === 'overtime') {
                $overtimeTotal += $amount;
            } elseif ($component['category'] === 'bonus') {
                $bonusTotal += $amount;
            }
            
            if ($component['is_taxable']) {
                $taxableTotal += $amount;
            } else {
                $nonTaxableTotal += $amount;
            }
            
            $total += $amount;
        }
    }

    // Process custom allowances - FIXED VERSION
    foreach ($customAllowances as $allowance) {
        if (!empty($allowance['name']) && isset($allowance['amount'])) {
            $amount = floatval($allowance['amount']);
            $isTaxable = $allowance['is_taxable'] ?? true;
            
            if ($amount > 0) {
                if ($isTaxable) {
                    $taxableTotal += $amount;
                } else {
                    $nonTaxableTotal += $amount;
                }
                
                $customTotal += $amount;
                $total += $amount;
                
                \Log::info("Custom allowance processed", [
                    'name' => $allowance['name'],
                    'amount' => $amount,
                    'taxable' => $isTaxable
                ]);
            }
        }
    }

    return [
        'taxable_total' => $taxableTotal,
        'non_taxable_total' => $nonTaxableTotal,
        'overtime_total' => $overtimeTotal,
        'bonus_total' => $bonusTotal,
        'custom_total' => $customTotal,
        'total' => $total
    ];
}

    private function calculateDeductionsFromDraft($draft, $basicSalary)
{
    $selectedComponents = json_decode($draft->selected_components, true) ?? [];
    $customDeductions = json_decode($draft->custom_deductions, true) ?? [];

    $nssfTotal = 0;
    $nssfEmployerTotal = 0;
    $nhifTotal = 0;
    $payeGrossTotal = 0;
    $personalReliefTotal = 0;
    $payeNetTotal = 0;
    $loanTotal = 0;
    $otherTotal = 0;
    $customTotal = 0;
    $total = 0;

    // Process selected components
    foreach ($selectedComponents as $component) {
        if ($component['type'] === 'deduction') {
            $amount = $component['amount'] ?? 0;
            
            // Categorize based on component name and type
            $componentName = strtolower($component['name']);
            
            if (str_contains($componentName, 'nssf')) {
                if (str_contains($componentName, 'employer')) {
                    $nssfEmployerTotal += $amount;
                } else {
                    $nssfTotal += $amount;
                }
            } elseif (str_contains($componentName, 'nhif')) {
                $nhifTotal += $amount;
            } elseif (str_contains($componentName, 'paye') || str_contains($componentName, 'tax')) {
                if (str_contains($componentName, 'gross')) {
                    $payeGrossTotal += $amount;
                } elseif (str_contains($componentName, 'net')) {
                    $payeNetTotal += $amount;
                } else {
                    $payeNetTotal += $amount;
                }
            } elseif (str_contains($componentName, 'relief')) {
                $personalReliefTotal += $amount;
            } elseif (str_contains($componentName, 'loan')) {
                $loanTotal += $amount;
            } else {
                $otherTotal += $amount;
            }
            
            $total += $amount;
        }
    }

    // Process custom deductions - FIXED VERSION
    foreach ($customDeductions as $deduction) {
        if (!empty($deduction['name']) && isset($deduction['amount'])) {
            $amount = floatval($deduction['amount']);
            
            if ($amount > 0) {
                $deductionName = strtolower($deduction['name']);
                
                if (str_contains($deductionName, 'loan')) {
                    $loanTotal += $amount;
                } else {
                    $otherTotal += $amount;
                }
                
                $customTotal += $amount;
                $total += $amount;
                
                \Log::info("Custom deduction processed", [
                    'name' => $deduction['name'],
                    'amount' => $amount
                ]);
            }
        }
    }

    return [
        'nssf_total' => $nssfTotal,
        'nssf_employer_total' => $nssfEmployerTotal,
        'nhif_total' => $nhifTotal,
        'paye_gross_total' => $payeGrossTotal,
        'personal_relief_total' => $personalReliefTotal,
        'paye_net_total' => $payeNetTotal,
        'loan_total' => $loanTotal,
        'other_total' => $otherTotal,
        'custom_total' => $customTotal,
        'total' => $total
    ];
}

    public function showRun($id)
    {
        $data['title'] = 'Payroll Run Details';
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        $data['run'] = PayrollRun::with(['entries.user', 'period', 'generator'])->findOrFail($id);
        $data['components'] = PayrollComponent::where('is_active', true)->get();
        
        return view($this->view.'.run_show', $data);
    }

    public function componentUtilizationReport()
    {
        $data['title'] = 'Component Utilization Report';
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        
        // Get component usage statistics
        $data['components'] = PayrollComponent::withCount(['preferences' => function($query) {
            $query->where('is_active', true);
        }])->get();
        
        $data['mostUsedEarnings'] = PayrollComponent::where('type', 'earning')
            ->withCount(['preferences' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('preferences_count', 'desc')
            ->limit(10)
            ->get();
            
        $data['mostUsedDeductions'] = PayrollComponent::where('type', 'deduction')
            ->withCount(['preferences' => function($query) {
                $query->where('is_active', true);
            }])
            ->orderBy('preferences_count', 'desc')
            ->limit(10)
            ->get();
        
        $data['totalEmployees'] = User::where('status', 1)->count();
        
        return view($this->view.'.component_utilization', $data);
    }

    // Excel Export Methods
    public function exportExcel($id)
    {
        try {
            $run = PayrollRun::with(['entries.user', 'period'])->findOrFail($id);
            $filename = 'payroll-run-' . $run->period->name . '-' . now()->format('Y-m-d') . '.xlsx';
            
            return Excel::download(new PayrollExport($run), $filename);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating Excel: ' . $e->getMessage());
        }
    }

    public function exportMasterReportExcel($id)
    {
        try {
            $run = PayrollRun::with(['entries.user', 'period'])->findOrFail($id);
            $filename = 'master-report-' . $run->period->name . '-' . now()->format('Y-m-d') . '.xlsx';
            
            return Excel::download(new MasterReportExport($run), $filename);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating master report Excel: ' . $e->getMessage());
        }
    }

    public function exportPayslipExcel($id)
    {
        try {
            $entry = PayrollEntry::with(['user', 'run.period'])->findOrFail($id);
            $filename = 'payslip-' . $entry->user->staff_id . '-' . $entry->run->period->name . '.xlsx';
            
            return Excel::download(new PayslipExport($entry), $filename);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error generating payslip Excel: ' . $e->getMessage());
        }
    }

    // Print Methods (for browser printing)
    public function printPayslip($id)
    {
        try {
            $entry = PayrollEntry::with(['user', 'run.period'])->findOrFail($id);
            
            return view($this->view.'.print.payslip', compact('entry'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading payslip: ' . $e->getMessage());
        }
    }

    public function printMasterReport($id)
    {
        try {
            $run = PayrollRun::with(['entries.user', 'period'])->findOrFail($id);
            
            return view($this->view.'.print.master_report', compact('run'));
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading master report: ' . $e->getMessage());
        }
    }

    // Remove PDF methods and replace with Excel/Print
    public function exportAllPayslips($id)
    {
        try {
            $run = PayrollRun::with(['entries.user', 'period'])->findOrFail($id);
            $filename = 'all-payslips-' . $run->period->name . '-' . now()->format('Y-m-d') . '.xlsx';
            
            return Excel::download(new PayslipExport($run, true), $filename);
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error exporting all payslips: ' . $e->getMessage());
        }
    }

    // Payment methods
    public function pay(Request $request, $id)
    {
        $entry = PayrollEntry::findOrFail($id);
        
        $request->validate([
            'amount' => 'required|numeric|min:0|max:'.$entry->net_pay,
            'payment_method' => 'required|in:bank,cash,mpesa',
            'payment_date' => 'required|date',
            'reference' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $entry->update([
                'is_paid' => true,
                'paid_at' => $request->payment_date
            ]);

            // Create payment record
            $entry->payments()->create($request->only(['amount', 'payment_method', 'reference', 'payment_date']));

            DB::commit();

            return redirect()->back()->with('success', 'Payment recorded successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error recording payment: ' . $e->getMessage());
        }
    }

    public function bulkPay(Request $request)
    {
        $request->validate([
            'entry_ids' => 'required|array',
            'payment_method' => 'required|in:bank,cash,mpesa',
            'payment_date' => 'required|date'
        ]);

        try {
            DB::beginTransaction();

            PayrollEntry::whereIn('id', $request->entry_ids)->update([
                'is_paid' => true,
                'paid_at' => $request->payment_date
            ]);

            // Create payment records for each entry
            foreach ($request->entry_ids as $entryId) {
                $entry = PayrollEntry::find($entryId);
                if ($entry) {
                    $entry->payments()->create([
                        'amount' => $entry->net_pay,
                        'payment_method' => $request->payment_method,
                        'payment_date' => $request->payment_date,
                        'reference' => 'BULK-' . now()->format('YmdHis')
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', count($request->entry_ids) . ' payments recorded successfully');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error recording bulk payments: ' . $e->getMessage());
        }
    }

    // Get draft data for editing
    // Get draft data for editing
public function getDraft($userId, $periodId)
{
    try {
        \Log::info("Fetching draft for user: {$userId}, period: {$periodId}");

        $draft = EmployeePayrollDraft::where('user_id', $userId)
            ->where('payroll_period_id', $periodId)
            ->first();

        if (!$draft) {
            \Log::warning("No draft found for user: {$userId}, period: {$periodId}");
            return response()->json([
                'success' => false,
                'message' => 'No draft found'
            ], 404);
        }

        \Log::info("Draft found:", [
            'draft_id' => $draft->id,
            'basic_salary' => $draft->basic_salary
        ]);

        return response()->json([
            'success' => true,
            'draft' => [
                'basic_salary' => $draft->basic_salary,
                'selected_components' => json_decode($draft->selected_components, true) ?? [],
                'custom_allowances' => json_decode($draft->custom_allowances, true) ?? [],
                'custom_deductions' => json_decode($draft->custom_deductions, true) ?? [],
                'gross_earnings' => $draft->gross_earnings,
                'total_deductions' => $draft->total_deductions,
                'net_pay' => $draft->net_pay
            ]
        ]);

    } catch (\Exception $e) {
        \Log::error("Error retrieving draft for user {$userId}, period {$periodId}: " . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => 'Error retrieving draft: ' . $e->getMessage()
        ], 500);
    }
}


// Report Generation
// Report Generation
public function report(Request $request)
{
    $data['title'] = trans_choice('module_payroll_report', 1);
    $data['route'] = $this->route;
    $data['view'] = $this->view;
    $data['path'] = $this->path;
    $data['access'] = $this->access;

    // Set default values
    $data['selected_salary_type'] = $request->salary_type ?? '0';
    $data['selected_department'] = $request->department ?? '0';
    $data['selected_designation'] = $request->designation ?? '0';
    $data['selected_shift'] = $request->shift ?? '0';
    $data['selected_contract'] = $request->contract_type ?? '0';
    $data['selected_month'] = $request->month ?? date("m", strtotime(Carbon::today()));
    $data['selected_year'] = $request->year ?? date("Y", strtotime(Carbon::today()));

    // Get filter data
    $data['departments'] = Department::where('status', '1')->orderBy('title', 'asc')->get();
    $data['designations'] = Designation::where('status', '1')->orderBy('title', 'asc')->get();
    $data['work_shifts'] = WorkShiftType::where('status', '1')->orderBy('title', 'asc')->get();
    $data['print'] = PrintSetting::where('slug', 'pay-slip')->first();
$report_data = [
        'component_analysis' => $this->getComponentAnalysisData(),
        // ... other data
    ];
    // Extract filter variables for consistent use
    $salary_type = $data['selected_salary_type'];
    $department = $data['selected_department'];
    $designation = $data['selected_designation'];
    $shift = $data['selected_shift'];
    $contract_type = $data['selected_contract'];
    $month = $data['selected_month'];
    $year = $data['selected_year'];

    // Get the main payroll table data with filters
    $data['rows'] = $this->getFilteredPayrollData($year, $month, $department, $designation, $salary_type, $shift, $contract_type);

    // Enhanced Report Data
    $data['report_data'] = $this->getEnhancedReportData($year, $month, $department, $designation, $salary_type, $shift, $contract_type);

    return view($this->view.'.report', $data);
}

private function getFilteredPayrollData($year, $month, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    $query = DB::table('payroll_entries as pe')
        ->join('payroll_runs as pr', 'pe.payroll_run_id', '=', 'pr.id')
        ->join('payroll_periods as pp', 'pr.payroll_period_id', '=', 'pp.id')
        ->join('users as u', 'pe.user_id', '=', 'u.id')
        ->leftJoin('departments as d', 'u.department_id', '=', 'd.id')
        ->leftJoin('designations as des', 'u.designation_id', '=', 'des.id')
        ->whereYear('pp.start_date', $year)
        ->whereMonth('pp.start_date', $month);

    // Apply filters
    if ($department && $department != '0') {
        $query->where('u.department_id', $department);
    }

    if ($designation && $designation != '0') {
        $query->where('u.designation_id', $designation);
    }

    if ($salary_type && $salary_type != '0') {
        $query->where('u.salary_type', $salary_type);
    }

    if ($shift && $shift != '0') {
        $query->where('u.work_shift', $shift);
    }

    if ($contract_type && $contract_type != '0') {
        $query->where('u.contract_type', $contract_type);
    }

    return $query->select(
        'pe.*',
        'pp.name as period_name',
        'u.staff_id',
        'u.first_name',
        'u.last_name',
        'u.salary_type',
        'd.title as department_name',
        'des.title as designation_name',
        'u.contract_type'
    )->get();
}

private function getEnhancedReportData($year, $month, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    $reportData = [];

    // 1. Payroll Summary Statistics
    $reportData['summary'] = $this->getPayrollSummary($year, $month, $department, $designation, $salary_type, $shift, $contract_type);

    // 2. Department-wise Analysis
    $reportData['department_analysis'] = $this->getDepartmentAnalysis($year, $month, $department, $designation, $salary_type, $shift, $contract_type);

    // 3. Monthly Comparison
    $reportData['monthly_comparison'] = $this->getMonthlyComparison($year, $department, $designation, $salary_type, $shift, $contract_type);

    // 4. Component Analysis
    $reportData['component_analysis'] = $this->getComponentAnalysis($year, $month, $department, $designation, $salary_type, $shift, $contract_type);

    // 5. Teacher/Staff Analysis by Department/Courses
    $reportData['staff_analysis'] = $this->getStaffAnalysis($department, $designation, $salary_type, $shift, $contract_type);

    // 6. Payment Status Distribution
    $reportData['payment_status'] = $this->getPaymentStatusDistribution($year, $month, $department, $designation, $salary_type, $shift, $contract_type);
    
     // 7. Deduction Analysis
    $reportData['deduction_analysis'] = $this->getDeductionAnalysis($year, $month, $department, $designation, $salary_type, $shift, $contract_type);
    
    return $reportData;
}

private function getPayrollSummary($year, $month, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    $query = DB::table('payroll_entries as pe')
        ->join('payroll_runs as pr', 'pe.payroll_run_id', '=', 'pr.id')
        ->join('payroll_periods as pp', 'pr.payroll_period_id', '=', 'pp.id')
        ->join('users as u', 'pe.user_id', '=', 'u.id')
        ->whereYear('pp.start_date', $year)
        ->whereMonth('pp.start_date', $month);

    // Apply all filters
    $this->applyFilters($query, $department, $designation, $salary_type, $shift, $contract_type);

    $stats = $query->select(
        DB::raw('COUNT(DISTINCT pe.user_id) as total_employees'),
        DB::raw('SUM(pe.gross_earnings) as total_gross_earnings'),
        DB::raw('SUM(pe.total_deductions) as total_deductions'),
        DB::raw('SUM(pe.net_pay) as total_net_pay'),
        DB::raw('AVG(pe.net_pay) as average_salary'),
        DB::raw('SUM(pe.paye_net) as total_tax'),
        DB::raw('SUM(CASE WHEN pe.is_paid = 1 THEN 1 ELSE 0 END) as paid_employees'),
        DB::raw('SUM(CASE WHEN pe.is_paid = 0 THEN 1 ELSE 0 END) as unpaid_employees')
    )->first();

    return [
        'total_employees' => $stats->total_employees ?? 0,
        'total_gross_earnings' => $stats->total_gross_earnings ?? 0,
        'total_deductions' => $stats->total_deductions ?? 0,
        'total_net_pay' => $stats->total_net_pay ?? 0,
        'average_salary' => $stats->average_salary ?? 0,
        'total_tax' => $stats->total_tax ?? 0,
        'paid_employees' => $stats->paid_employees ?? 0,
        'unpaid_employees' => $stats->unpaid_employees ?? 0,
    ];
}

private function getDepartmentAnalysis($year, $month, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    $query = DB::table('payroll_entries as pe')
        ->join('payroll_runs as pr', 'pe.payroll_run_id', '=', 'pr.id')
        ->join('payroll_periods as pp', 'pr.payroll_period_id', '=', 'pp.id')
        ->join('users as u', 'pe.user_id', '=', 'u.id')
        ->join('departments as d', 'u.department_id', '=', 'd.id')
        ->whereYear('pp.start_date', $year)
        ->whereMonth('pp.start_date', $month);

    // Apply filters except department (since we're grouping by it)
    if ($designation && $designation != '0') {
        $query->where('u.designation_id', $designation);
    }
    if ($salary_type && $salary_type != '0') {
        $query->where('u.salary_type', $salary_type);
    }
    if ($shift && $shift != '0') {
        $query->where('u.work_shift', $shift);
    }
    if ($contract_type && $contract_type != '0') {
        $query->where('u.contract_type', $contract_type);
    }

    return $query->select(
        'd.title as department_name',
        DB::raw('COUNT(DISTINCT pe.user_id) as employee_count'),
        DB::raw('SUM(pe.gross_earnings) as total_gross'),
        DB::raw('SUM(pe.net_pay) as total_net'),
        DB::raw('AVG(pe.net_pay) as avg_salary'),
        DB::raw('SUM(pe.total_deductions) as total_deductions')
    )
    ->groupBy('d.id', 'd.title')
    ->get();
}

private function getMonthlyComparison($year, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    $months = [];
    for ($i = 1; $i <= 12; $i++) {
        $query = DB::table('payroll_entries as pe')
            ->join('payroll_runs as pr', 'pe.payroll_run_id', '=', 'pr.id')
            ->join('payroll_periods as pp', 'pr.payroll_period_id', '=', 'pp.id')
            ->join('users as u', 'pe.user_id', '=', 'u.id') // Added missing join
            ->whereYear('pp.start_date', $year)
            ->whereMonth('pp.start_date', $i);

        // Apply filters
        $this->applyFilters($query, $department, $designation, $salary_type, $shift, $contract_type);

        $monthData = $query->select(
            DB::raw('SUM(pe.gross_earnings) as total_gross'),
            DB::raw('SUM(pe.net_pay) as total_net'),
            DB::raw('COUNT(DISTINCT pe.user_id) as employee_count')
        )->first();

        $months[$i] = [
            'month' => date('F', mktime(0, 0, 0, $i, 1)),
            'total_gross' => $monthData->total_gross ?? 0,
            'total_net' => $monthData->total_net ?? 0,
            'employee_count' => $monthData->employee_count ?? 0
        ];
    }

    return $months;
}

private function getComponentAnalysis($year, $month, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    // Get payroll period ID
    $payrollPeriod = DB::table('payroll_periods')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->first();

    if (!$payrollPeriod) {
        return collect([]);
    }

    // Get component usage from employee_payroll_drafts with user joins for filtering
    $query = DB::table('employee_payroll_drafts as epd')
        ->join('users as u', 'epd.user_id', '=', 'u.id')
        ->join('payroll_components as pc', function($join) {
            $join->whereRaw('JSON_CONTAINS(epd.selected_components, JSON_OBJECT("component_id", pc.id))');
        })
        ->where('epd.payroll_period_id', $payrollPeriod->id);

    // Apply filters
    if ($department && $department != '0') {
        $query->where('u.department_id', $department);
    }
    if ($designation && $designation != '0') {
        $query->where('u.designation_id', $designation);
    }
    if ($salary_type && $salary_type != '0') {
        $query->where('u.salary_type', $salary_type);
    }
    if ($shift && $shift != '0') {
        $query->where('u.work_shift', $shift);
    }
    if ($contract_type && $contract_type != '0') {
        $query->where('u.contract_type', $contract_type);
    }

    $componentUsage = $query->select(
        'pc.name as component_name',
        'pc.type as component_type',
        DB::raw('COUNT(DISTINCT epd.user_id) as usage_count')
    )
    ->groupBy('pc.id', 'pc.name', 'pc.type')
    ->get();

    return $componentUsage;
}

private function getStaffAnalysis($department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    $query = DB::table('users as u')
        ->leftJoin('departments as d', 'u.department_id', '=', 'd.id')
        ->leftJoin('designations as des', 'u.designation_id', '=', 'des.id')
        ->leftJoin('payroll_entries as pe', function($join) {
            $join->on('u.id', '=', 'pe.user_id');
        })
        ->where('u.status', 1);

    // Apply all filters
    $this->applyUserFilters($query, $department, $designation, $salary_type, $shift, $contract_type);

    return $query->select(
        'u.id',
        'u.staff_id',
        'u.first_name',
        'u.last_name',
        'd.title as department',
        'des.title as designation',
        DB::raw('COALESCE(pe.net_pay, 0) as current_salary'),
        DB::raw('COALESCE(pe.gross_earnings, 0) as gross_salary'),
        'u.contract_type',
        'u.salary_type'
    )
    ->groupBy('u.id', 'u.staff_id', 'u.first_name', 'u.last_name', 'd.title', 'des.title', 'pe.net_pay', 'pe.gross_earnings', 'u.contract_type', 'u.salary_type')
    ->get();
}

private function getPaymentStatusDistribution($year, $month, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    $query = DB::table('payroll_entries as pe')
        ->join('payroll_runs as pr', 'pe.payroll_run_id', '=', 'pr.id')
        ->join('payroll_periods as pp', 'pr.payroll_period_id', '=', 'pp.id')
        ->join('users as u', 'pe.user_id', '=', 'u.id')
        ->whereYear('pp.start_date', $year)
        ->whereMonth('pp.start_date', $month);

    // Apply filters
    $this->applyFilters($query, $department, $designation, $salary_type, $shift, $contract_type);

    $statusData = $query->select(
        DB::raw('COUNT(CASE WHEN pe.is_paid = 1 THEN 1 END) as paid'),
        DB::raw('COUNT(CASE WHEN pe.is_paid = 0 THEN 1 END) as unpaid')
    )->first();

    return [
        'paid' => $statusData->paid ?? 0,
        'unpaid' => $statusData->unpaid ?? 0
    ];
}

// Helper method to apply filters to payroll queries
private function applyFilters($query, $department, $designation, $salary_type, $shift, $contract_type)
{
    if ($department && $department != '0') {
        $query->where('u.department_id', $department);
    }
    if ($designation && $designation != '0') {
        $query->where('u.designation_id', $designation);
    }
    if ($salary_type && $salary_type != '0') {
        $query->where('u.salary_type', $salary_type);
    }
    if ($shift && $shift != '0') {
        $query->where('u.work_shift', $shift);
    }
    if ($contract_type && $contract_type != '0') {
        $query->where('u.contract_type', $contract_type);
    }
}

// Helper method to apply filters to user queries
private function applyUserFilters($query, $department, $designation, $salary_type, $shift, $contract_type)
{
    if ($department && $department != '0') {
        $query->where('u.department_id', $department);
    }
    if ($designation && $designation != '0') {
        $query->where('u.designation_id', $designation);
    }
    if ($salary_type && $salary_type != '0') {
        $query->where('u.salary_type', $salary_type);
    }
    if ($shift && $shift != '0') {
        $query->where('u.work_shift', $shift);
    }
    if ($contract_type && $contract_type != '0') {
        $query->where('u.contract_type', $contract_type);
    }
}

private function getDeductionAnalysis($year, $month, $department = null, $designation = null, $salary_type = null, $shift = null, $contract_type = null)
{
    // Get payroll period ID
    $payrollPeriod = DB::table('payroll_periods')
        ->whereYear('start_date', $year)
        ->whereMonth('start_date', $month)
        ->first();

    if (!$payrollPeriod) {
        return collect([]);
    }

    // Get all employee payroll drafts with deduction data
    $query = DB::table('employee_payroll_drafts as epd')
        ->join('users as u', 'epd.user_id', '=', 'u.id')
        ->where('epd.payroll_period_id', $payrollPeriod->id);

    // Apply filters
    if ($department && $department != '0') {
        $query->where('u.department_id', $department);
    }
    if ($designation && $designation != '0') {
        $query->where('u.designation_id', $designation);
    }
    if ($salary_type && $salary_type != '0') {
        $query->where('u.salary_type', $salary_type);
    }
    if ($shift && $shift != '0') {
        $query->where('u.work_shift', $shift);
    }
    if ($contract_type && $contract_type != '0') {
        $query->where('u.contract_type', $contract_type);
    }

    $employeeDrafts = $query->select(
        'epd.id',
        'epd.user_id',
        'epd.selected_components',
        'epd.custom_deductions',
        'u.first_name',
        'u.last_name',
        'u.staff_id'
    )->get();

    // Process deductions to get individual breakdown
    $deductionBreakdown = [];

    foreach ($employeeDrafts as $draft) {
        // Process selected components (from payroll_components table)
        $selectedComponents = $this->safeJsonDecode($draft->selected_components);
        if (is_array($selectedComponents)) {
            foreach ($selectedComponents as $component) {
                if (is_array($component) && 
                    isset($component['type']) && 
                    $component['type'] === 'deduction' && 
                    isset($component['amount']) && 
                    $component['amount'] > 0) {
                    
                    $deductionName = $component['name'] ?? 'Unknown Deduction';
                    $amount = floatval($component['amount']);
                    
                    if (!isset($deductionBreakdown[$deductionName])) {
                        $deductionBreakdown[$deductionName] = [
                            'deduction_name' => $deductionName,
                            'total_amount' => 0,
                            'employee_count' => 0,
                            'category' => $component['category'] ?? 'General',
                            'is_statutory' => $component['is_statutory'] ?? false,
                            'source' => 'Component'
                        ];
                    }
                    
                    $deductionBreakdown[$deductionName]['total_amount'] += $amount;
                    $deductionBreakdown[$deductionName]['employee_count']++;
                }
            }
        }

        // Process custom deductions (manually entered - show each by name)
        $customDeductions = $this->safeJsonDecode($draft->custom_deductions);
        if (is_array($customDeductions)) {
            foreach ($customDeductions as $deduction) {
                if (is_array($deduction) && 
                    !empty($deduction['name']) && 
                    isset($deduction['amount']) && 
                    $deduction['amount'] > 0) {
                    
                    $deductionName = $deduction['name'];
                    $amount = floatval($deduction['amount']);
                    
                    if (!isset($deductionBreakdown[$deductionName])) {
                        $deductionBreakdown[$deductionName] = [
                            'deduction_name' => $deductionName,
                            'total_amount' => 0,
                            'employee_count' => 0,
                            'category' => 'Custom',
                            'is_statutory' => false,
                            'source' => 'Custom'
                        ];
                    }
                    
                    $deductionBreakdown[$deductionName]['total_amount'] += $amount;
                    $deductionBreakdown[$deductionName]['employee_count']++;
                }
            }
        }
    }

    // Get statutory deductions from payroll_entries - show each by name
    $payrollEntriesQuery = DB::table('payroll_entries as pe')
        ->join('payroll_runs as pr', 'pe.payroll_run_id', '=', 'pr.id')
        ->join('payroll_periods as pp', 'pr.payroll_period_id', '=', 'pp.id')
        ->join('users as u', 'pe.user_id', '=', 'u.id')
        ->whereYear('pp.start_date', $year)
        ->whereMonth('pp.start_date', $month);

    // Apply filters
    $this->applyFilters($payrollEntriesQuery, $department, $designation, $salary_type, $shift, $contract_type);

    $statutoryEntries = $payrollEntriesQuery->select(
        'pe.id',
        'pe.user_id',
        'pe.nssf_employee',
        'pe.nhif',
        'pe.paye_net',
        'pe.loan_deductions',
        'pe.other_deductions',
        'u.staff_id'
    )->get();

    // Process statutory deductions individually
    foreach ($statutoryEntries as $entry) {
        // NSSF
        if ($entry->nssf_employee > 0) {
            $deductionName = 'NSSF';
            if (!isset($deductionBreakdown[$deductionName])) {
                $deductionBreakdown[$deductionName] = [
                    'deduction_name' => $deductionName,
                    'total_amount' => 0,
                    'employee_count' => 0,
                    'category' => 'Statutory',
                    'is_statutory' => true,
                    'source' => 'Statutory'
                ];
            }
            $deductionBreakdown[$deductionName]['total_amount'] += $entry->nssf_employee;
            $deductionBreakdown[$deductionName]['employee_count']++;
        }

        // NHIF
        if ($entry->nhif > 0) {
            $deductionName = 'NHIF';
            if (!isset($deductionBreakdown[$deductionName])) {
                $deductionBreakdown[$deductionName] = [
                    'deduction_name' => $deductionName,
                    'total_amount' => 0,
                    'employee_count' => 0,
                    'category' => 'Statutory',
                    'is_statutory' => true,
                    'source' => 'Statutory'
                ];
            }
            $deductionBreakdown[$deductionName]['total_amount'] += $entry->nhif;
            $deductionBreakdown[$deductionName]['employee_count']++;
        }

        // PAYE
        if ($entry->paye_net > 0) {
            $deductionName = 'PAYE';
            if (!isset($deductionBreakdown[$deductionName])) {
                $deductionBreakdown[$deductionName] = [
                    'deduction_name' => $deductionName,
                    'total_amount' => 0,
                    'employee_count' => 0,
                    'category' => 'Statutory',
                    'is_statutory' => true,
                    'source' => 'Statutory'
                ];
            }
            $deductionBreakdown[$deductionName]['total_amount'] += $entry->paye_net;
            $deductionBreakdown[$deductionName]['employee_count']++;
        }

        // Loan Deductions
        if ($entry->loan_deductions > 0) {
            $deductionName = 'Loan Deductions';
            if (!isset($deductionBreakdown[$deductionName])) {
                $deductionBreakdown[$deductionName] = [
                    'deduction_name' => $deductionName,
                    'total_amount' => 0,
                    'employee_count' => 0,
                    'category' => 'Loans',
                    'is_statutory' => false,
                    'source' => 'Statutory'
                ];
            }
            $deductionBreakdown[$deductionName]['total_amount'] += $entry->loan_deductions;
            $deductionBreakdown[$deductionName]['employee_count']++;
        }

        // Other Deductions - This shows the total but we want individual names
        // Since other_deductions is a total, we'll show it as "Other Deductions"
        if ($entry->other_deductions > 0) {
            $deductionName = 'Other Deductions';
            if (!isset($deductionBreakdown[$deductionName])) {
                $deductionBreakdown[$deductionName] = [
                    'deduction_name' => $deductionName,
                    'total_amount' => 0,
                    'employee_count' => 0,
                    'category' => 'Other',
                    'is_statutory' => false,
                    'source' => 'Statutory'
                ];
            }
            $deductionBreakdown[$deductionName]['total_amount'] += $entry->other_deductions;
            $deductionBreakdown[$deductionName]['employee_count']++;
        }
    }

    // Convert to collection and calculate averages
    $result = collect($deductionBreakdown)->map(function ($item) {
        $item['average_amount'] = $item['employee_count'] > 0 ? $item['total_amount'] / $item['employee_count'] : 0;
        return (object) $item;
    });

    return $result->sortByDesc('total_amount')->values();
}

/**
 * Safely decode JSON with proper error handling
 */
private function safeJsonDecode($jsonString)
{
    if (empty($jsonString)) {
        return [];
    }

    // If it's already an array, return it
    if (is_array($jsonString)) {
        return $jsonString;
    }

    // If it's already an object, convert to array
    if (is_object($jsonString)) {
        return (array) $jsonString;
    }

    // If it's not a string, return empty array
    if (!is_string($jsonString)) {
        return [];
    }

    // Try to decode the JSON
    $decoded = json_decode($jsonString, true);

    // Check for JSON decoding errors
    if (json_last_error() !== JSON_ERROR_NONE) {
        \Log::warning('JSON decode error in deduction analysis', [
            'error' => json_last_error_msg(),
            'input' => substr($jsonString, 0, 100)
        ]);
        return [];
    }

    return $decoded ?? [];
}

private function getComponentAnalysisData()
{
    return DB::table('payroll_components')
        ->where('is_active', 1)
        ->select(
            'id',
            'name',
            'code',
            'type',
            'category',
            'calculation_type',
            'default_amount',
            'percentage',
            'is_taxable',
            'is_statutory',
            'is_system_defined',
            'description',
            'created_at'
        )
        ->orderBy('category')
        ->orderBy('name')
        ->get()
        ->groupBy('category');
}

}