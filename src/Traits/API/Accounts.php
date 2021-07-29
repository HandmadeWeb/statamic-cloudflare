<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait Accounts
{
    /**
     * @return \Cloudflare\API\Endpoints\Accounts
     */
    public function Accounts()
    {
        return new \Cloudflare\API\Endpoints\Accounts($this->instance);
    }
}
