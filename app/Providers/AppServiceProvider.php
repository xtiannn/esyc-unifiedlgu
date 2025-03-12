<?php

namespace App\Providers;
use App\Models\Announcement;
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
    public function boot()
    {
        View::composer('partials.navBar', function ($view) {
            $announcement = Announcement::latest('published_at')->first();
            $view->with('announcement', $announcement);
        });

        View::composer('*', function ($view) {
            $view->with('announcements', Announcement::latest()->limit(5)->get());
        });
    }
}
