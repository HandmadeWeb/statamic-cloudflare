<?php

namespace HandmadeWeb\StatamicCloudflare\Tests\StaticCaching;

use HandmadeWeb\StatamicCloudflare\Cachers\CloudflareCacher;
use HandmadeWeb\StatamicCloudflare\Tests\TestCase;
use Illuminate\Cache\Repository;
use Illuminate\Http\Request;
use Statamic\StaticCaching\Cachers\ApplicationCacher;

class CloudflareCacherWithHalfStrategyTest extends TestCase
{
    protected function cacher($config = [])
    {
        return new CloudflareCacher(app(Repository::class), array_merge([
            'strategy' => 'half',
        ], $config));
    }

    /** @test */
    public function it_has_application_cacher_strategy()
    {
        $cacher = $this->cacher();

        $this->assertTrue($cacher->strategy() instanceof ApplicationCacher);
    }

    /** @test */
    public function it_can_cache_pages()
    {
        $cacher = $this->cacher();
        $request = Request::create('http://localhost', 'GET');

        $this->assertFalse($cacher->hasCachedPage($request));

        $cacher->cachePage($request, 'html content');
        $this->assertTrue($cacher->hasCachedPage($request));
    }

    /** @test */
    public function it_can_get_cached_pages()
    {
        $cacher = $this->cacher();
        $request = Request::create('http://localhost', 'GET');

        $cacher->cachePage($request, 'html content');
        $this->assertTrue($cacher->hasCachedPage($request));

        $this->assertEquals('html content', $cacher->getCachedPage($request));
    }

    /** @test */
    public function it_can_invalidate_urls()
    {
        $cacher = $this->cacher();
        $request = Request::create('http://localhost', 'GET');

        $cacher->cachePage($request, 'html content');
        $this->assertTrue($cacher->hasCachedPage($request));

        $cacher->invalidateUrl('/');
        $this->assertFalse($cacher->hasCachedPage($request));
    }
}
