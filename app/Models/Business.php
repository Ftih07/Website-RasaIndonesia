<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
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
        'unique_code',
        'document',
        'order',
        'reserve',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'open_hours' => 'array',
        'services' => 'array',
        'media_social' => 'array',
        'contact' => 'array',
    ];

    /**
     * Get the galleries associated with the business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function galleries()
    {
        return $this->hasMany(GalleryBusiness::class, 'business_id');
    }

    /**
     * Get the testimonials associated with the business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'business_id');
    }

    /**
     * Get the products associated with the business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the type of the business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->belongsTo(Type::class, 'type_id');
    }

    /**
     * Get the food categories associated with the business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function food_categories()
    {
        return $this->belongsToMany(FoodCategory::class, 'business_food_category', 'business_id', 'food_category_id');
    }

    /**
     * Get the average rating of the business based on testimonials.
     *
     * @return float
     */
    public function getAverageRatingAttribute()
    {
        return $this->testimonials->avg('rating') ?? 0; // Calculates the average rating from testimonials
    }
}
