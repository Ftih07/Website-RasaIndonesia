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
        'iframe_url',
        'open_hours',
        'services',
        'menu',
        'media_social',
        'location',
        'contact',
        'latitude',
        'longitude',
    ];

    protected $casts = [
        'open_hours' => 'array',
        'services' => 'array',
        'media_social' => 'array',
        'contact' => 'array',
    ];

    public function galleries()
    {
        return $this->hasMany(GalleryBusiness::class, 'business_id');
    }

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'business_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
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
