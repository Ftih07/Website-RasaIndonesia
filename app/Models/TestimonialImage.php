<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialImage extends Model
{
    protected $fillable = ['testimonial_id', 'image_path'];

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class);
    }
}
