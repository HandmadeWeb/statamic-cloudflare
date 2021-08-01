[![MIT Licensed](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Cloudflare integration for Statamic with CLI, static caching integration and control panel integration.

Inspired by [sebdesign/artisan-cloudflare](https://github.com/sebdesign/artisan-cloudflare)

## Requirements

* Statamic 3.1.2 or higher

## Installation

You can install the package via composer:

```shell
composer require handmadeweb/statamic-cloudflare
```

#### Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="HandmadeWeb\StatamicCloudflare\ServiceProvider"
```

Then add your cloudflare details to your `.env` file.

```env
CLOUDFLARE_KEY=
CLOUDFLARE_EMAIL=
```

or

```env
CLOUDFLARE_TOKEN=
CLOUDFLARE_EMAIL=
```

`Note that CLOUDFLARE_KEY will be used instead of CLOUDFLARE_TOKEN in the event that they are both set.
KEY is the global api key with all possible permissions and TOKEN is a generated Api KEY/TOKEN which has specific permissions enabled/disabled.`

And configure your `zones`, If you only need to specify a single zone, then you can add it to your `.env`

```env
CLOUDFLARE_ZONE_DOMAIN=
CLOUDFLARE_ZONE_ID=
```

Otherwise you can specify multiple zones in your `statamic-cloudflare.php`

```php
    /*
     * Array of zones.
     *
     * Each zone must have its domain as the key. The value should be your zoneId.
     *
     * you can find your zoneId under 'Account Home > site > Api'.
     *
     * E.g.
     *
     * 'example.com' => '023e105f4ecef8ad9ca31a8372d0c353'
     */
    'zones' => [
        // env('CLOUDFLARE_ZONE_DOMAIN', null) => env('CLOUDFLARE_ZONE_ID', null),
    ],
```

By default all purge actions `except the Cli commands` will be queued with your default queue.

This can be changed in the configuration.

```php
    /*
     * Should purges be processed in a queue?
     * CLI commands will always run on request.
     */
    'queued' => true,
```

## Usage

### Cli

You can purge everything via the following commands.

```shell
php artisan cloudflare:cache:purge:everything
```

```shell
php please cloudflare:cache:purge:everything
```

### Static Caching

If you want to use `statamic-cloudflare` as a static cache strategy then you will need to manually register the cacher in the register method of your `App\Providers\AppServiceProvider` class.

```php
/**
 * Register any application services.
 *
 * @return void
 */
public function register()
{
    \HandmadeWeb\StatamicCloudflare\Cloudflare::registerCacher();
}
```

Then update your `static_cache` config.

```php
'strategies' => [

    'half' => [
        'driver' => 'application',
        'expiry' => null,
    ],

    'full' => [
        'driver' => 'file',
        'path' => public_path('static'),
        'lock_hold_length' => 0,
    ],

    'cloudflare' => [
        'driver' => 'cloudflare',
        'strategy' => 'null',
    ],
],
```

Then update the `static_cache` strategy at the top of the configuration to:

```php
'strategy' => 'cloudflare',
```

Currently the Cloudflare integration is only used for purging, If you would like to use another caching strategy in combination with this caching strategy, then you are free to do that.

This can be done by updating the `strategy` section within the `cloudflare` strategy, below is an example where we will be caching the application using the [half measure](https://statamic.dev/static-caching#application-driver)

```php
'cloudflare' => [
    'driver' => 'cloudflare',
    'strategy' => 'half',
],
```

In theory, you should be able to use any caching strategy here, such as the [full measure](https://statamic.dev/static-caching#file-driver) or any other first or third party strategies, `statamic-cloudfare` will simply pass requests to the defined strategy and will just hook into the purge actions to also purge the page in Cloudflare.

### Control Panel

#### Events

`statamic-cloudflare` will listen to the `Statamic\Events\EntrySaved`, `Statamic\Events\EntryDeleted`, `Statamic\Events\TermSaved` and `Statamic\Events\TermDeleted` events and will trigger a pruge for the url.
These events will be ignored if you have configured the `static cache` to be a strategy that uses the `cloudflare` driver, as the driver will instead handle the needed purging actions.

#### Utility

`statamic-cloudflare` will add a utility to your Statamic CP.

route: `/cp/utilities/cloudflare`

This will be available to `Super Users` and Users who have the `
Cloudflare Manager` permission.

You can purge everything quickly from here.

## Changelog

Please see [CHANGELOG](https://statamic.com/addons/handmadeweb/statamic-cloudflare/release-notes) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/handmadeweb/statamic-cloudflare/blob/main/CONTRIBUTING.md) for details.

## Credits

- [Handmade Web & Design](https://github.com/handmadeweb)
- [Michael Rook](https://github.com/michaelr0)
- [All Contributors](https://github.com/handmadeweb/statamic-cloudflare/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](https://github.com/handmadeweb/statamic-cloudflare/blob/main/LICENSE.md) for more information.