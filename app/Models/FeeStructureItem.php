<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructureItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_structure_id',
        'fees_category_id',
        'fee_category_title',
        'fee_category_slug',
        'fee_category_description',
        'amount',
        'is_one_time'
    ];

    public function feeStructure()
    {
        return $this->belongsTo(FeeStructure::class);
    }

    public function category()
    {
        return $this->belongsTo(FeesCategory::class, 'fees_category_id');
    }

    // Accessors for fallback to category data
    public function getFeeCategoryTitleAttribute($value)
    {
        return $value ?? $this->category?->title ?? 'N/A';
    }

    public function getFeeCategorySlugAttribute($value)
    {
        return $value ?? $this->category?->slug ?? 'N/A';
    }

    public function getFeeCategoryDescriptionAttribute($value)
    {
        return $value ?? $this->category?->description ?? 'N/A';
    }
}