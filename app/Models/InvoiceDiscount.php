<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDiscount extends Model
{
    protected $fillable = [
        'invoice_id',
        'discount_id',
        'amount',
        'notes'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function discount()
    {
        return $this->belongsTo(FeesDiscount::class);
    }
}