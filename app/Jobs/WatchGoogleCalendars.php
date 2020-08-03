<?php


    namespace App\Jobs;


    use Illuminate\Bus\Queueable;
    use Illuminate\Contracts\Queue\ShouldQueue;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;

    class WatchGoogleCalendars extends WatchGoogleResource implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        public function getGoogleRequest($service, $channel)
        {
            return $service->calendarList->watch($channel);
        }
    }
