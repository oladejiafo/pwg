<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'PWG Group'),

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
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost:8000'),

    'asset_url' => env('ASSET_URL', null),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Network payment integration
    |--------------------------------------------------------------------------
    |
    | Api key and reference are adding here will be automtically loaded on the request on 
    | your appliction
    |
    */

    'payment_api_key' => 'MmM2ODJiOGMtOGFmNS00NzUyLTg2MjUtM2Y5MTg3OWU5YjRlOjViMzhjM2I5LTUyMDItNDBmZi1hNzAyLTFlYTIwZDkwYjhiMQ==',
    'payment_reference' => '15d885ec-682a-4398-89d9-247254d71c18', 

    /*
    |--------------------------------------------------------------------------
    | Quickbook
    |--------------------------------------------------------------------------
    |
    | Api key and reference are adding here will be automtically loaded on the request on 
    | your appliction
    |
    */

    'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
    'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
    'client_id' => 'AB5mLL6k7Ls4UUZnk5kZ957ExGbszzam5Oelx2hi8K9VdqO4Ac',
    'client_secret' => 'pcEIASrqn7ly0J23i7dedorked8ZiQPeEHJDRfPh',
    'oauth_scope' => 'com.intuit.quickbooks.accounting',
    'oauth_redirect_uri' => 'https://developer.intuit.com/v2/OAuth2Playground/RedirectUrl',
    'accessTokenKey' => 'eyJlbmMiOiJBMTI4Q0JDLUhTMjU2IiwiYWxnIjoiZGlyIn0..wEELViObtQ7RGVPLC-QuGQ.x1z7jNzqRpGRnBkG5Wl6J-W8ZmtVAs1t-QprWc-M6wl3Yp_3l5fPtoQTzm39Dp95kUmGIIa_A3LXNkr1ABaNODz68zxP2-OPnx_nT2-1VAfy6HxRz_-uObNT4zWv4FVJsq28NfEiIRbTvqsFlZOL4JjzYh2j3BQL4VnxtOOvW7UkFlH4mdDcMfAaovhmhxPcNRG2KD1V_1qZ9Y_cRoVVwGzgLiw9nlYMe34JhE1HSVexhQ-wNCHlSUD51TBk0pngd-L8-Qnu8KzqPFFUk19XW-T5wb5Ou5cW_We55dm1I9xPfwqE6_AE-54ODKMfL0WmQeR35aytbWC3COFAncvuEu4WvynE_4gsdzeFlA64mdL8AN9iCkjJT7KdP43YRvbbH-_1rOmU7HaNLH5K36eTiPMg_9ggk9KRR2uobJPKQvf91WaNRcNMIvxzO1AiTtdLfGPnOChiLqMUtIylytJ9d12MaIq8Ws68EdN3Msvg0CiLp-iECx6weYim71QD3eGqc_dB9tMm2YcePcR8Wpxv1ixn7gsj1kN33mx_nZGDt-O1eGVg35vHhviusqDvEsnKig4guUuLabYz2uSrP0G08U6Vsklug7u5hIkuhKcRVHNwRqq4E9o0L_-tr1KKw-PfEQJT2FWjiEkHbpIJDnIMMzirLW-Ll_oU6K5KuqMsVVxJl_sXVKPL4-q8i4R5L-sWexO1-NtXC58oyr_mkrjMKbbm-P0oovn1lMq1jJnfgMwx8DjMPJhFwTEhS4OrnJ3t.QYpWdhA0jHVtQCZvUZnB-Q',
    'refreshTokenKey' => "AB11673162809Om2hwRElaiMQiPrszhG2wfwj1umYlGzVVRhzf",
    'QBORealmID' => "4620816365244502690",

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */
        Barryvdh\DomPDF\ServiceProvider::class,
        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\FortifyServiceProvider::class,
        App\Providers\JetstreamServiceProvider::class,
        Codedge\Fpdf\FpdfServiceProvider::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App' => Illuminate\Support\Facades\App::class,
        'Arr' => Illuminate\Support\Arr::class,
        'Artisan' => Illuminate\Support\Facades\Artisan::class,
        'Auth' => Illuminate\Support\Facades\Auth::class,
        'Blade' => Illuminate\Support\Facades\Blade::class,
        'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
        'Bus' => Illuminate\Support\Facades\Bus::class,
        'Cache' => Illuminate\Support\Facades\Cache::class,
        'Config' => Illuminate\Support\Facades\Config::class,
        'Cookie' => Illuminate\Support\Facades\Cookie::class,
        'Crypt' => Illuminate\Support\Facades\Crypt::class,
        'Date' => Illuminate\Support\Facades\Date::class,
        'DB' => Illuminate\Support\Facades\DB::class,
        'Eloquent' => Illuminate\Database\Eloquent\Model::class,
        'Event' => Illuminate\Support\Facades\Event::class,
        'File' => Illuminate\Support\Facades\File::class,
        'Gate' => Illuminate\Support\Facades\Gate::class,
        'Hash' => Illuminate\Support\Facades\Hash::class,
        'Http' => Illuminate\Support\Facades\Http::class,
        'Js' => Illuminate\Support\Js::class,
        'Lang' => Illuminate\Support\Facades\Lang::class,
        'Log' => Illuminate\Support\Facades\Log::class,
        'Mail' => Illuminate\Support\Facades\Mail::class,
        'Notification' => Illuminate\Support\Facades\Notification::class,
        'Password' => Illuminate\Support\Facades\Password::class,
        'Queue' => Illuminate\Support\Facades\Queue::class,
        'RateLimiter' => Illuminate\Support\Facades\RateLimiter::class,
        'Redirect' => Illuminate\Support\Facades\Redirect::class,
        // 'Redis' => Illuminate\Support\Facades\Redis::class,
        'Request' => Illuminate\Support\Facades\Request::class,
        'Response' => Illuminate\Support\Facades\Response::class,
        'Route' => Illuminate\Support\Facades\Route::class,
        'Schema' => Illuminate\Support\Facades\Schema::class,
        'Session' => Illuminate\Support\Facades\Session::class,
        'Storage' => Illuminate\Support\Facades\Storage::class,
        'Str' => Illuminate\Support\Str::class,
        'URL' => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View' => Illuminate\Support\Facades\View::class,
        'Constant' => App\Constant::class,
        'PDF' => Barryvdh\DomPDF\Facade::class,
        'Fpdf' => Codedge\Fpdf\Facades\Fpdf::class,
    ],

];
