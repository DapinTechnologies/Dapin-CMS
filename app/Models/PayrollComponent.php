<?php
// app/Models/PayrollComponent.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollComponent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'category',
        'calculation_type',
        'default_amount',
        'percentage',
        'minimum_amount',
        'is_taxable',
        'is_active',
        'description'
    ];

    protected $casts = [
        'default_amount' => 'decimal:2',
        'percentage' => 'decimal:4',
        'minimum_amount' => 'decimal:2',
        'is_taxable' => 'boolean',
        'is_active' => 'boolean'
    ];

    /**
     * Employee preferences relationship
     */
    public function preferences()
    {
        return $this->hasMany(EmployeePayrollPreference::class);
    }

    /**
     * Active employee preferences relationship
     */
    public function activePreferences()
    {
        return $this->hasMany(EmployeePayrollPreference::class)->where('is_active', true);
    }

    /**
     * Scope active components
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope earnings
     */
    public function scopeEarnings($query)
    {
        return $query->where('type', 'earning');
    }

    /**
     * Scope deductions
     */
    public function scopeDeductions($query)
    {
        return $query->where('type', 'deduction');
    }

    /**
     * Check if component should be applied based on minimum amount threshold
     */
    public function shouldApply($baseAmount)
    {
        if ($this->type === 'deduction' && $this->minimum_amount > 0) {
            return $baseAmount >= $this->minimum_amount;
        }
        
        return true;
    }

    /**
     * Get display name with code
     */
    public function getDisplayNameAttribute()
    {
        return "{$this->name} ({$this->code})";
    }

    /**
     * Check if component can be deleted
     */
    public function getCanBeDeletedAttribute()
    {
        return $this->preferences()->count() === 0;
    }

    /**
     * Check if component can be deactivated
     */
    public function getCanBeDeactivatedAttribute()
    {
        return $this->is_active && $this->activePreferences()->count() === 0;
    }

    /**
     * Boot method for model events
     */
    protected static function boot()
    {
        parent::boot();

        // Prevent deletion of components with preferences
        static::deleting(function ($component) {
            if ($component->preferences()->count() > 0) {
                throw new \Exception('Cannot delete payroll component with active employee preferences.');
            }
        });

        // Prevent deactivation of components with active preferences
        static::updating(function ($component) {
            if ($component->isDirty('is_active') && !$component->is_active) {
                if ($component->activePreferences()->count() > 0) {
                    throw new \Exception('Cannot deactivate payroll component with active employee preferences.');
                }
            }
        });
    }
}