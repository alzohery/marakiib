<?php

// return [
//     'paths' => ['api/*'],
//     'allowed_methods' => ['*'],
//     // 'allowed_origins' => ['http://localhost:3001'], // أو * لو مش فارقة
//     'allowed_origins' => [ 'http://localhost:3001', 'http://localhost:3000', 'https://marakiib-14.vercel.app', 'https://marakiib.com'], // أو * لو مش فارقة
//     'allowed_origins_patterns' => [],
//     'allowed_headers' => ['*'],
//     'exposed_headers' => [],
//     'max_age' => 0,
//     'supports_credentials' => false,
// ];

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // اسمح مؤقتاً بأي origin
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // لازم تبقى true مع Sanctum
];

