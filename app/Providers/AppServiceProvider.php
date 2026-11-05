<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
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
        if (config('app.env') === 'production' || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')) {
            URL::forceScheme('https');
        }

        // Rate limiters for anti-DDoS & anti-brute-force protection
        RateLimiter::for('public', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });

        RateLimiter::for('login-page', function (Request $request) {
            return Limit::perMinute(15)->by($request->ip());
        });

        RateLimiter::for('login-submit', function (Request $request) {
            $identifier = strtolower(trim((string) $request->input('email', '')));

            return [
                Limit::perMinute(5)->by('login-ip:' . $request->ip()),
                Limit::perMinute(5)->by('login-id:' . ($identifier ?: $request->ip())),
            ];
        });

        RateLimiter::for('admin', function (Request $request) {
            return Limit::perMinute(60)->by($request->ip());
        });
    }
}
