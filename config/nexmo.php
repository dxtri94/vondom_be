<?php
return [

    /*
    |--------------------------------------------------------------------------
    | API Credentials
    |--------------------------------------------------------------------------
    |
    | If you're using API credentials, change these settings. Get your
    | credentials from https://dashboard.nexmo.com | 'Settings'.
    |
    */

    'api_key' => config('env.NEXMO_KEY', '536f2551'),
    'api_secret' => config('env.NEXMO_SECRET', '97d44373ed132008'),

    /*
    |--------------------------------------------------------------------------
    | Signature Secret
    |--------------------------------------------------------------------------
    |
    | If you're using a signature secret, use this section. This can be used
    | without an `api_secret` for some APIs, as well as with an `api_secret`
    | for all APIs.
    |
    */
    'signature_secret' => config('env.NEXMO_SIGNATURE_SECRET', 'u7HgJQBAXxwJ62ZNllhPyHIEfIO6YE0Ry9ofWapsbWI4V8tzRD')

];