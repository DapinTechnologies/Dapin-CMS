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

    public function feeCategories()
    {
        return $this->hasManyThrough(
            FeesCategory::class,
            Fee::class,
            'student_enroll_id',
            'id',
            'student_enroll_id',
            'category_id'
        );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function items()
    {
        return $this->hasMany(Invoice::class);
    }

    protected $casts = [
        'fee_details' => 'array'
    ];

    public function updateStatus()
    {
        $totalFee = $this->total_fee;
        $totalPaid = $this->payments()->sum('amount'); // Changed from feePayments() to payments()
        
        if ($totalPaid >= $totalFee) {
            $status = 'paid';
        } elseif ($totalPaid > 0) {
            $status = 'partial';
        } else {
            $status = 'unpaid';
        }
        
        $this->update([
            'payment_status' => $status,
            'amount_due' => $totalFee - $totalPaid,
        ]);
    }

public function feePayments()
{
    return $this->hasManyThrough(
        FeePayment::class,
        Payment::class,
        'invoice_id', // Foreign key on Payment table
        'payment_id', // Foreign key on FeePayment table
        'id', // Local key on Invoice table
        'id' // Local key on Payment table
    )->with('fee.category');
}

    
    
}