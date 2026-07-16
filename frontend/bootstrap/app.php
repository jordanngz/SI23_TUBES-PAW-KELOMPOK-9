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
        $middleware->alias([
            'auth' => \App\Http\Middleware\RedirectIfUnauthenticated::class,
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
        
        // Append FrontendAuth to the web group to dynamically populate Auth::user() from session on every web request
        $middleware->appendToGroup('web', \App\Http\Middleware\FrontendAuth::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
