<?php

declare(strict_types=1);

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$settings = require_once __DIR__ . '/../app/settings.php';
$settings($container);

$app = SlimAppFactory::create($container);

$middlewares = require_once __DIR__ . '/../app/middlewares.php';
$middlewares($app);

$routes = require_once __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();
