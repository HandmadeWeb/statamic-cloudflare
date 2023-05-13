<?php

namespace HandmadeWeb\StatamicCloudflare\Tests;

use HandmadeWeb\StatamicCloudflare\ServiceProvider;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Statamic\Extend\Manifest;
use Statamic\Providers\StatamicServiceProvider;
use Statamic\Statamic;

class TestCase extends OrchestraTestCase
{
    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageProviders($app): array
    {
        return [
            StatamicServiceProvider::class,
            ServiceProvider::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     * @return array
     */
    protected function getPackageAliases($app): array
    {
        return [
            'Statamic' => Statamic::class,
        ];
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app): void
    {
        // make sure, our .env file is loaded
        $app->useEnvironmentPath(__DIR__.'/../');
        $app->bootstrapWith([LoadEnvironmentVariables::class]);

        parent::getEnvironmentSetUp($app);

        $app->make(Manifest::class)->manifest = [
            'handmadeweb/statamic-cloudflare' => [
                'id' => 'handmadeweb/statamic-cloudflare',
                'namespace' => 'HandmadeWeb\\StatamicCloudflare\\',
            ],
        ];
    }

    /**
     * Resolve the Application Configuration and set the Statamic configuration.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function resolveApplicationConfiguration($app): void
    {
        parent::resolveApplicationConfiguration($app);

        $configs = [
            'assets', 'cp', 'forms', 'routes', 'static_caching',
            'sites', 'stache', 'system', 'users',
        ];

        foreach ($configs as $config) {
            $app['config']->set("statamic.{$config}", require(__DIR__."/../vendor/statamic/cms/config/{$config}.php"));
        }

        // Setting the user repository to the default flat file system
        $app['config']->set('statamic.users.repository', 'file');

        // Assume the pro edition within tests
        $app['config']->set('statamic.editions.pro', true);

        // Load statamic-cloudflare config.
        $app['config']->set('statamic-cloudflare', require(__DIR__.'/../config/statamic-cloudflare.php'));

        // Load root level statamic-cloudflare config.
        $app['config']->set('statamic-cloudflare', array_merge(
            $app['config']->get('statamic-cloudflare'),
            require(__DIR__.'/../../../../config/statamic-cloudflare.php')
        ));
    }
}
