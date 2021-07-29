<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait Crypto
{
    /**
     * @return \Cloudflare\API\Endpoints\Crypto
     */
    public function Crypto()
    {
        return new \Cloudflare\API\Endpoints\Crypto($this->instance);
    }
}
