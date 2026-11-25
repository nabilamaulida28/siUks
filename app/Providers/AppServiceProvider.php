<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        // Vercel berada di balik HTTPS; paksa semua URL (form, redirect, asset) memakai https.
        if ($this->app->environment("production")) {
            URL::forceScheme("https");
        }
    }
}
