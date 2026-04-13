<?php

namespace App\Providers;

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
        // Dynamically override email sender based on Database Settings to prevent "test" or spam issues
        config([
            'mail.from.name' => \App\Models\Setting::get('app_name', config('app.name', 'HA Tech')),
            'mail.from.address' => \App\Models\Setting::get('contact_email', config('mail.from.address', 'hello@example.com'))
        ]);
    }
}
