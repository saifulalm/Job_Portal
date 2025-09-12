<?php

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
        // THIS IS THE NEW LOCATION FOR MIDDLEWARE ALIASES
        $middleware->alias([
            'is.admin' => \App\Http\Middleware\IsAdmin::class,
            'is.company' => \App\Http\Middleware\IsCompany::class,
            'is.employee' => \App\Http\Middleware\IsEmployee::class,
        ]);

        // You can also add global middleware here, or middleware groups.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
