<?php

return [
    'name' => env('APP_NAME', 'Inkwell'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'UTC',
    'locale' => 'en',
    'key' => env('APP_KEY', 'base64:' . base64_encode(random_bytes(32))),
    'cipher' => 'AES-256-CBC',
    'providers' => [
        App\Providers\AppServiceProvider::class,
    ],
    'aliases' => [
        'Arr' => Illuminate\Support\Arr::class,
        'Str' => Illuminate\Support\Str::class,
    ],
];
