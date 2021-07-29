<?php

namespace HandmadeWeb\StatamicCloudflare\Commands;

use Exception;
use HandmadeWeb\StatamicCloudflare\Cloudflare;
use Illuminate\Console\Command;
use Statamic\Console\RunsInPlease;

class CachePurgeEverything extends Command
{
    use RunsInPlease;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cloudflare:cache:purge:everything';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $description = 'Purge everything from CloudFlare.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (Cloudflare::zones()->isEmpty()) {
            return $this->error('Please supply a valid zone in the statamic-cloudflare config.');
        }

        Cloudflare::zones()->each(function ($zone) {
            try {
                Cloudflare::Api()->Zones()->cachePurgeEverything($zone);

                $this->info('Successfully purged everything from: '.Cloudflare::zones()->flip()->get($zone));
            } catch (Exception $exception) {
                $this->error('Failed to purge: '.Cloudflare::zones()->flip()->get($zone));
            }
        });
    }
}
