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
        View::composer('*', function ($view) {

            if (auth()->check()) {

                $notifications = auth()->user()
                    ->notifications()
                    ->take(5)
                    ->get();

                $unreadNotifications = auth()->user()
                    ->notifications()
                    ->where('read', false)
                    ->count();

                $view->with(
                    'notifications',
                    $notifications
                );

                $view->with(
                    'unreadNotifications',
                    $unreadNotifications
                );
            }

        });
    }
}
