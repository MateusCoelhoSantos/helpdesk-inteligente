<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Notification;
use Illuminate\Support\Facades\View;


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
        Paginator::useBootstrap();
        
        View::composer('*', function ($view) {

            if (auth()->check()) {

                $navbarNotifications = auth()->user()
                    ->notifications()
                    ->take(5)
                    ->get();

                $unreadNotifications = auth()->user()
                    ->notifications()
                    ->where('read', false)
                    ->count();

                $view->with(
                    'navbarNotifications',
                    $navbarNotifications
                );

                $view->with(
                    'unreadNotifications',
                    $unreadNotifications
                );
            }

        });
    }
}
