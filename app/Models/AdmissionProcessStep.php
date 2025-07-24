<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionProcessStep extends Model
{
    use HasFactory;
       protected $fillable = ['title', 'description', 'requirements'];

    protected $casts = [
        'requirements' => 'array', // Cast the requirements field to an array
    ];
}
