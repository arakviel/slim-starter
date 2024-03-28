<?php

declare(strict_types=1);

use DI\Container;
use Slim\Factory\AppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$settings = require_once __DIR__ . '/../app/settings.php';
$settings($container);
AppFactory::setContainer($container);

$app = AppFactory::create();

$middlewares = require_once __DIR__ . '/../app/middlewares.php';
$middlewares($app);

$routes = require_once __DIR__ . '/../app/routes.php';
$routes($app);

$app->run();
