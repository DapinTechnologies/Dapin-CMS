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
        'excess_payment',
        'payment_method',
        'reference_number',
        'payment_date',
        'status',
        'transaction_id',
        'paid_at',
        'is_installment',
        'installment_number',
        'notes',
        'is_reconciled',
        'reconciled_at',
        'reconciled_by',
        'reconciliation_notes',
        'confirmed_by',
        'confirmation_date',
        'is_discount',
        'is_fine',
        'discount_id',
        'fine_id',
        'is_bursary',
        'bursary_type',
        'bursary_notes',
        'bursary_allocated_by',
        'bursary_allocated_at'
    ];

    protected $dates = [
        'paid_at',
        'payment_date',
        'reconciled_at',
        'bursary_allocated_at',
        'confirmation_date'
    ];

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

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function student()
    {
        return $this->belongsTo(\App\Models\StudentEnroll::class, 'student_enroll_id');
    }

    public function bursaryType()
    {
        return $this->belongsTo(BursaryType::class, 'bursary_type', 'code');
    }

    public function allocatedBy()
    {
        return $this->belongsTo(User::class, 'bursary_allocated_by');
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->paid_at)) {
                $model->paid_at = now();
            }
        });
    }
}