<?php

namespace Insid\Blogonslim\Providers;

use Illuminate\Database\Capsule\Manager;
use Insid\Blogonslim\Support\DB;
use Insid\Blogonslim\Support\View;

class EloquentServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->getContainer()->set(
            Manager::class,
            function () {
                $capsule = new Manager();
                $capsule->addConnection(config('database.db'));
                $capsule->setAsGlobal();
                $capsule->bootEloquent();
                return $capsule;
            }
        );
    }

    public function boot(): void
    {
    }
}