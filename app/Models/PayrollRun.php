<?php
// app/Models/PayrollRun.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollRun extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_period_id',
        'status',
        'run_date',
        'notes',
        'generated_by', // Make sure this field exists
        'total_employees',
        'successful_entries',
        'failed_entries'
    ];

    protected $casts = [
        'run_date' => 'date',
        'notes' => 'string'
    ];

    /**
     * Payroll period relationship
     */
    public function period()
    {
        return $this->belongsTo(PayrollPeriod::class, 'payroll_period_id');
    }

    /**
     * User who generated this payroll run (generator relationship)
     */
    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    /**
     * Payroll entries relationship
     */
    public function entries()
    {
        return $this->hasMany(PayrollEntry::class);
    }

    /**
     * Payroll snapshots relationship
     */
    public function snapshots()
    {
        return $this->hasMany(PayrollSnapshot::class);
    }

    /**
     * Scope by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope draft runs
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    /**
     * Scope computed runs
     */
    public function scopeComputed($query)
    {
        return $query->where('status', 'computed');
    }

    /**
     * Scope paid runs
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Scope locked runs
     */
    public function scopeLocked($query)
    {
        return $query->where('status', 'locked');
    }

    /**
     * Get total gross earnings for this run
     */
    public function getTotalGrossEarningsAttribute()
    {
        return $this->entries->sum('gross_earnings');
    }

    /**
     * Get total net pay for this run
     */
    public function getTotalNetPayAttribute()
    {
        return $this->entries->sum('net_pay');
    }

    /**
     * Get total PAYE tax for this run
     */
    public function getTotalPayeTaxAttribute()
    {
        return $this->entries->sum('paye_net');
    }

    /**
     * Get total NSSF employee contributions for this run
     */
    public function getTotalNssfEmployeeAttribute()
    {
        return $this->entries->sum('nssf_employee');
    }

    /**
     * Get total NSSF employer contributions for this run
     */
    public function getTotalNssfEmployerAttribute()
    {
        return $this->entries->sum('nssf_employer');
    }

    /**
     * Get total NHIF contributions for this run
     */
    public function getTotalNhifAttribute()
    {
        return $this->entries->sum('nhif');
    }

    /**
     * Check if run can be edited
     */
    public function getCanEditAttribute()
    {
        return in_array($this->status, ['draft', 'computed']);
    }

    /**
     * Check if run can be paid
     */
    public function getCanPayAttribute()
    {
        return $this->status === 'computed';
    }

    /**
     * Get count of paid entries
     */
    public function getPaidEntriesCountAttribute()
    {
        return $this->entries->where('is_paid', true)->count();
    }

    /**
     * Get count of unpaid entries
     */
    public function getUnpaidEntriesCountAttribute()
    {
        return $this->entries->where('is_paid', false)->count();
    }
}