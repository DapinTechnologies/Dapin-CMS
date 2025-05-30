<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'year', 'status',
    ];

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_semester', 'semester_id', 'program_id');
    }

    public function programSections()
    {
        return $this->hasMany(ProgramSemesterSection::class, 'semester_id', 'id');
    }

    public function studentEnrolls()
    {
        return $this->hasMany(StudentEnroll::class, 'semester_id');
    }

    public function classes()
    {
        return $this->hasMany(ClassRoutine::class, 'semester_id', 'id');
    }

    public function contents()
    {
        return $this->hasMany(Content::class, 'semester_id', 'id');
    }

    public function scopeWithPrograms($query, $programId)
    {
        return $query->where('program_id', $programId);  // Replace 'program_id' with the correct column in your semesters table
    }

    // Active scope (if necessary)
    public function scopeActive($query)
    {
        return $query->where('status', '1');  // Assuming 'status' indicates whether the semester is active
    }


    public function program()
    {
        return $this->belongsTo(Program::class);  // Adjust this as per your actual relationship
    }
  
}
