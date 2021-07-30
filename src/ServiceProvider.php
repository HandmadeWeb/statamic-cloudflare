<?php

namespace HandmadeWeb\StatamicCloudflare;

use HandmadeWeb\StatamicCloudflare\Http\Controllers\CloudflareUtilityController;
use Illuminate\Cache\Repository;
use Statamic\Facades\Utility;
use Statamic\Providers\AddonServiceProvider;
use Statamic\Statamic;
use Statamic\StaticCaching\StaticCacheManager;

class ServiceProvider extends AddonServiceProvider
{
    protected $commands = [
        \HandmadeWeb\StatamicCloudflare\Commands\CachePurgeEverything::class,
    ];

    protected $listen = [
        \Statamic\Events\EntrySaved::class => [
            \HandmadeWeb\StatamicCloudflare\Listeners\PurgeEntryUrl::class,
        ],
        \Statamic\Events\EntryDeleted::class => [
            \HandmadeWeb\StatamicCloudflare\Listeners\PurgeEntryUrl::class,
        ],
        \Statamic\Events\TermSaved::class => [
            \HandmadeWeb\StatamicCloudflare\Listeners\PurgeTermUrl::class,
        ],
        \Statamic\Events\TermDeleted::class => [
            \HandmadeWeb\StatamicCloudflare\Listeners\PurgeTermUrl::class,
        ],
    ];

    public function boot()
    {
        $static_cacher = config('statamic.static_caching.strategy');

        // If the static cache strategy is set to the Cloudflare Cacher, then remove listeners as the cacher will handle purges.
        if (config("statamic.static_caching.strategies.{$static_cacher}.driver") === 'cloudflare') {
            $this->listen = [];
        }

        // Disable functionality if Cloudflare Api hasn't been configured.
        if (Cloudflare::isNotConfigured()) {
            $this->listen = [];
        }

        parent::boot();

        $this->mergeConfigFrom(__DIR__.'/../config/statamic-cloudflare.php', 'statamic-cloudflare');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/statamic-cloudflare.php' => config_path('statamic-cloudflare.php'),
            ], 'config');
        }

        // Enable functionality if Cloudflare Api has been configured.
        if (Cloudflare::isConfigured()) {
            Utility::make('cloudflare')
            ->action([CloudflareUtilityController::class, 'index'])
            ->title(__('Cloudflare Manager'))
            ->icon('earth')
            ->navTitle(__('Cloudflare'))
            ->description('Purge Cloudflare from the comfort of your Statamic CP.')
            // ->docsUrl(Statamic::docsUrl('utilities/cache-manager'))
            ->routes(function ($router) {
                $router->post('/purgeAll', [CloudflareUtilityController::class, 'purgeAll'])->name('purgeAll');
            })
            ->register();
        }
    }
}
