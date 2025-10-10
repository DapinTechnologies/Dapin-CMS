<?php
// app/Models/PayrollEntry.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_run_id',
        'user_id',
        'payroll_snapshot_id',
        'attendance_days',
        'attendance_hours',
        'working_days',
        'working_hours',
        'basic_salary',
        'taxable_allowances',
        'non_taxable_allowances',
        'overtime_earnings',
        'bonuses',
        'gross_earnings',
        'taxable_earnings',
        'nssf_employee',
        'nssf_employer',
        'nhif',
        'paye_gross',
        'personal_relief',
        'paye_net',
        'loan_deductions',
        'other_deductions',
        'total_deductions',
        'net_pay',
        'is_paid',
        'paid_at'
    ];

    protected $casts = [
        'attendance_days' => 'integer',
        'attendance_hours' => 'integer',
        'working_days' => 'integer',
        'working_hours' => 'integer',
        'basic_salary' => 'decimal:2',
        'taxable_allowances' => 'decimal:2',
        'non_taxable_allowances' => 'decimal:2',
        'overtime_earnings' => 'decimal:2',
        'bonuses' => 'decimal:2',
        'gross_earnings' => 'decimal:2',
        'taxable_earnings' => 'decimal:2',
        'nssf_employee' => 'decimal:2',
        'nssf_employer' => 'decimal:2',
        'nhif' => 'decimal:2',
        'paye_gross' => 'decimal:2',
        'personal_relief' => 'decimal:2',
        'paye_net' => 'decimal:2',
        'loan_deductions' => 'decimal:2',
        'other_deductions' => 'decimal:2',
        'total_deductions' => 'decimal:2',
        'net_pay' => 'decimal:2',
        'is_paid' => 'boolean',
        'paid_at' => 'date'
    ];

    /**
     * Payroll run relationship
     */
    public function run()
    {
        return $this->belongsTo(PayrollRun::class, 'payroll_run_id');
    }

    /**
     * Employee relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Payroll snapshot relationship
     */
    public function snapshot()
    {
        return $this->belongsTo(PayrollSnapshot::class, 'payroll_snapshot_id');
    }

    /**
     * Payment records relationship
     */
    public function payments()
    {
        return $this->hasMany(PayrollPayment::class);
    }

    /**
     * Scope paid entries
     */
    public function scopePaid($query)
    {
        return $query->where('is_paid', true);
    }

    /**
     * Scope unpaid entries
     */
    public function scopeUnpaid($query)
    {
        return $query->where('is_paid', false);
    }

    /**
     * Get attendance rate (percentage)
     */
    public function getAttendanceRateAttribute()
    {
        if ($this->working_days == 0) return 0;
        return ($this->attendance_days / $this->working_days) * 100;
    }

    /**
     * Get total allowances
     */
    public function getTotalAllowancesAttribute()
    {
        return $this->taxable_allowances + $this->non_taxable_allowances;
    }

    /**
     * Get total statutory deductions
     */
    public function getTotalStatutoryDeductionsAttribute()
    {
        return $this->nssf_employee + $this->nhif + $this->paye_net;
    }

    /**
     * Get total non-statutory deductions
     */
    public function getTotalNonStatutoryDeductionsAttribute()
    {
        return $this->loan_deductions + $this->other_deductions;
    }

    /**
     * Get employer total cost
     */
    public function getEmployerTotalCostAttribute()
    {
        return $this->gross_earnings + $this->nssf_employer;
    }

    /**
     * Check if entry has partial payment
     */
    public function getHasPartialPaymentAttribute()
    {
        $totalPaid = $this->payments->sum('amount');
        return $totalPaid > 0 && $totalPaid < $this->net_pay;
    }

    /**
     * Get total amount paid so far
     */
    public function getTotalPaidAttribute()
    {
        return $this->payments->sum('amount');
    }

    /**
     * Get remaining amount to pay
     */
    public function getRemainingAmountAttribute()
    {
        return $this->net_pay - $this->total_paid;
    }

    /**
     * Mark as paid
     */
    public function markAsPaid($paymentDate = null)
    {
        $this->update([
            'is_paid' => true,
            'paid_at' => $paymentDate ?? now()
        ]);
    }

    /**
     * Mark as unpaid
     */
    public function markAsUnpaid()
    {
        $this->update([
            'is_paid' => false,
            'paid_at' => null
        ]);
    }
}