<?php

namespace App\Jobs;

use App\Models\Synchronization;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RefreshWebhookSynchronizations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Synchronization::query()
            ->whereNotNull('resource_id')
            ->whereNull('expired_at')
            ->orWhere('expired_at', '<', now()->addDays(2))
            ->get()
            ->each->refreshWebhook();
    }
}
