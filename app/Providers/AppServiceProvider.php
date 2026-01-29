<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Cashier\Cashier;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        // Set default string length for PostgreSQL
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        
        // Register payment gateway if needed
        if (config('services.stripe.key')) {
            \Stripe\Stripe::setApiKey(config('services.stripe.secret'));
        }
    }
}