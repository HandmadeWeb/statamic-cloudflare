<?php

namespace HandmadeWeb\StatamicCloudflare\Tests\StaticCaching;

use HandmadeWeb\StatamicCloudflare\Cachers\CloudflareCacher;
use HandmadeWeb\StatamicCloudflare\Tests\TestCase;
use Illuminate\Cache\Repository;

class CloudflareCacherTest extends TestCase
{
    private function cacher($config = [])
    {
        return new CloudflareCacher(app(Repository::class), $config);
    }

    /** @test */
    public function it_is_instanceof_cloudflare_cacher()
    {
        $this->assertTrue($this->cacher() instanceof CloudflareCacher);
    }
}
