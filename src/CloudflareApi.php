<?php

namespace HandmadeWeb\StatamicCloudflare;

use Cloudflare\API\Adapter\Guzzle as CloudflareClient;
use Cloudflare\API\Auth\APIKey;
use HandmadeWeb\StatamicCloudflare\Traits\API\AccessRules;
use HandmadeWeb\StatamicCloudflare\Traits\API\Accounts;
use HandmadeWeb\StatamicCloudflare\Traits\API\API;
use HandmadeWeb\StatamicCloudflare\Traits\API\Certicates;
use HandmadeWeb\StatamicCloudflare\Traits\API\Crypto;
use HandmadeWeb\StatamicCloudflare\Traits\API\CustomHostnames;
use HandmadeWeb\StatamicCloudflare\Traits\API\DNS;
use HandmadeWeb\StatamicCloudflare\Traits\API\DNSAnalytics;
use HandmadeWeb\StatamicCloudflare\Traits\API\EndpointException;
use HandmadeWeb\StatamicCloudflare\Traits\API\Firewall;
use HandmadeWeb\StatamicCloudflare\Traits\API\FirewallSettings;
use HandmadeWeb\StatamicCloudflare\Traits\API\IPs;
use HandmadeWeb\StatamicCloudflare\Traits\API\LoadBalancers;
use HandmadeWeb\StatamicCloudflare\Traits\API\Membership;
use HandmadeWeb\StatamicCloudflare\Traits\API\PageRules;
use HandmadeWeb\StatamicCloudflare\Traits\API\Pools;
use HandmadeWeb\StatamicCloudflare\Traits\API\RailGun;
use HandmadeWeb\StatamicCloudflare\Traits\API\SSL;
use HandmadeWeb\StatamicCloudflare\Traits\API\TLS;
use HandmadeWeb\StatamicCloudflare\Traits\API\UARules;
use HandmadeWeb\StatamicCloudflare\Traits\API\User;
use HandmadeWeb\StatamicCloudflare\Traits\API\WAF;
use HandmadeWeb\StatamicCloudflare\Traits\API\ZoneLockdown;
use HandmadeWeb\StatamicCloudflare\Traits\API\Zones;
use HandmadeWeb\StatamicCloudflare\Traits\API\ZoneSettings;

class CloudflareApi
{
    use AccessRules;
    use Accounts;
    use API;
    use Certicates;
    use Crypto;
    use CustomHostnames;
    use DNS;
    use DNSAnalytics;
    use EndpointException;
    use Firewall;
    use FirewallSettings;
    use IPs;
    use LoadBalancers;
    use Membership;
    use PageRules;
    use Pools;
    use RailGun;
    use SSL;
    use TLS;
    use UARules;
    use User;
    use WAF;
    use ZoneLockdown;
    use Zones;
    use ZoneSettings;

    protected $instance;

    public function __construct()
    {
        $APIKey = new APIKey(Cloudflare::config('email'), Cloudflare::config('key'));
        $this->instance = new CloudflareClient($APIKey);
    }

    /**
     * @return \Cloudflare\API\Endpoints\CloudflareClient
     */
    public function instance()
    {
        return $this->instance();
    }
}
