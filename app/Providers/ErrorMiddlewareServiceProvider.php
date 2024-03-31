<?php

namespace Insid\Blogonslim\Providers;

class ErrorMiddlewareServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->addErrorMiddleware(
            config('middleware.error_details.displayErrorDetails'),
            config('middleware.error_details.logErrors'),
            config('middleware.error_details.logErrorDetails')
        );
    }

    public function boot(): void
    {
        //
    }
}
