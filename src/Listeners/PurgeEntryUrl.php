<?php

namespace HandmadeWeb\StatamicCloudflare\Listeners;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use HandmadeWeb\StatamicCloudflare\Jobs\PurgeZone;
use Statamic\Events\EntryDeleted;
use Statamic\Events\EntrySaved;
use Statamic\Modifiers\Modify;

class PurgeEntryUrl
{
    public function handle($event)
    {
        /*
         * The entry is not being saved or deleted? Skip.
         */
        if (! $event instanceof EntrySaved || ! $event instanceof EntryDeleted) {
            return;
        }

        $site = $event->entry->site();

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
            $url = $event->entry->url();

            if (Cloudflare::shouldQueue()) {
                PurgeZone::dispatch($zone, [$url]);
            } else {
                PurgeZone::dispatchSync($zone, [$url]);
            }
        }
    }
}
