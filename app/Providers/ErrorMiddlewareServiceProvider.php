<?php

namespace Insid\Blogonslim\Providers;

use Zeuxisoo\Whoops\Slim\WhoopsMiddleware;

class ErrorMiddlewareServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->add(new WhoopsMiddleware());
        /*        $this->app->addErrorMiddleware(
                    config('middleware.error_details.displayErrorDetails'),
                    config('middleware.error_details.logErrors'),
                    config('middleware.error_details.logErrorDetails')
                );*/
    }

    public function boot(): void
    {
        //
    }
}
