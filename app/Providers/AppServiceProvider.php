<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\RateLimiter;

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
        // Définit la limite pour les routes API
        RateLimiter::for('api', function(Request $request){
            return Limit::perMinute(50)->by(
                // Authentifié → limite par user ID
                // Non authentifié → limite par IP
                $request->user()?->id ?: $request->ip()

            );
        });
    }
}
