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
        'discount_amount', // Added for discount tracking
        'fine_amount',     // Added for fine tracking
        'bursary_allocated', // Added for bursary tracking
        'adjustment_type', // Added for adjustment tracking
        'adjustment_id',   // Added for adjustment tracking
        'adjustment_notes' // Added for adjustment notes
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

    // Relationship to Fees (corrected version)
    public function fees()
    {
        return $this->hasMany(Fee::class, 'invoice_id'); // Changed to use invoice_id as foreign key
    }

    // Relationship to FeeCategories through Fees
    public function feeCategories()
    {
        return $this->hasManyThrough(
            FeesCategory::class,
            Fee::class,
            'invoice_id',  // Foreign key on Fee table
            'id',         // Foreign key on FeesCategory table
            'id',        // Local key on Invoice table
            'category_id' // Local key on Fee table
        );
    }

    // Relationship to Payments
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relationship to FeePayments through Payments
    public function feePayments()
    {
        return $this->hasManyThrough(
            FeePayment::class,
            Payment::class,
            'invoice_id', // Foreign key on Payment table
            'payment_id', // Foreign key on FeePayment table
            'id',        // Local key on Invoice table
            'id'         // Local key on Payment table
        );
    }

    // Relationship to applied discount (if using single discount per invoice)
    public function discount()
    {
        return $this->belongsTo(FeesDiscount::class, 'adjustment_id')
            ->where('adjustment_type', 'discount');
    }

    // Relationship to applied fine (if using single fine per invoice)
    public function fine()
    {
        return $this->belongsTo(FeesFine::class, 'adjustment_id')
            ->where('adjustment_type', 'fine');
    }

    protected $casts = [
        'fee_details' => 'array'
    ];

    // Enhanced status update method
    public function updateStatus()
    {
        $totalAmount = $this->total_fee + $this->fine_amount;
        $totalPaid = $this->payments()->sum('amount');
        $totalDiscount = $this->discount_amount;
        $totalBursary = $this->bursary_allocated;

        $amountDue = max(0, $totalAmount - $totalPaid - $totalDiscount - $totalBursary);

        if ($amountDue <= 0) {
            $status = 'paid';
        } elseif ($totalPaid > 0 || $totalBursary > 0) {
            $status = 'partial';
        } else {
            $status = 'unpaid';
        }

        $this->update([
            'payment_status' => $status,
            'amount_due' => $amountDue,
            'amount_paid' => $totalPaid,
        ]);
    }

    // Get category dues with all adjustments
    public function getCategoryDues()
    {
        return $this->fees()
            ->with(['category', 'feePayments'])
            ->get()
            ->groupBy('category_id')
            ->map(function ($fees, $categoryId) {
                $category = $fees->first()->category;
                $totalAmount = $fees->sum('amount');
                $totalPaid = $fees->sum(function ($fee) {
                    return $fee->feePayments->sum('amount');
                });
                $totalDiscount = $fees->sum('discount_amount');
                $totalBursary = $fees->sum('bursary_allocated');

                $dueAmount = max(0, $totalAmount - $totalPaid - $totalDiscount - $totalBursary);

                return [
                    'title' => $category->title,
                    'total_amount' => $totalAmount,
                    'paid_amount' => $totalPaid,
                    'discount_amount' => $totalDiscount,
                    'bursary_allocated' => $totalBursary,
                    'due_amount' => $dueAmount
                ];
            });
    }

    // Relationship to FeeStructure
    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class, 'fee_structure_id');
    }

    // Calculate net amount due considering all adjustments
    public function getNetAmountDueAttribute()
    {
        return max(0, 
            ($this->total_fee + $this->fine_amount) - 
            ($this->amount_paid + $this->discount_amount + $this->bursary_allocated)
        );
    }

    // Apply discount to invoice (helper method)
    public function applyDiscount($amount, $discountId = null, $notes = null)
    {
        $this->discount_amount += $amount;
        $this->adjustment_type = 'discount';
        $this->adjustment_id = $discountId;
        $this->adjustment_notes = $notes ?? "Discount applied: KSH " . number_format($amount, 2);
        $this->save();
        
        $this->updateStatus();
    }

    // Apply fine to invoice (helper method)
    public function applyFine($amount, $fineId = null, $notes = null)
    {
        $this->fine_amount += $amount;
        $this->adjustment_type = 'fine';
        $this->adjustment_id = $fineId;
        $this->adjustment_notes = $notes ?? "Fine applied: KSH " . number_format($amount, 2);
        $this->save();
        
        $this->updateStatus();
    }
}