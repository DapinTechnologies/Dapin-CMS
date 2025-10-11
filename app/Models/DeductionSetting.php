<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'fixed_amount',
        'rate',
        'min_salary',
        'max_salary',
        'min_amount',
        'max_amount',
        'percentage',
        'max_no_deduction_amount',
        'is_statutory',
        'status',
        'description'
    ];

    protected $casts = [
        'fixed_amount' => 'decimal:2',
        'rate' => 'decimal:4',
        'min_salary' => 'decimal:2',
        'max_salary' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'percentage' => 'decimal:2',
        'max_no_deduction_amount' => 'decimal:2',
        'is_statutory' => 'boolean',
        'status' => 'boolean',
    ];

    // Add the missing scope methods
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeStatutory($query)
    {
        return $query->where('is_statutory', true);
    }

    public function scopeNonStatutory($query)
    {
        return $query->where('is_statutory', false);
    }
}