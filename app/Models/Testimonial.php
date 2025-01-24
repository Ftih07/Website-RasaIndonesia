<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    //
    protected $fillable = ['business_id', 'testimonial_user_id', 'name', 'description', 'rating'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function testimonial_user()
    {
        return $this->belongsTo(TestimonialUser::class, 'testimonial_user_id');
    }
    
}