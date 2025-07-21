<?php

namespace App\Policies;

use App\Models\Testimonial;
use App\Models\User;

class TestimonialPolicy
{
    public function delete(User $user, Testimonial $testimonial)
    {
        // Hanya user yang membuat testimonial boleh hapus
        return $user->id === $testimonial->user_id;
    }

    public function update(User $user, Testimonial $testimonial)
    {
        return $user->id === $testimonial->user_id;
    }
}
