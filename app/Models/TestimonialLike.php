<?php

// app/Models/TestimonialLike.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimonialLike extends Model
{
    protected $fillable = ['testimonial_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function testimonial()
    {
        return $this->belongsTo(Testimonial::class);
    }
}
