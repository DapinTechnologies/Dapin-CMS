<?php

// SubCounty Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model
{
    protected $primaryKey = 'SubCountyID';
    protected $fillable = ['SubCountyName', 'CountyID'];
}