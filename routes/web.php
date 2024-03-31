<?php

global $app;

use Insid\Blogonslim\Http\Controllers\HomeController;
use Insid\Blogonslim\Support\Route;

/*Route::get('/', [HomeController::class, 'index']);
Route::get('/{name}', [HomeController::class, 'show']);*/

//$app->get('/', [HomeController::class, 'index']);
Route::get('/', 'HomeController@index');
Route::get('/{name}', 'HomeController@show');
