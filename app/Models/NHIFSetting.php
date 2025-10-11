<?php
// app/Models/NHIFSetting.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NHIFSetting extends Model
{
    use HasFactory;

    // 👇 Add this line
    protected $table = 'nhif_settings';
    
    protected $fillable = [
        'min_amount',
        'max_amount',
        'premium',
        'is_active'
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'premium' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Scope active NHIF bands
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get NHIF premium for a given salary
     */
    public static function getPremiumForSalary($salary)
    {
        return static::active()
            ->where('min_amount', '<=', $salary)
            ->where('max_amount', '>=', $salary)
            ->first();
    }
}