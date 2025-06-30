<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeesMaster extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'faculty_id', 'program_id', 'session_id', 'semester_id', 'section_id', 
        'amount', 'type', 'assign_date', 'due_date', 'status', 'created_by', 'updated_by',
    ];

    /**
     * Get all student enrollments for this fee master
     */
    public function studentEnrolls()
    {
        return $this->belongsToMany(StudentEnroll::class, 'fees_master_student_enroll', 'fees_master_id', 'student_enroll_id');
    }

    /**
     * Get the primary category (maintaining backward compatibility)
     */
    public function category()
    {
        return $this->belongsTo(FeesCategory::class, 'category_id');
    }

    /**
     * Get all associated fee categories (new multiple categories support)
     */
    public function feeCategories()
    {
        return $this->belongsToMany(
            FeesCategory::class,
            'fees_master_category',
            'fees_master_id',
            'fees_category_id'
        )->withTimestamps();
    }

    /**
     * Get the faculty
     */
    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }

    /**
     * Get the program
     */
    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    /**
     * Get the session
     */
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    /**
     * Get the semester
     */
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }

    /**
     * Get the section
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Helper method to get all category amounts sum
     */
    public function getTotalAmountAttribute()
    {
        return $this->feeCategories->sum('amount');
    }
}