<?php
// app/Models/Reconciliation.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reconciliation extends Model
{
    use HasFactory;

    protected $fillable = [
        'reconciliation_no',
        'reconciliation_date',
        'type',
        'transaction_id',
        'transaction_type',
        'amount',
        'currency',
        'status',
        'notes',
        'reference_number',
        'value_date',
        'bank_reference',
        'bank_amount',
        'difference',
        'discrepancy_reason',
        'is_auto_matched',
        'reconciled_by',
        'reconciled_at',
        'created_by'
    ];

    protected $casts = [
        'reconciliation_date' => 'date',
        'value_date' => 'date',
        'reconciled_at' => 'datetime',
        'amount' => 'decimal:2',
        'bank_amount' => 'decimal:2',
        'difference' => 'decimal:2',
        'is_auto_matched' => 'boolean',
    ];

    // Relationships
    public function transaction(): MorphTo
    {
        return $this->morphTo();
    }

    public function reconciledBy()
    {
        return $this->belongsTo(User::class, 'reconciled_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeReconciled($query)
    {
        return $query->where('status', 'reconciled');
    }

    public function scopeDiscrepancy($query)
    {
        return $query->where('status', 'discrepancy');
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('reconciliation_date', [$startDate, $endDate]);
    }

    // Methods
    public function calculateDifference()
    {
        $this->difference = $this->bank_amount - $this->amount;
        return $this->difference;
    }

    public function autoMatch()
    {
        if (abs($this->amount - $this->bank_amount) <= 1.00) { // Allow 1 KES difference
            $this->status = 'reconciled';
            $this->is_auto_matched = true;
            $this->reconciled_at = now();
            $this->save();
            return true;
        }
        return false;
    }

    public function markAsReconciled($userId, $notes = null)
    {
        $this->status = 'reconciled';
        $this->reconciled_by = $userId;
        $this->reconciled_at = now();
        $this->notes = $notes;
        $this->save();
    }

    public function markAsDiscrepancy($reason)
    {
        $this->status = 'discrepancy';
        $this->discrepancy_reason = $reason;
        $this->save();
    }

    // Generate Kenyan standard reconciliation number
    public static function generateReconciliationNo()
    {
        $prefix = 'RECON';
        $date = now()->format('ymd');
        $last = self::where('reconciliation_no', 'like', $prefix . $date . '%')->latest()->first();
        
        $sequence = $last ? intval(substr($last->reconciliation_no, -4)) + 1 : 1;
        
        return $prefix . $date . str_pad($sequence, 4, '0', STR_PAD_LEFT);
    }
}