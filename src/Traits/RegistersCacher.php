<?php

namespace HandmadeWeb\StatamicCloudflare\Traits;

use Statamic\StaticCaching\Cachers\NullCacher;

trait RegistersCacher
{
    public static function registerCacher()
    {
        if (static::isConfigured()) {
            app(\Statamic\StaticCaching\StaticCacheManager::class)->extend('cloudflare', function ($app, $config, $name) {
                return new \HandmadeWeb\StatamicCloudflare\Cachers\CloudflareCacher($app[\Illuminate\Cache\Repository::class], $config);
            });
        } else {
            app(\Statamic\StaticCaching\StaticCacheManager::class)->extend('cloudflare', function ($app, $config, $name) {
                return new NullCacher($app[\Illuminate\Cache\Repository::class], $config);
            });
        }
    }
}
