<?php

use App\Http\Middleware\HandleInertiaRequests;
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
        // Inertia: shares props (auth user, flash) and handles Inertia requests
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);

        // Where the 'auth' middleware sends visitors who are not logged in
        $middleware->redirectGuestsTo('/login');

        // Where the 'guest' middleware sends users who are already logged in
        $middleware->redirectUsersTo('/account');
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
