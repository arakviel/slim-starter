<?php

declare(strict_types=1);

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;
use Insid\Blogonslim\Providers\ServiceProvider;

$app = SlimAppFactory::create(new Container());

ServiceProvider::setup($app, config('app.providers'));

return $app;
