<?php
// app/Models/PayrollPeriod.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PayrollPeriod extends Model
{
    use HasFactory;

    protected $fillable = [
    'period_id',
    'name',
    'start_date',
    'end_date',
    'is_locked'
];


    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_locked' => 'boolean'
    ];

    /**
     * Payroll runs relationship
     */
    public function payrollRuns()
    {
        return $this->hasMany(PayrollRun::class);
    }

    /**
     * Scope unlocked periods
     */
    public function scopeUnlocked($query)
    {
        return $query->where('is_locked', false);
    }

    /**
     * Scope locked periods
     */
    public function scopeLocked($query)
    {
        return $query->where('is_locked', true);
    }

    /**
     * Scope current period
     */
    public function scopeCurrent($query)
    {
        $today = Carbon::today();
        return $query->where('start_date', '<=', $today)
                    ->where('end_date', '>=', $today);
    }

    /**
     * Check if period is current
     */
    public function getIsCurrentAttribute()
    {
        $today = Carbon::today();
        return $this->start_date <= $today && $this->end_date >= $today;
    }

    /**
     * Get period duration in days
     */
    public function getDurationInDaysAttribute()
    {
        return $this->start_date->diffInDays($this->end_date) + 1;
    }

    /**
     * Create monthly periods for a given year
     */
    public static function createMonthlyPeriods($year)
    {
        $periods = [];
        
        for ($month = 1; $month <= 12; $month++) {
            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            
            $periods[] = [
                'name' => $startDate->format('F Y'),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'is_locked' => false,
                'created_at' => now(),
                'updated_at' => now()
            ];
        }
        
        return static::insert($periods);
    }
}