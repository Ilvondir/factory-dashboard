<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\RedirectToErrorIf403;
use App\Http\Middleware\RedirectToErrorIf404;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withBroadcasting(
        __DIR__ . '/../routes/channels.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
            RedirectToErrorIf403::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
