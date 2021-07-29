<?php

namespace HandmadeWeb\StatamicCloudflare\Tests\StaticCaching;

use HandmadeWeb\StatamicCloudflare\Cachers\CloudflareCacher;
use HandmadeWeb\StatamicCloudflare\Tests\TestCase;
use Illuminate\Cache\Repository;
use Statamic\StaticCaching\Cachers\NullCacher;

class CloudflareCacherWithNullStrategyTest extends TestCase
{
    private function cacher($config = [])
    {
        return new CloudflareCacher(app(Repository::class), array_merge([
            'strategy' => 'null',
        ], $config));
    }

    /** @test */
    public function it_has_null_cacher_strategy()
    {
        $cacher = $this->cacher();

        $this->assertTrue($cacher->strategy() instanceof NullCacher);
    }
}
