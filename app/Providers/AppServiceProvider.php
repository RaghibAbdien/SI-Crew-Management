<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use App\Models\Notification;
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
        View::composer('includes.header', function ($view) {
            $notifs = Notification::join('crews', 'notifications.id_crew', '=', 'crews.id_crew')
            ->where('is_notif', true)
            ->select('notifications.*', 'crews.nama_crew')
            ->get();
            $NotifNotReadNum = Notification::where('is_read', false)->count();
            $view->with([
                'notifs' => $notifs,
                'NotifNotReadNum' => $NotifNotReadNum,
            ]);
        });

        View::composer('layout.main', function ($view){
            $notifs = Notification::join('crews', 'notifications.id_crew', '=', 'crews.id_crew')
            ->where('is_notif', true)
            ->select('notifications.*', 'crews.nama_crew')
            ->get();
            $view->with('notifs', $notifs);
        });
    }
}
