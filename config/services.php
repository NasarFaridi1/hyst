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

    'google' => [
            'client_id'     => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect'      => env('GOOGLE_REDIRECT_URI'),
    ],

    'facebook' => [
            'client_id'     => env('FACEBOOK_CLIENT_ID'),
            'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'redirect'      => env('FACEBOOK_REDIRECT_URI'),
    ],

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'google_drive' => [
        'image_url' => env('GOOGLE_DRIVE_IMAGE_URL'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],
    'stuart' => [

        'client_id' => env('STUART_CLIENT_ID'),

        'client_secret' => env('STUART_CLIENT_SECRET'),

        'base_url' => env('STUART_BASE_URL'),

    ],
    'uber' => [

        'client_id' => env('UBER_CLIENT_ID'),

        'client_secret' => env('UBER_CLIENT_SECRET'),

        'customer_id' => env('UBER_CUSTOMER_ID'),

        'base_url' => env('UBER_BASE_URL'),

        'auth_url' => env('UBER_AUTH_URL'),

        'signing_key' => env('UBER_SIGNING_KEY', env('UBER_CLIENT_SECRET')),

    ],
    'firebase' => [

        'credentials' => env('FIREBASE_CREDENTIALS'),
        'api_key' =>
            env('FIREBASE_API_KEY'),

        'auth_domain' =>
            env('FIREBASE_AUTH_DOMAIN'),

        'project_id' =>
            env('FIREBASE_PROJECT_ID'),

        'storage_bucket' =>
            env('FIREBASE_STORAGE_BUCKET'),

        'sender_id' =>
            env('FIREBASE_SENDER_ID'),

        'app_id' =>
            env('FIREBASE_APP_ID'),

        'measurement_id' =>
            env('FIREBASE_MEASUREMENT_ID'),

        'vapid_key' =>
            env('FIREBASE_VAPID_KEY'),

    ],


    'worldpay' => [
        'environment' => env('WORLDPAY_ENV', 'production'),
        'auth_url'    => env('WORLDPAY_ENV') === 'production'
                            ? 'https://auth.paymentsapi.io'
                            : 'https://sandbox.auth.paymentsapi.io',
        'api_url'     => env('WORLDPAY_ENV') === 'production'
                            ? 'https://rest.paymentsapi.io'
                            : 'https://sandbox.rest.paymentsapi.io',
    ],

];