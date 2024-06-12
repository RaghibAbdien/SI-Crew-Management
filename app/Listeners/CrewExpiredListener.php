<?php

namespace App\Listeners;

use App\Models\Notification;
use App\Events\CrewExpiredEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;


class CrewExpiredListener
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
    public function handle(CrewExpiredEvent $event)
    {
        Log::info('Handling CrewExpired event for crew: ' . $event->dokumen->id_crew);

        try {

            if($event->warningType === 'kontrak'){
                $jenis = 'kontrak';
                $title = 'Peringatan Kontrak Expired';
                $message = 'Kontrak Crew akan segera berakhir';
                $event->dokumen->update(['is_notif_kontrak' => true]);
                Log::info('Updated is_notif_kontrak to true for crew: ' . $event->dokumen->id_crew);
            } elseif($event->warningType === 'mcu'){
                $jenis = 'mcu';
                $title = 'Peringatan MCU Expired';
                $message = 'MCU Crew akan segera berakhir';
                $event->dokumen->update(['is_notif_mcu' => true]);
                Log::info('Updated is_notif_mcu to true for crew: ' . $event->dokumen->id_crew);

            }

            Notification::create([
                'id_crew' => $event->dokumen->id_crew,
                'jenis_notif' => $jenis,
                'title' => $title,
                'message' => $message,
            ]);
            Log::info('Notification created successfully for crew: ' . $event->dokumen->id_crew);
        } catch (\Exception $e) {
            Log::error('Error creating notification: ' . $e->getMessage());
        }
    }
}

