<?php

namespace Insid\Blogonslim\Http\Controllers;

use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Str;
use Insid\Blogonslim\Models\User;
use Insid\Blogonslim\Support\View;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
    public function index(Manager $db, View $view, Response $response, $args = []): Response
    {
        Str::

        $hello = "Привіт Чернівці! з контролера";
        //$users = $db->table('users')->get();
        $petro = User::query()
            ->where('age', '>', 19)
            ->first();
        $petro->age = 50;
        $petro->save();
        dd($petro);
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
