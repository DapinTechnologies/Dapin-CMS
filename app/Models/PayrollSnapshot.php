<?php
// app/Models/PayrollSnapshot.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollSnapshot extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payroll_run_id',
        'earnings_snapshot',
        'deductions_snapshot'
    ];

    protected $casts = [
        'earnings_snapshot' => 'array',
        'deductions_snapshot' => 'array'
    ];

    /**
     * Employee relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Payroll run relationship
     */
    public function payrollRun()
    {
        return $this->belongsTo(PayrollRun::class);
    }

    /**
     * Payroll entries relationship
     */
    public function payrollEntries()
    {
        return $this->hasMany(PayrollEntry::class);
    }

    /**
     * Get total earnings from snapshot
     */
    public function getTotalEarningsAttribute()
    {
        $total = 0;
        foreach ($this->earnings_snapshot as $earning) {
            $total += $earning['amount'] ?? $earning['component']['default_amount'] ?? 0;
        }
        return $total;
    }

    /**
     * Get total deductions from snapshot
     */
    public function getTotalDeductionsAttribute()
    {
        $total = 0;
        foreach ($this->deductions_snapshot as $deduction) {
            $total += $deduction['amount'] ?? $deduction['component']['default_amount'] ?? 0;
        }
        return $total;
    }
}