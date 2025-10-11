<?php
// app/Models/NSSFSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NSSFSetting extends Model
{
    use HasFactory;

    // Explicitly define table name
    protected $table = 'nssf_settings';

    protected $fillable = [
        'tier',
        'min_amount',
        'max_amount',
        'employee_rate',
        'employer_rate',
        'employee_max',
        'employer_max',
        'is_active'
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'employee_rate' => 'decimal:4',
        'employer_rate' => 'decimal:4',
        'employee_max' => 'decimal:2',
        'employer_max' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Scope active NSSF tiers
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate NSSF contributions for a given pensionable pay
     */
    public static function calculateContributions($pensionablePay)
    {
        $tiers = static::active()->orderBy('min_amount')->get();
        
        $employeeContribution = 0;
        $employerContribution = 0;

        foreach ($tiers as $tier) {
            if ($pensionablePay > $tier->min_amount) {
                $tierAmount = min($pensionablePay, $tier->max_amount) - $tier->min_amount;
                $employeeContribution += min($tierAmount * $tier->employee_rate, $tier->employee_max);
                $employerContribution += min($tierAmount * $tier->employer_rate, $tier->employer_max);
            }
        }

        return [
            'employee' => $employeeContribution,
            'employer' => $employerContribution
        ];
    }
}