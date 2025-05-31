<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_no',
        'assign_date',
        'due_date',
        'student_enroll_id',
        'total_fee',
        'amount_due',
        'amount_paid',
        'payment_status',
    ];

    // Relationship to StudentEnroll (assuming student enroll table is 'student_enrolls')
    public function studentEnroll()
    {
        return $this->belongsTo(StudentEnroll::class, 'student_enroll_id');
    }

    // Optional: convenience method to get student name (if loaded)
    public function getStudentNameAttribute()
    {
        return $this->studentEnroll && $this->studentEnroll->student
            ? $this->studentEnroll->student->first_name . ' ' . $this->studentEnroll->student->last_name
            : null;
    }

    public function fees()
{
   
    return $this->hasMany(\App\Models\Fee::class, 'student_enroll_id', 'student_enroll_id');
}

}
