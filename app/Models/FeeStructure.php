<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id', 
        'program_id', 
        'semester', 
        
        'is_active',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function items()
    {
        return $this->hasMany(FeeStructureItem::class);
    }
    public function createdBy()
{
    return $this->belongsTo(User::class, 'created_by');
}
}