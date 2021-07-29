<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait CustomHostnames
{
    /**
     * @return \Cloudflare\API\Endpoints\CustomHostnames
     */
    public function CustomHostnames()
    {
        return new \Cloudflare\API\Endpoints\CustomHostnames($this->instance);
    }
}
