<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
protected $fillable = [
    'registration_no', 'batch_id', 'program_id', 'apply_date', 'first_name', 'last_name', 'father_name',
    'mother_name', 'father_occupation', 'country',
     'present_address', 
     'permanent_address', 'gender', 'dob', 'email', 'phone', 
   'nationality', 'national_id',
        'created_by', 'updated_by',

    // Add these:
    'county_id', 'sub_county_id', 'kcse_index_no', 'kcse_year', 'kcse_grade', 'kcse_certificate', 'kcse_result_slip', 'mode_of_study'
];



    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function presentProvince()
    {
        return $this->belongsTo(Province::class, 'present_province');
    }

    public function presentDistrict()
    {
        return $this->belongsTo(District::class, 'present_district');
    }

    public function permanentProvince()
    {
        return $this->belongsTo(Province::class, 'permanent_province');
    }

    public function permanentDistrict()
    {
        return $this->belongsTo(District::class, 'permanent_district');
    }

    public function county()
{
    return $this->belongsTo(County::class, 'county_id', 'CountyID');
}

public function subCounty()
{
    return $this->belongsTo(SubCounty::class, 'sub_county_id', 'SubCountyID');
}

}
