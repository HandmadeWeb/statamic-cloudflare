<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait ZoneSettings
{
    /**
     * @return \Cloudflare\API\Endpoints\ZoneSettings
     */
    public function ZoneSettings()
    {
        return new \Cloudflare\API\Endpoints\ZoneSettings($this->instance);
    }
}
