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
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    // 🔒 Security: CORS paths - فقط API endpoints
    'paths' => [
        'api/*',
        'sanctum/csrf-cookie',
        'storage/*',
    ],

    // 🔒 Security: Allowed methods
    'allowed_methods' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],

    // 🔒 Security: Allowed origins - تخصيص للدومينات المسموحة فقط
    'allowed_origins' => explode(',', env('CORS_ALLOWED_ORIGINS', 'http://localhost,http://127.0.0.1')),

    // استخدام patterns للدومينات الفرعية
    'allowed_origins_patterns' => [],

    // 🔒 Security: Headers المسموحة
    'allowed_headers' => [
        'Content-Type',
        'X-Requested-With',
        'Authorization',
        'Accept',
        'X-XSRF-TOKEN',
    ],

    // Headers المعروضة للمتصفح
    'exposed_headers' => [],

    // 🔒 Security: Max age لـ preflight requests (24 hours)
    'max_age' => 86400,

    // 🔒 Security: Support credentials (cookies, authorization headers)
    'supports_credentials' => true,

];
