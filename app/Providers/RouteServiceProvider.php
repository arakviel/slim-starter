<?php

namespace Insid\Blogonslim\Providers;

use Insid\Blogonslim\Support\Route;

class RouteServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        Route::setup($this->app);
    }

    public function boot(): void
    {
        $app = $this->app;
        require_once routes_path('web.php');
    }
}
