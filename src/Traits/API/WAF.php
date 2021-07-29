<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait WAF
{
    /**
     * @return \Cloudflare\API\Endpoints\WAF
     */
    public function WAF()
    {
        return new \Cloudflare\API\Endpoints\WAF($this->instance);
    }
}
