<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsAccreditation extends Model
{
    use HasFactory;

    protected $table = 'about_us_accreditations';

    protected $fillable = [
        'about_us_id',
        'name',
        'logo',
        'description',
        'order'
    ];

    /**
     * Get the about us that owns the accreditation.
     */
    public function aboutUs()
    {
        return $this->belongsTo(\App\Models\web\AboutUs::class);
    }

    /**
     * Get the logo URL.
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('uploads/about-us/accreditations/' . $this->logo);
        }
        return null;
    }
}