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

    // Relationship to StudentEnroll
    public function studentEnroll()
    {
        return $this->belongsTo(StudentEnroll::class, 'student_enroll_id');
    }

    // Method to get student name (if loaded)
    public function getStudentNameAttribute()
    {
        return $this->studentEnroll && $this->studentEnroll->student
            ? $this->studentEnroll->student->first_name . ' ' . $this->studentEnroll->student->last_name
            : null;
    }

    // Relationship to Fees
    public function fees()
    {
        return $this->hasMany(Fee::class, 'student_enroll_id', 'student_enroll_id')
            ->where('assign_date', $this->assign_date)
            ->where('due_date', $this->due_date);
    }
    // In Invoice model
public function feeCategories()
{
    return $this->hasManyThrough(
        FeesCategory::class,
        Fee::class,
        'student_enroll_id', // Foreign key on Fee table
        'id', // Foreign key on FeesCategory table
        'student_enroll_id', // Local key on Invoice table
        'category_id' // Local key on Fee table
    );
}



public function payments()
{
    return $this->hasMany(Payment::class);
}
// Invoice model
// In your Invoice model
public function items()
{
    return $this->hasMany(Invoice::class);
}
// In your Invoice model
protected $casts = [
    'fee_details' => 'array' // If storing as JSON
];

// Then in your controller
}




