<?php
// app/Models/TaxRelief.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRelief extends Model
{
    use HasFactory;
protected $table = 'tax_reliefs';
    protected $fillable = [
        'name',
        'code',
        'amount',
        'description',
        'is_active'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Scope active tax reliefs
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get relief amount by code
     */
    public static function getAmountByCode($code)
    {
        $relief = static::active()->where('code', $code)->first();
        return $relief ? $relief->amount : 0;
    }

    /**
     * Get personal relief amount
     */
    public static function getPersonalRelief()
    {
        return static::getAmountByCode('personal_relief');
    }
}