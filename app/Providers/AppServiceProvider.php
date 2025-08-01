<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Business;
use App\Observers\BusinessObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Business::observe(BusinessObserver::class);
    }
}
