<?php

namespace Insid\Blogonslim\Providers;

use Slim\App;

abstract class ServiceProvider
{
    public App $app;

    final public function __construct(App &$app)
    {
        $this->app = $app;
    }

    final public static function setup(App &$app, array $providers)
    {
        $providers = array_map(fn($provider) => new $provider($app), $providers);

        array_walk($providers, fn(ServiceProvider $provider) => $provider->register());
        array_walk($providers, fn(ServiceProvider $provider) => $provider->boot());
    }

    abstract public function register(): void;

    abstract public function boot(): void;
}
