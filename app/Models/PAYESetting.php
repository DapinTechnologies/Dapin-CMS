<?php
// app/Models/PAYESetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PAYESetting extends Model
{
    use HasFactory;
protected $table = 'paye_settings';

   
    protected $fillable = [
        'min_amount',
        'max_amount',
        'rate',
        'order',
        'is_active'
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'rate' => 'decimal:4',
        'order' => 'integer',
        'is_active' => 'boolean'
    ];

    /**
     * Scope active PAYE bands
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate PAYE tax for a given annual income
     */
    public static function calculateAnnualTax($annualIncome)
    {
        $taxBands = static::active()->orderBy('order')->get();
        $annualTax = 0;
        $remainingIncome = $annualIncome;

        foreach ($taxBands as $band) {
            if ($remainingIncome <= 0) break;

            if ($remainingIncome > $band->min_amount) {
                $bandWidth = $band->max_amount - $band->min_amount;
                $taxableInBand = min($remainingIncome - $band->min_amount, $bandWidth);
                
                if ($taxableInBand > 0) {
                    $annualTax += $taxableInBand * ($band->rate / 100);
                }
            }
        }

        return $annualTax;
    }

    /**
     * Calculate monthly PAYE tax
     */
    public static function calculateMonthlyTax($monthlyIncome)
    {
        $annualIncome = $monthlyIncome * 12;
        $annualTax = static::calculateAnnualTax($annualIncome);
        return $annualTax / 12;
    }
}