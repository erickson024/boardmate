<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\Authenticated;
use App\Http\Middleware\Guest;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'auth.custom' => Authenticated::class,
            'guest.custom' => Guest::class,
            'role' => RoleMiddleware::class,
        ]);
    })
 
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
