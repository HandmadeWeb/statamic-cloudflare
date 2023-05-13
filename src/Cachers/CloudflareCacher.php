<?php

namespace HandmadeWeb\StatamicCloudflare\Cachers;

use HandmadeWeb\StatamicCloudflare\Cloudflare;
use HandmadeWeb\StatamicCloudflare\Jobs\PurgeEverythingForZone;
use HandmadeWeb\StatamicCloudflare\Jobs\PurgeZoneUrls;
use Illuminate\Contracts\Cache\Repository;
use Illuminate\Http\Request;
use Statamic\StaticCaching\Cachers\AbstractCacher;
use Statamic\StaticCaching\StaticCacheManager;

class CloudflareCacher extends AbstractCacher
{
    protected $strategy;

    /**
     * @param Repository $cache
     */
    public function __construct(Repository $cache, $config)
    {
        parent::__construct($cache, $config);

        $strategy = $this->config('strategy');
        $strategy = empty($strategy) ? 'null' : $strategy;

        $this->strategy = app(StaticCacheManager::class)->driver($strategy);
    }

    public function strategy()
    {
        return $this->strategy;
    }

    /**
     * Cache a page.
     *
     * @param \Illuminate\Http\Request  $request  Request associated with the page to be cached
     * @param string  $content  The response content to be cached
     */
    public function cachePage(Request $request, $content)
    {
        return $this->strategy()->cachePage($request, $content);
    }

    /**
     * Check if a page has been cached.
     *
     * @param Request $request
     * @return bool
     */
    public function hasCachedPage(Request $request)
    {
        return $this->strategy()->hasCachedPage($request);
    }

    /**
     * Get a cached page.
     *
     * @param Request $request
     * @return string
     */
    public function getCachedPage(Request $request)
    {
        return $this->strategy()->getCachedPage($request);
    }

    /**
     * Flush out the entire static cache.
     *
     * @return void
     */
    public function flush()
    {
        $this->strategy()->flush();

        Cloudflare::zones()->each(function ($zone) {
            if (Cloudflare::shouldQueue()) {
                PurgeEverythingForZone::dispatch($zone);
            } else {
                PurgeEverythingForZone::dispatchSync($zone);
            }
        });
    }

    /**
     * Invalidate a URL.
     *
     * @param string $url
     * @return void
     */
    public function invalidateUrl($url)
    {
        $this->strategy()->invalidateUrl($url);

        Cloudflare::zones()->each(function ($zone) use ($url) {
            if (Cloudflare::shouldQueue()) {
                PurgeZoneUrls::dispatch($zone, [$url]);
            } else {
                PurgeZoneUrls::dispatchSync($zone, [$url]);
            }
        });
    }

    /**
     * Invalidate multiple URLs.
     *
     * @param array $urls
     * @return void
     */
    public function invalidateUrls($urls)
    {
        $this->strategy()->invalidateUrls($urls);

        collect($urls)->each(function ($url) {
            $this->invalidateUrl($url);
        });
    }

    /**
     * Get all the URLs that have been cached.
     *
     * @param string|null $domain
     * @return \Illuminate\Support\Collection
     */
    public function getUrls($domain = null)
    {
        return $this->strategy()->getUrls($domain);
    }
}
