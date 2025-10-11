<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BursaryType extends Model
{
    use HasFactory;

    protected $table = 'bursary_types';

    protected $fillable = [
        'name',
        'code',
        'description',
        'initial_amount',
        'current_balance',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'initial_amount' => 'decimal:2',
        'current_balance' => 'decimal:2',
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'bursary_type', 'code');
    }
}