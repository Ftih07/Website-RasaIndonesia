<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

class TestimonialUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    protected $fillable = ['username', 'password', 'profile_picture'];

    protected $hidden = ['password'];

    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'testimonial_user_id');
    }
}
