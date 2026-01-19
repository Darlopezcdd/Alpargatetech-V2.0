<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registramos el alias para usarlo en las rutas
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            '2fa' => \App\Http\Middleware\EnsureTwoFactorIsVerified::class, // Registra el tuyo aquí
        ]);

        // Aplicar 2FA a todas las rutas web excepto login/logout
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureTwoFactorIsVerified::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();


