<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    //
    protected $fillable = [
        'type_id',
        'food_category_id',
        'name',
        'description',
        'logo',
        'address',
        'open_hours',
        'services',
        'media_social',
        'location',
        'contact',
    ];

    protected $casts = [
        'open_hours' => 'array',
        'services' => 'array',
        'media_social' => 'array',
        'contact' => 'array',
    ];

    public function galleries()
    {
        return $this->hasMany(GalleryBusiness::class);
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    public function food_categories()
    {
        return $this->belongsToMany(FoodCategory::class, 'business_food_category', 'business_id', 'food_category_id');
    }
    

    // Di dalam model Business
    public function getAverageRatingAttribute()
    {
        return $this->testimonials->avg('rating') ?? 0; // Mengambil rata-rata dari testimonial rating
    }
}
