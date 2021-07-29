<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait SSL
{
    /**
     * @return \Cloudflare\API\Endpoints\SSL
     */
    public function SSL()
    {
        return new \Cloudflare\API\Endpoints\SSL($this->instance);
    }
}
