<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDeductionPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'deduction_setting_id',
        'is_selected'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function deductionSetting()
    {
        return $this->belongsTo(DeductionSetting::class);
    }
}