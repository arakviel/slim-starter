<?php

namespace Insid\Blogonslim\Http\Controllers;

use Insid\Blogonslim\Persistence\Entity\Post;
use Insid\Blogonslim\Persistence\Entity\User;
use Insid\Blogonslim\Support\View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function index(View $view, Response $response, $args = []): Response
    {
        $hello = "Привіт Чернівці! з контролера";
        return $view('home.index', compact('hello'));
    }

    public function show(View $view, Response $response, $name): Response
    {
        $hello = "Привіт Чернівці! з контролера url-path: $name";

        $user = new User();
        $user->id = 11;
        $user->login = 'user12';
        $user->password = 'password1';
        $user->age = 20;
        $user->save();

        $users = $user->getAll();

        return $view('home.index', compact('hello', 'users', 'post'));
    }
}
