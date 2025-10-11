<?php

namespace App\Models\Web;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutUsHistory extends Model
{
    use HasFactory;

    protected $table = 'about_us_histories';

    protected $fillable = [
        'about_us_id',
        'year',
        'title',
        'description',
        'image',
        'order'
    ];

    /**
     * Get the about us that owns the history item.
     */
public function aboutUs()
{
    return $this->belongsTo(AboutUs::class);
}
    /**
     * Get the image URL.
     */
 public function getImageUrlAttribute()
{
    if ($this->image) {
        return asset('uploads/about-us/history/'.$this->image);
    }
    return null;
}
    
}