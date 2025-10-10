<?php
// app/Models/PayrollPayment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'payroll_entry_id',
        'amount',
        'payment_method',
        'reference',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date'
    ];

    /**
     * Payroll entry relationship
     */
    public function payrollEntry()
    {
        return $this->belongsTo(PayrollEntry::class);
    }

    /**
     * Scope by payment method
     */
    public function scopePaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    /**
     * Scope by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }

    /**
     * Get payment method label
     */
    public function getPaymentMethodLabelAttribute()
    {
        $methods = [
            'bank' => 'Bank Transfer',
            'cash' => 'Cash',
            'mpesa' => 'M-Pesa'
        ];

        return $methods[$this->payment_method] ?? $this->payment_method;
    }

    /**
     * Check if payment is full payment
     */
    public function getIsFullPaymentAttribute()
    {
        return $this->amount >= $this->payrollEntry->net_pay;
    }

    /**
     * Check if payment is partial payment
     */
    public function getIsPartialPaymentAttribute()
    {
        return $this->amount < $this->payrollEntry->net_pay;
    }
}