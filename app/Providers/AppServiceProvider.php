<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        // Force HTTPS in production
        if (config('app.url') == 'https://link-to-your-app.vercel.app') {
            \URL::forceScheme('https');
        }
        
        View::composer('*', function ($view) {
            // Panggil helper untuk setiap view
            $view->with('navigation_links', array_to_object(navigation_links()));
        });
    }
}
