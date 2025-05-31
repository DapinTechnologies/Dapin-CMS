<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start_date', 'end_date', 'current', 'status',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_session', 'session_id', 'program_id');
    }

    public function studentEnrolls()
    {
        return $this->hasMany(StudentEnroll::class, 'session_id');
    }

    public function classes()
    {
        return $this->hasMany(ClassRoutine::class, 'session_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'session_id', 'id');
    }

    public function scopeActive($query)
    {
        return $query->where('status', '1');
    }
    


 

    // Custom scope to filter sessions by program
    public function scopeWithPrograms($query, $programId)
    {
        return $query->whereHas('programs', function ($query) use ($programId) {
            $query->where('program_id', $programId);  // Adjust 'program_id' to match the actual column in your table
        });
    }

    // Active scope (if necessary)
   






}
