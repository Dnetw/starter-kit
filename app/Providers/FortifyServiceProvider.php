<?php

namespace App\Providers;

use Dnetw\Core\Support\FortifyDefaults;
use Illuminate\Support\ServiceProvider;

class FortifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Where Fortify redirects after successful login / registration /
        // password reset / email verification. Default is /home which most
        // dnetw apps don't have — dashboard is the universal landing.
        config(['fortify.home' => '/dashboard']);
    }

    public function boot(): void
    {
        FortifyDefaults::bindViews();
        FortifyDefaults::configureRateLimiting();
    }
}
