<?php

namespace Insid\Blogonslim\Providers;

use Dotenv\Dotenv;
use Dotenv\Exception\InvalidPathException;

class EnvironmentVariablesServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        try {
            $env = Dotenv::createImmutable(base_path());
            $env->load();
        } catch (InvalidPathException $e) {
        }
    }

    public function boot(): void
    {
        //
    }
}