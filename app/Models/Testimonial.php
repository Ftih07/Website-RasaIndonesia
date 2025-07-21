<?php

namespace App\Models; // Defines the namespace of this model, following Laravel's MVC structure

use Illuminate\Database\Eloquent\Model; // Imports the base Eloquent Model class
use Illuminate\Support\Facades\Storage; // <- ini harus ada

class Testimonial extends Model
{
    // Specifies the attributes that are mass assignable
    protected $fillable = ['business_id', 'testimonial_user_id', 'user_id', 'name', 'description', 'rating', 'image_url', 'image_url_product', 'publishedAtDate', 'reply', 'replied_at', 'replied_by',];

    /**
     * Define a relationship where a testimonial belongs to a business.
     * This means that each testimonial is associated with a single business.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function business()
    {
        return $this->belongsTo(Business::class); // Defines a one-to-many inverse relationship
    }

    /**
     * Define a relationship where a testimonial belongs to a testimonial user.
     * This means that each testimonial is associated with a single user who gave the review.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function testimonial_user()
    {
        return $this->belongsTo(TestimonialUser::class, 'testimonial_user_id'); // Defines a one-to-many inverse relationship with a custom foreign key
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function replier()
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    public function likes()
    {
        return $this->hasMany(TestimonialLike::class);
    }

    public function getLikesCountAttribute()
    {
        return $this->likes()->count();
    }

    // app/Models/Testimonial.php
    public function getPhotoUrlAttribute()
    {
        if ($this->image_url) {
            return $this->image_url;
        }

        if ($this->testimonial_user && $this->testimonial_user->profile_picture) {
            return Storage::url($this->testimonial_user->profile_picture);
        }

        return asset('assets/images/testimonials/profile.png');
    }
}
