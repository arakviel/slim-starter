<?php

namespace Insid\Blogonslim\Http\Containers;

use Insid\Blogonslim\Persistence\Entity\Post;
use Insid\Blogonslim\Persistence\Entity\User;
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

        $user = new User();
        $user->id = 11;
        $user->login = 'user12';
        $user->password = 'password1';
        $user->age = 20;
        $user->save();

        $users = $user->getAll();

        return view($response, 'home.index', compact('hello', 'users', 'post'));
    }
}
