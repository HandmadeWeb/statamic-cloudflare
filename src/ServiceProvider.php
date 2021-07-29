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

    public function boot()
    {
        parent::boot();

        $this->mergeConfigFrom(__DIR__.'/../config/statamic-cloudflare.php', 'statamic-cloudflare');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/statamic-cloudflare.php' => config_path('statamic-cloudflare.php'),
            ], 'config');
        }

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
