<?php

namespace App\Console;

use App\Models\Dokumen;
use App\Models\Notification;
use App\Events\CrewExpiredEvent;
use App\Events\NotifEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule)
{
    $schedule->call(function () {
        Log::info('Scheduler is running');

        try {
            $expiredKontrak = Dokumen::where('warn_kontrak', '<=', now())
                                    ->where('is_notif_kontrak', false)
                                    ->get();
            $expiredMCU = Dokumen::where('warn_mcu', '<=', now())
                                    ->where('is_notif_mcu', false)
                                    ->get();
            $notifDuration = Notification::where('duration', '<=', now())
                                            ->where('is_notif', true)
                                            ->get();                        
            if($expiredKontrak){
                foreach ($expiredKontrak as $dokumen) {
                    Log::info('Kontrak akan expired untuk : ' . $dokumen->id_crew);
                    event(new CrewExpiredEvent($dokumen, 'kontrak'));
                }
            }
            if ($expiredMCU) {
                foreach ($expiredMCU as $dokumen) {
                    Log::info('MCU akan expired untuk: ' . $dokumen->id_crew);
                    event(new CrewExpiredEvent($dokumen, 'mcu'));
                }
            }
            if($notifDuration){
                foreach ($notifDuration as $notif){
                    Log::info('Notifikasi akan diupdate dengan ID Crew : '. $notif->id_crew);
                    event(new NotifEvent($notif));
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in scheduler callback: ' . $e->getMessage());
        }
    })->everyMinute();

}

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
