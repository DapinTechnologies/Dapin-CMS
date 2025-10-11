<?php
// app/Models/EmployeePayrollPreference.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePayrollPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payroll_component_id',
        'amount',
        'percentage',
        'is_active'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'percentage' => 'decimal:4',
        'is_active' => 'boolean'
    ];

    /**
     * Employee relationship
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Component relationship
     */
    public function component()
    {
        return $this->belongsTo(PayrollComponent::class, 'payroll_component_id');
    }

    /**
     * Scope active preferences
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate the actual amount for this preference
     */
    public function calculateAmount($baseAmount = 0)
    {
        if ($this->amount !== null) {
            return $this->amount;
        }

        if ($this->percentage !== null) {
            return $baseAmount * ($this->percentage / 100);
        }

        return $this->component->calculateAmount($baseAmount);
    }
}