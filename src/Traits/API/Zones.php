<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait Zones
{
    /**
     * @return \Cloudflare\API\Endpoints\Zones
     */
    public function Zones()
    {
        return new \Cloudflare\API\Endpoints\Zones($this->instance);
    }
}
