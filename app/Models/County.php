<?php
// County Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $primaryKey = 'CountyID';
    protected $fillable = ['CountyName', 'Capital', 'CountyCode'];
}

// SubCounty Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubCounty extends Model
{
    protected $primaryKey = 'SubCountyID';
    protected $fillable = ['SubCountyName', 'CountyID'];
}