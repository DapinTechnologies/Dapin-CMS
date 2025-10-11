<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $fillable = [
        'payment_id',
        'fee_id',
        'amount_applied',
        'amount'
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }

    
}

// In your PaymentController (or wherever you're showing the receipt)

// In your Blade view
