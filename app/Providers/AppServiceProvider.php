<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Notification;

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
            if (Auth::check()) {
                $notifications = Notification::where('user_id', Auth::id())
                    ->latest()
                    ->take(10)
                    ->get();

                $unreadNotificationsCount = Notification::where('user_id', Auth::id())
                    ->whereNull('read_at')
                    ->count();
            } else {
                $notifications = collect();
                $unreadNotificationsCount = 0;
            }

            $view->with([
                'notifications' => $notifications,
                'unreadNotificationsCount' => $unreadNotificationsCount,
            ]);
        });
    }
}
