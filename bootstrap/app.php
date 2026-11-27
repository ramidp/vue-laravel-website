<?php

use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

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

        // Public pages use /login. The Filament panel has its own login at /admin/login.
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return '/admin/login';
            }

            return '/login';
        });

        // A signed-in visitor who opens a guest page goes to their account,
        // except on the backoffice, where they go to the dashboard.
        $middleware->redirectUsersTo(function (Request $request) {
            if ($request->is('admin') || $request->is('admin/*')) {
                return '/admin';
            }

            return '/account';
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
