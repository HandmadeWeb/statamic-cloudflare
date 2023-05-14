<?php

namespace HandmadeWeb\StatamicCloudflare\Jobs;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurgeEverythingForAllZones implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cloudflare::zones()->each(function ($zone) {
            Cloudflare::Api()->Zones()->cachePurgeEverything($zone);
        });
    }
}
