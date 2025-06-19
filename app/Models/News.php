<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;
     protected $fillable = [
        'language_id',
        'title',
        'slug',
        'date',
        'description',
        'meta_title',
        'meta_description',
        'attach',
        'status',
    ];
}
