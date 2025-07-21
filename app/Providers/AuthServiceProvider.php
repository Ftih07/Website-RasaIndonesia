<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Testimonial;
use App\Policies\TestimonialPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Testimonial::class => TestimonialPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Ini penting agar policy dikenali
        $this->registerPolicies();

        // Kalau mau define gate manual bisa di sini juga (opsional)
        // Gate::define('delete-testimonial', [TestimonialPolicy::class, 'delete']);
    }
}
