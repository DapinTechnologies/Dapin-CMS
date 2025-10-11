<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoreValue extends Model
{
    use HasFactory;
      use HasFactory;

    protected $fillable = [
        'icon',           // Allow mass assignment of 'icon'
        'title',          // Allow mass assignment of 'title'
        'description',    // Allow mass assignment of 'description'
    ];
}
