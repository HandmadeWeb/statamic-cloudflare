<?php

namespace HandmadeWeb\StatamicCloudflare\Http\Controllers;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use HandmadeWeb\StatamicCloudflare\Jobs\PurgeEverythingForZone;
use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;

class CloudflareUtilityController extends CpController
{
    public function index(Request $request)
    {
        return view('statamic-cloudflare::utility');
    }

    public function purgeAll(Request $request)
    {
        Cloudflare::zones()->each(function ($zone) {
            if (Cloudflare::shouldQueue()) {
                PurgeEverythingForZone::dispatch($zone);
            } else {
                PurgeEverythingForZone::dispatchSync($zone);
            }
        });

        return back()->withSuccess(__('All caches cleared.'));
    }
}
