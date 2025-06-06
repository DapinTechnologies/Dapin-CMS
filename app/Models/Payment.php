<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    const STATUS_PENDING = 'pending';
    const STATUS_PARTIAL = 'partial';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';

    protected $fillable = [
        'invoice_id',
        'student_enroll_id',
        'amount',
        'payment_method',
        'reference_number',
        'status',
        'transaction_id',
        'paid_at',
        'is_installment',
        'installment_number',
        'notes'
    ];

    protected $dates = ['paid_at'];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function studentEnroll()
    {
        return $this->belongsTo(StudentEnroll::class);
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }

    // app/Models/Payment.php
public function processedBy()
{
    return $this->belongsTo(User::class, 'processed_by'); // Assuming 'processed_by' is the foreign key
}

public function student()
{
    return $this->belongsTo(\App\Models\StudentEnroll::class, 'student_enroll_id');
}


}