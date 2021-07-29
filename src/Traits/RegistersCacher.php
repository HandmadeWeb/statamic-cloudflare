<?php

namespace HandmadeWeb\StatamicCloudflare\Traits;

trait RegistersCacher
{
    public static function registerCacher()
    {
        app(\Statamic\StaticCaching\StaticCacheManager::class)->extend('cloudflare', function ($app, $config, $name) {
            return new \HandmadeWeb\StatamicCloudflare\Cachers\CloudflareCacher($app[\Illuminate\Cache\Repository::class], $config);
        });
    }
}
