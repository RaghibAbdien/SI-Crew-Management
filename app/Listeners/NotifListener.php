<?php

namespace App\Listeners;

use App\Events\NotifEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NotifListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NotifEvent $event)
    {
        Log::info('Handling Notif event for : ' . $event->notif->id_crew);

        try {
            $event->notif->update(['is_notif' => false]);
        } catch (\Exception $e) {
            Log::error('Error updating notification: ' . $e->getMessage());
        }
    }
}
