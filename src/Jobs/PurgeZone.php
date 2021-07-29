<?php

namespace HandmadeWeb\StatamicCloudflare\Jobs;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PurgeZone implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $zone;
    protected $urls;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $zone, array $urls)
    {
        $this->zone = $zone;
        $this->urls = $urls;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Cloudflare::Api()->Zones()->cachePurge($this->zone, $this->urls);
    }
}
