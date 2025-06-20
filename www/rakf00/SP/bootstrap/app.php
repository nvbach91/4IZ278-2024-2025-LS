<?php

use App\Http\Middleware\Authenticated;
use App\Http\Middleware\CheckIdentity;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        // Přidat pouze do web routes
        $middleware->web(append: [
            \App\Http\Middleware\StoreReturnUrl::class,
        ]);

        // Aliasy pro použití v routách
        $middleware->alias([
            'auth' => Authenticated::class,
            'role' => CheckRole::class,
            'identity' => CheckIdentity::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
