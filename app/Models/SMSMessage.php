<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SMSMessage extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function recipients() 
    { 
        return $this->hasMany(BulkSmsRecipient::class, 'sms_message_id');
     } 
     
     public function student() { 
        
        return $this->belongsTo(Student::class, 'phone_number', 'phone');
    
    }


}
