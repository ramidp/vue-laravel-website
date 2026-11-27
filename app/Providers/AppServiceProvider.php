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
        // When APP_URL is a public HTTPS address (e.g. a Cloudflare Tunnel URL),
        // generate every link and asset URL with it instead of 127.0.0.1.
        // With APP_URL=http://localhost nothing changes.
        if (str_starts_with((string) config('app.url'), 'https://')) {
            URL::forceRootUrl(config('app.url'));
            URL::forceScheme('https');
        }
    }
}
