<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
    use HasFactory;

    protected $fillable = ['student_enroll_id', 'subject_id', 'registration_date'];
    
    public function studentEnroll()
    {
        return $this->belongsTo(StudentEnroll::class);
    }
    
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}