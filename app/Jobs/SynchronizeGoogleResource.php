<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

abstract class SynchronizeGoogleResource
{
    public function handle()
    {
        $pageToken = null;

        $service = $this->getGoogleService();

        do {
            $list = $this->getGoogleRequest($service, compact('pageToken'));

            foreach ($list->getItems() as $item) {
                $this->syncItem($item);
            }

            // Get the new page token from the response.
            $pageToken = $list->getNextPageToken();

            // Continue until the new page token is null.
        } while ($pageToken);
    }

    abstract public function getGoogleService();
    abstract public function getGoogleRequest($service, $options);
    abstract public function syncItem($item);
}
