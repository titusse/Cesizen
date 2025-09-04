<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;

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
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
        // Gate::define('viewPulse', function (User $user) {
        //     return true;
        // });
    }
}
