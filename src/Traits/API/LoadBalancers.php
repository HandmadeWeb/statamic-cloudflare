<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait LoadBalancers
{
    /**
     * @return \Cloudflare\API\Endpoints\LoadBalancers
     */
    public function LoadBalancers()
    {
        return new \Cloudflare\API\Endpoints\LoadBalancers($this->instance);
    }
}
