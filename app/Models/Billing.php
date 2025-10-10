<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'billing_no',
        'supplier_id',
        'title',
        'amount',
        'date',
        'due_date',
        'description',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'date' => 'date',
        'due_date' => 'date',
        'status' => 'boolean'
    ];

    /**
     * Get the supplier that owns the billing.
     */
    public function supplier()
    {
        return $this->belongsTo(ItemSupplier::class, 'supplier_id');
    }

    /**
     * Get the creator of the billing.
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the updater of the billing.
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the payable associated with the billing.
     */
    public function payable()
    {
        return $this->hasOne(Expense::class, 'billing_id');
    }

    /**
     * Generate a unique billing number
     */
    public static function generateBillingNo()
    {
        $prefix = 'BL-';
        $date = date('Ymd');
        $lastBilling = self::where('billing_no', 'like', $prefix . $date . '%')->latest()->first();
        
        $sequence = 1;
        if ($lastBilling) {
            $sequence = intval(substr($lastBilling->billing_no, -4)) + 1;
        }
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scope a query to only include active billings.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}