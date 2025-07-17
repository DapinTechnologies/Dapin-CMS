<?php
// County Model
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $primaryKey = 'CountyID';
    protected $fillable = ['CountyName', 'Capital', 'CountyCode'];
}

