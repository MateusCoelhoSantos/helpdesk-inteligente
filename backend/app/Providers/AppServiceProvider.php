<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Models\Notification;
use Illuminate\Support\Facades\View;
use App\Models\Ticket;
use App\Policies\TicketPolicy;
use Illuminate\Support\Facades\Gate;
use App\Services\AI\Contracts\AIProvider;
use App\Services\AI\Providers\RuleBasedAIProvider;
use InvalidArgumentException;
use App\Services\AI\Providers\OpenAIProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            AIProvider::class,
            function () {

                return match (
                    config('ai.provider')
                ) {

                    'rule-based' => app(
                        RuleBasedAIProvider::class
                    ),

                    'openai' => app(
                        OpenAIProvider::class
                    ),

                    default => throw new InvalidArgumentException(
                        'AI Provider not supported.'
                    ),
                };
            }
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrap();

        Gate::policy(
            Ticket::class,
            TicketPolicy::class
        );
        
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
