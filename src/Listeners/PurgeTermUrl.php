<?php

namespace HandmadeWeb\StatamicCloudflare\Listeners;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use HandmadeWeb\StatamicCloudflare\Jobs\PurgeZoneUrls;
use Statamic\Events\TermDeleted;
use Statamic\Events\TermSaved;
use Statamic\Modifiers\Modify;

class PurgeTermUrl
{
    public function handle($event)
    {
        /*
         * The term is not being saved or deleted? Skip.
         */
        if (! $event instanceof TermSaved || ! $event instanceof TermDeleted) {
            return;
        }

        $site = $event->term->site();

        // Strip http(s):// and www. from site url.
        $domain = Modify::value($site->absoluteUrl())
            ->removeLeft('http://')
            ->removeLeft('https://')
            ->removeLeft('www.')
            ->__toString();

        $zone = Cloudflare::zones()->get($domain);

        // Domain wasn't found in zones, try with www.
        if (! $zone) {
            $zone = Cloudflare::zones()->get("www.{$domain}");
        }

        // If zone exists, try to purge the url from it.
        if ($zone) {
            $url = $event->term->url();

            if (Cloudflare::shouldQueue()) {
                PurgeZoneUrls::dispatch($zone, [$url]);
            } else {
                PurgeZoneUrls::dispatchSync($zone, [$url]);
            }
        }
    }
}
