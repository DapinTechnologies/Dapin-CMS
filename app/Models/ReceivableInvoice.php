<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceivableInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'payer_type',
        'payer_id',
        'payer_name',
        'payer_email',
        'payer_phone',
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
     * Get the student payer
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'payer_id');
    }

    /**
     * Get the staff payer
     */
    public function staff()
    {
        return $this->belongsTo(User::class, 'payer_id');
    }

    /**
     * Get the creator
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the updater
     */
    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Get the receivable associated with the invoice
     */
    public function receivable()
    {
        return $this->hasOne(Income::class, 'receivable_invoice_id');
    }

    /**
     * Get payer details based on type
     */
    public function getPayerDetailsAttribute()
    {
        if ($this->payer_type === 'student' && $this->student) {
            return [
                'name' => $this->student->first_name . ' ' . $this->student->last_name,
                'email' => $this->student->email,
                'phone' => $this->student->phone,
                'id' => $this->student->student_id
            ];
        } elseif ($this->payer_type === 'staff' && $this->staff) {
            return [
                'name' => $this->staff->first_name . ' ' . $this->staff->last_name,
                'email' => $this->staff->email,
                'phone' => $this->staff->phone,
                'id' => $this->staff->staff_id
            ];
        } else {
            return [
                'name' => $this->payer_name,
                'email' => $this->payer_email,
                'phone' => $this->payer_phone,
                'id' => 'N/A'
            ];
        }
    }

    /**
     * Generate a unique invoice number
     */
    public static function generateInvoiceNo()
    {
        $prefix = 'INV-';
        $date = date('Ymd');
        $lastInvoice = self::where('invoice_no', 'like', $prefix . $date . '%')->latest()->first();
        
        $sequence = 1;
        if ($lastInvoice) {
            $sequence = intval(substr($lastInvoice->invoice_no, -4)) + 1;
        }
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Scope a query to only include active invoices.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}