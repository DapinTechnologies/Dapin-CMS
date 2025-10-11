<?php
// app/Models/EmployeePayrollDraft.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayrollDraft extends Model
{
    use HasFactory;

    protected $table = 'employee_payroll_drafts';

    protected $fillable = [
        'user_id',
        'payroll_period_id',
        'basic_salary',
        'selected_components',
        'custom_allowances',
        'custom_deductions',
        'gross_earnings',
        'total_deductions',
        'net_pay',
        'is_locked',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'basic_salary' => 'decimal:2',
        'gross_earnings' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'is_locked' => 'boolean',
        'selected_components' => 'array',
        'custom_allowances' => 'array',
        'custom_deductions' => 'array',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function period()
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope for active drafts (not locked)
     */
    public function scopeActive($query)
    {
        return $query->where('is_locked', false);
    }

    /**
     * Scope for locked drafts
     */
    public function scopeLocked($query)
    {
        return $query->where('is_locked', true);
    }

    /**
     * Get draft for specific employee and period
     */
    public function scopeForEmployeeAndPeriod($query, $userId, $periodId)
    {
        return $query->where('user_id', $userId)
                    ->where('payroll_period_id', $periodId);
    }

    /**
     * Check if draft exists for employee and period
     */
    public static function existsForEmployeeAndPeriod($userId, $periodId)
    {
        return static::where('user_id', $userId)
                    ->where('payroll_period_id', $periodId)
                    ->exists();
    }

    /**
     * Lock the draft to prevent further edits
     */
    public function lock()
    {
        $this->update(['is_locked' => true]);
    }

    /**
     * Unlock the draft for editing
     */
    public function unlock()
    {
        $this->update(['is_locked' => false]);
    }

    /**
     * Check if draft is locked
     */
    public function isLocked()
    {
        return $this->is_locked;
    }

    /**
     * Get formatted basic salary
     */
    public function getFormattedBasicSalaryAttribute()
    {
        return 'KES ' . number_format($this->basic_salary, 2);
    }

    /**
     * Get formatted gross earnings
     */
    public function getFormattedGrossEarningsAttribute()
    {
        return 'KES ' . number_format($this->gross_earnings, 2);
    }

    /**
     * Get formatted total deductions
     */
    public function getFormattedTotalDeductionsAttribute()
    {
        return 'KES ' . number_format($this->total_deductions, 2);
    }

    /**
     * Get formatted net pay
     */
    public function getFormattedNetPayAttribute()
    {
        return 'KES ' . number_format($this->net_pay, 2);
    }

    /**
     * Get selected components as array
     */
    public function getSelectedComponentsArrayAttribute()
    {
        return is_array($this->selected_components) 
            ? $this->selected_components 
            : json_decode($this->selected_components, true) ?? [];
    }

    /**
     * Get custom allowances as array
     */
    public function getCustomAllowancesArrayAttribute()
    {
        return is_array($this->custom_allowances) 
            ? $this->custom_allowances 
            : json_decode($this->custom_allowances, true) ?? [];
    }

    /**
     * Get custom deductions as array
     */
    public function getCustomDeductionsArrayAttribute()
    {
        return is_array($this->custom_deductions) 
            ? $this->custom_deductions 
            : json_decode($this->custom_deductions, true) ?? [];
    }

    /**
     * Calculate total allowances from selected components and custom allowances
     */
    public function getTotalAllowancesAttribute()
    {
        $total = 0;
        
        // From selected components
        foreach ($this->selected_components_array as $component) {
            if ($component['type'] === 'earning') {
                $total += $component['amount'] ?? 0;
            }
        }
        
        // From custom allowances
        foreach ($this->custom_allowances_array as $allowance) {
            $total += $allowance['amount'] ?? 0;
        }
        
        return $total;
    }

    /**
     * Calculate total deductions from selected components and custom deductions
     */
    public function getTotalDeductionsCalculatedAttribute()
    {
        $total = 0;
        
        // From selected components
        foreach ($this->selected_components_array as $component) {
            if ($component['type'] === 'deduction') {
                $total += $component['amount'] ?? 0;
            }
        }
        
        // From custom deductions
        foreach ($this->custom_deductions_array as $deduction) {
            $total += $deduction['amount'] ?? 0;
        }
        
        return $total;
    }

    /**
     * Recalculate and update the draft totals
     */
    public function recalculateTotals()
    {
        $totalAllowances = $this->total_allowances;
        $totalDeductions = $this->total_deductions_calculated;
        
        $grossEarnings = $this->basic_salary + $totalAllowances;
        $netPay = $grossEarnings - $totalDeductions;
        
        $this->update([
            'gross_earnings' => $grossEarnings,
            'total_deductions' => $totalDeductions,
            'net_pay' => $netPay
        ]);
    }
}