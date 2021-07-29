<?php

namespace HandmadeWeb\StatamicCloudflare\Http\Controllers;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use HandmadeWeb\StatamicCloudflare\Jobs\PurgeEverythingForZone;
use Illuminate\Http\Request;
use Statamic\Facades\Site;
use Statamic\Http\Controllers\CP\CpController;
use Statamic\Modifiers\Modify;

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
                Cloudflare::Api()->Zones()->cachePurgeEverything($zone);
            }
        });

        return back()->withSuccess(__('All caches cleared.'));
    }
}
