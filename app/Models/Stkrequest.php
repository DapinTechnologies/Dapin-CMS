<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stkrequest extends Model
{
    use HasFactory;
    
    protected $guarded = [];
     protected $fillable = [
        'MerchantRequestID',
        'CheckoutRequestID',
        'ResultCode',
        'ResultDesc', 
        'Amount',
        'AccountReference',
        'TransactionDesc',
        'status',
        'MpesaReceiptNumber',
        'TransactionDate',
        'phone_number',
        'phone',
        'student_id',
        'Date_payment',
        'fee_id',
        'reference',
        'description',
        'assign_date',
        'due_date',
        'pay_date',
        'fee_amount',
        'fee_category',
        'balance',
        'payment_amount',
        'student_id',
        'fee_id',
        'fee_category',
        'payment_amount',
        'Date_payment',

    ];
}
