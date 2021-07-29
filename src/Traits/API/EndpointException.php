<?php

namespace HandmadeWeb\StatamicCloudflare\Traits\API;

trait EndpointException
{
    /**
     * @return \Cloudflare\API\Endpoints\EndpointException
     */
    public function EndpointException($message = '', $code = 0, ?Throwable $previous = null)
    {
        return new \Cloudflare\API\Endpoints\EndpointException($message, $code, $previous);
    }
}
