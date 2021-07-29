<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait Certicates
{
    /**
     * @return \Cloudflare\API\Endpoints\Certificates
     */
    public function Certificates()
    {
        return new \Cloudflare\API\Endpoints\Certificates($this->instance);
    }
}
