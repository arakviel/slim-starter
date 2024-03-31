<?php

namespace Insid\Blogonslim\Providers;

use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

class ErrorMiddlewareServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (env('APP_DEBUG', false)) {
            $this->app->add(new WhoopsMiddleware());
        }
    }

    public function boot(): void
    {
        //
    }
}
