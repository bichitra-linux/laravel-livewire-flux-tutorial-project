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

        $middleware->web(append: [
            
            \App\Http\Middleware\SecurityHeaders::class,
        ]);
        $middleware->alias([
            'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
            'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
            'user.only' => \App\Http\Middleware\UserOnly::class,
            'admin.only' => \App\Http\Middleware\AdminOnly::class,
            'password.confirm' => \App\Http\Middleware\RequirePasswordConfirmation::class,
            'track.views' => \App\Http\Middleware\TrackPageViews::class,
        ]);

        $middleware->trustProxies(
            at: '*', // Trust all proxies (safe for local development with ngrok)
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
