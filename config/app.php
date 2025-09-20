<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application, which will be used when the
    | framework needs to place the application's name in a notification or
    | other UI elements where an application name needs to be displayed.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | the application so that it's available within Artisan commands.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. The timezone
    | is set to "UTC" by default as it is suitable for most use cases.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by Laravel's translation / localization methods. This option can be
    | set to any locale for which you plan to have translation strings.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    'fallback_locale' => env('APP_FALLBACK_LOCALE', 'en'),

    'faker_locale' => env('APP_FAKER_LOCALE', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is utilized by Laravel's encryption services and should be set
    | to a random, 32 character string to ensure that all encrypted values
    | are secure. You should do this prior to deploying the application.
    |
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', (string) env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    'locales' => env('APP_LOCALES', 'en,ar'),
    'social_media' => [
        [
            'env_key' => 'facebook',
            'url' => env('CONTACT_FACEBOOK', '#'),
            'icon' => 'social.facebook-f',
            'bg_color' => 'bg-blue-600 hover:bg-blue-700',
        ],
        [
            'env_key' => 'twitter',
            'url' => env('CONTACT_TWITTER', '#'),
            'icon' => 'social.x-twitter',
            'bg_color' => 'bg-blue-400 hover:bg-blue-500',
        ],
        [
            'env_key' => 'instagram',
            'url' => env('CONTACT_INSTAGRAM', '#'),
            'icon' => 'social.instagram',
            'bg_color' => 'bg-pink-500 hover:bg-pink-600',
        ],
        [
            'env_key' => 'snapchat',
            'url' => env('CONTACT_SNAPCHAT', '#'),
            'icon' => 'social.snapchat',
            'bg_color' => 'bg-yellow-400 hover:bg-yellow-500',
        ],
        [
            'env_key' => 'linkedin',
            'url' => env('CONTACT_LINKEDIN', '#'),
            'icon' => 'social.linkedin-in',
            'bg_color' => 'bg-blue-700 hover:bg-blue-800',
        ],
        [
            'env_key' => 'youtube',
            'url' => env('CONTACT_YOUTUBE', '#'),
            'icon' => 'social.youtube',
            'bg_color' => 'bg-red-600 hover:bg-red-700',
        ],
        [
            'env_key' => 'whatsapp',
            'url' => env('CONTACT_WHATSAPP', '#'),
            'icon' => 'social.whatsapp',
            'bg_color' => 'bg-green-500 hover:bg-green-600',
        ],
        [
            'env_key' => 'telegram',
            'url' => env('CONTACT_TELEGRAM', '#'),
            'icon' => 'social.telegram',
            'bg_color' => 'bg-blue-400 hover:bg-blue-500',
        ],
        [
            'env_key' => 'tiktok',
            'url' => env('CONTACT_TIKTOK', '#'),
            'icon' => 'social.tiktok',
            'bg_color' => 'bg-black hover:bg-gray-800',
        ],
    ],

];
