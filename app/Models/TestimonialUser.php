<?php

namespace App\Models; // Defines the namespace of this model, following Laravel's MVC structure

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract; // Imports the contract for authentication
use Illuminate\Auth\Authenticatable; // Implements authentication features
use Illuminate\Database\Eloquent\Model; // Imports the base Eloquent Model class

class TestimonialUser extends Model implements AuthenticatableContract
{
    use Authenticatable; // Enables authentication features such as login and authentication management

    // Specifies the attributes that are mass assignable
    protected $fillable = ['username', 'password', 'profile_picture'];

    // Hides sensitive attributes from being exposed, such as in API responses
    protected $hidden = ['password'];

    /**
     * Define a relationship where a TestimonialUser has many testimonials.
     * This means that each user can create multiple testimonials.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function testimonials()
    {
        return $this->hasMany(Testimonial::class, 'testimonial_user_id'); // Defines a one-to-many relationship
    }
}
