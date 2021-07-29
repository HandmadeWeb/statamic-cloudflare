<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait FirewallSettings
{
    /**
     * @return \Cloudflare\API\Endpoints\FirewallSettings
     */
    public function FirewallSettings()
    {
        return new \Cloudflare\API\Endpoints\FirewallSettings($this->instance);
    }
}
