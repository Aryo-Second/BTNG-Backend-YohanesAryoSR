<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;

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
    // Membuka /docs/api untuk publik (wajib agar Scramble bisa diakses di cloud)
    Gate::define('viewApiDocs', function ($user = null) {
        return true;
    });

    if ($this->app->environment('production')) {
        URL::forceScheme('https');
    }
}
}
