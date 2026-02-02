<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\URL; // Importante para el esquema HTTPS

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Configuramos los Proxies de confianza (Vital para Koyeb)
        $middleware->trustProxies(at: '*');

        // 2. Registramos todos tus alias en un solo bloque
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            '2fa' => \App\Http\Middleware\EnsureTwoFactorIsVerified::class,
        ]);

        // 3. Aplicar 2FA al grupo web
        $middleware->appendToGroup('web', \App\Http\Middleware\EnsureTwoFactorIsVerified::class);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })
    ->booting(function () {
        // 4. Forzamos HTTPS si estamos en producción
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    })
    ->create();