<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Brand;

class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }
    public function reviews()
{
    return $this->hasMany(Review::class)->where('is_approved', true);
}

public function allReviews()
{
    return $this->hasMany(Review::class);
}

public function avgRating()
{
    return $this->reviews()->avg('rating') ?? 0;
}

}
