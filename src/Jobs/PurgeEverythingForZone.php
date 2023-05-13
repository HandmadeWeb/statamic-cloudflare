<?php

namespace HandmadeWeb\StatamicCloudflare\Jobs;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurgeEverythingForZone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $zone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $zone)
    {
        $this->zone = $zone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cloudflare::Api()->Zones()->cachePurgeEverything($this->zone);
    }
}
