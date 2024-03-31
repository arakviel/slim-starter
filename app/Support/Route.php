<?php

namespace Insid\Blogonslim\Support;

use Illuminate\Support\Str;
use Slim\App;

class Route
{
    public static App $app;

    public static function setup(App &$app): App
    {
        self::$app = $app;

        return $app;
    }

    public static function __callStatic($verb, $parameters)
    {
        $app = self::$app;

        [$route, $action] = $parameters;

        self::validation($route, $verb, $action);

        return is_callable($action)
            ? $app->$verb($route, $action)
            : $app->$verb($route, self::resolveViaController($action));
    }

    protected static function validation($route, $verb, $action): void
    {
        $exception = "Unresolvable Route Callback/Controller action";
        $context = json_encode(compact('route', 'action', 'verb'));
        $fails = !((is_callable($action)) or (is_string($action) and Str::is("*@*", $action)));

        throw_when($fails, $exception . $context);
    }

    public static function resolveViaController($action): array
    {
        $class = Str::before($action, '@');
        $method = Str::after($action, '@');

        $controller = config('routing.controllers.namespace') . $class;

        return [$controller, $method];
    }
}
