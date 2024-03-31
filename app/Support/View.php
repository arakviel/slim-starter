<?php

namespace Insid\Blogonslim\Support;

use Jenssegers\Blade\Blade;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ResponseFactoryInterface;

class View
{
    public Response $response;

    public function __construct(ResponseFactoryInterface $factory)
    {
        $this->response = $factory->createResponse(200, 'Success');
    }

    public function __invoke(string $template = '', array $with = []): Response
    {
        $cache = config('blade.cache');
        $views = config('blade.views');

        $blade = new Blade($views, $cache);
        $view = $blade->make($template, $with);
        $this->response->getBody()->write($view->render());

        return $this->response;
    }
}
