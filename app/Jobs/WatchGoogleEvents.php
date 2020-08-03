<?php


    namespace App\Jobs;


    use Illuminate\Bus\Queueable;
    use Illuminate\Foundation\Bus\Dispatchable;
    use Illuminate\Queue\InteractsWithQueue;
    use Illuminate\Queue\SerializesModels;

    class WatchGoogleEvents extends WatchGoogleResource implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        public function getGoogleRequest($service, $channel)
        {
            return $service->events->watch(
                $this->synchronizable->google_id, $channel
            );
        }
    }
