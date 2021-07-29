<?php

namespace HandmadeWeb\StatamicCloudflare;

use HandmadeWeb\StatamicCloudflare\Traits\RegistersCacher;
use Statamic\Facades\Site as SiteFacade;
use Statamic\Modifiers\Modify;
use Statamic\Sites\Site;

class Cloudflare
{
    use RegistersCacher;

    protected static $booted;
    protected static $api;
    protected static $zones;
    protected static $zoneId;

    public static function boot()
    {
        if (! static::$booted) {
            static::$booted = true;

            static::$api = new CloudflareApi;
            static::$zones = collect(static::config('zones', []));
        }
    }

    public static function config($key = null, $default = null)
    {
        if (is_null($key)) {
            return config('statamic-cloudflare');
        }

        return config("statamic-cloudflare.{$key}", $default);
    }

    public static function shouldQueue()
    {
        return static::config('queued') ? true : false;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public static function zones()
    {
        static::boot();

        return static::$zones;
    }

    /**
     * @return \HandmadeWeb\StatamicCloudflare\CloudflareApi
     */
    public static function Api()
    {
        static::boot();

        return static::$api;
    }

    public static function getZoneIdForSite(Site $site)
    {
        static::boot();

        $siteUrl = Modify::value($site->absoluteUrl())
            ->removeLeft('http://')
            ->removeLeft('https://')
            ->removeRight('/')
            ->explode(':')
            ->first()
            ->__toString();

        return static::$zones->get($siteUrl) ?? static::Api()->Zones()->getZoneID($siteUrl);
    }

    public static function getZoneIdForCurrentSite()
    {
        static::boot();

        return static::getZoneIdForSite(SiteFacade::current());
    }
}
