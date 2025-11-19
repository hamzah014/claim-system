<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
                __DIR__ . '/../routes/web.php',
            ],
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth' => \App\Http\Middleware\RedirectAuth::class,
            'authAdmin' => \App\Http\Middleware\RedirectAuthAdmin::class,
            'admin' => \App\Http\Middleware\AuthenticateAdmin::class,
            'staff' => \App\Http\Middleware\AuthenticateUser::class,
        ]);
    })
    ->withCommands([
        __DIR__.'/../app/Console/Commands',
    ])
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();