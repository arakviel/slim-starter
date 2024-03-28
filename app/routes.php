<?php

use Insid\Blogonslim\Http\Containers\HomeController;
use Slim\App;

return function (App $app) {
    $app->get('/', [HomeController::class, 'index']);
    $app->get('/{name}', [HomeController::class, 'show']);
};
