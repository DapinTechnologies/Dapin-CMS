<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'bank_name',
        'account_name',
        'account_number',
        'branch',
        'status',
        'description'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];


    /**
     * Get the bank account's status as a string.
     *
     * @return string
     */
    public function getStatusAttribute($value)
    {
        return $value ? 'Active' : 'Inactive';
    }

    /**
     * Set the bank account's status.
     *
     * @param  bool  $value
     * @return void
     */
    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = (bool) $value;
    }
    }
