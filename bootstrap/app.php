<?php

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
        // Gabungkan semua pengaturan middleware di sini
        $middleware->redirectTo(
            guests: '/login',
            users: function (Request $request) {
                if ($request->user()?->role === 'admin') {
                    return route('admin.dashboard');
                }
                return route('home');
            }
        );

        // Jika kamu punya alias middleware admin, tambahkan di sini
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();