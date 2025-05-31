<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpesaTrascation extends Model
{
    use HasFactory;



    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feecategory()
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

















}
