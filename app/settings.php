<?php

use Psr\Container\ContainerInterface;

return function (ContainerInterface $container) {
    $container->set('settings', fn() => [
        "displayErrorDetails" => true,
        "logErrors" => true,
        "logErrorDetails" => true,
    ]);
};
