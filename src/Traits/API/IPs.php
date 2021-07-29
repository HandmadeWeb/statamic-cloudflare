<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait IPs
{
    /**
     * @return \Cloudflare\API\Endpoints\IPs
     */
    public function IPs()
    {
        return new \Cloudflare\API\Endpoints\IPs($this->instance);
    }
}
