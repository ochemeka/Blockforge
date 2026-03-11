<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To allow CORS for the React Native mobile app, configure the allowed
    | origins to match your mobile app's bundle identifier or domain.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],

    'allowed_origins' => [
        'http://localhost:3000',
        'http://localhost:8081',
        'http://localhost:19000',
        'http://localhost:19001',
        'http://localhost:19002',
        // React Native Expo
        'exp://localhost:19000',
        'exp://localhost:19001',
        // Add your production mobile app domains here
    ],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['X-Requested-With', 'Content-Type', 'Accept', 'Authorization', 'X-Client-Info', 'X-API-KEY'],

    'exposed_headers' => ['X-Total-Count', 'X-Page-Current'],

    'max_age' => 86400,

    'supports_credentials' => true,
];
