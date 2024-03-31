<?php

return [
    'name' => env('APP_NAME', 'Slim starter'),
    'providers' => [
        Insid\Blogonslim\Providers\EnvironmentVariablesServiceProvider::class,
        Insid\Blogonslim\Providers\BladeServiceProvider::class,
        Insid\Blogonslim\Providers\ErrorMiddlewareServiceProvider::class,
        Insid\Blogonslim\Providers\RouteServiceProvider::class,
    ],
];
