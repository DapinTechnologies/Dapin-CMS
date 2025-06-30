<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bursary extends Model
{
    protected $fillable = [
        'fund_id', 'initial_amount', 'allocated_amount', 'status', 'start_date', 'end_date'
    ];

    public function fund()
    {
        return $this->belongsTo(Fund::class);
    }
}
