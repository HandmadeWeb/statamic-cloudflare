<?php

return [

    /*
     * API token generated from the User Profile 'My Profile > Api Tokens > API Tokens' page.
     * CLOUDFLARE_KEY will take priority over CLOUDFLARE_TOKEN
     */
    'token' => env('CLOUDFLARE_TOKEN', null),

    /*
     * Global API Key on the "My Profile > Api Tokens > API Keys" page.
     */
    'key' => env('CLOUDFLARE_KEY', null),

    /*
     * Email address associated with your account.
     */
    'email' => env('CLOUDFLARE_EMAIL', null),

    /*
     * Should purges be processed in a queue?
     * CLI commands will always run on request.
     */
    'queued' => true,

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
        env('CLOUDFLARE_ZONE_DOMAIN', null) => env('CLOUDFLARE_ZONE_ID', null),
    ],
];
