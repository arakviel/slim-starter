<?php

namespace Insid\Blogonslim\Http\Containers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function index(Request $request, Response $response, $args = []): Response
    {
        $hello = "Привіт Чернівці! з контролера";
        return view($response, 'home.index', compact('hello'));
    }

    public function show(Request $request, Response $response, $name): Response
    {
        $hello = "Привіт Чернівці! з контролера url-path: $name";
        return view($response, 'home.index', compact('hello'));
    }
}
