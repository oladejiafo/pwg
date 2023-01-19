<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'quickbook_local' => [
        'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
        'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
        'client_id' => 'AB8TTuMehywUWCSsWSUH51ZIBgev9NTGfcSfGAWBtVdDWzhO70',
        'client_secret' => 'a4YPTQv5CskeS5oKLGETl3LUsVM1Dn102sSKtN8L',
        'oauth_scope' => 'com.intuit.quickbooks.accounting',
        'oauth_redirect_uri' => 'http://localhost:8000/quickbook/token',
        'QBORealmID' => "4620816365268747840",
    ],

    'quickbook' => [
        'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
        'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
        'client_id' => 'ABPfOuKNtTYwV94Hjr1tcj65e5JoiSUCM2ACWopTd7u9CahREh',
        'client_secret' => 'oET6MJe9roPU4xHCZqIuMRhuVI0OwWg30o4evSxx',
        'oauth_scope' => 'com.intuit.quickbooks.accounting',
        'oauth_redirect_uri' => 'https://eportal.emasimmigration.in/quickbook/token',
        'QBORealmID' => "9130355486922526",
    ],

];
