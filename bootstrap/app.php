<?php

use App\Http\Middleware\Auth\JwtAuthMiddleware;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'jwt.auth' => JwtAuthMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // $exceptions->renderable(function (ModelNotFoundException $e, $request) {
        //     if ($request->expectsJson()) {
        //         return response()->json([
        //             'message' => 'Ресурс не найден',
        //             'errors' => [
        //                 'id' => ['Товар с указанным ID не существует']
        //             ]
        //         ], Response::HTTP_NOT_FOUND);
        //     }
        // });
    })->create();
