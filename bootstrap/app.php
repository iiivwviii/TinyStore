<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Database\QueryException;


return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'customer' => \App\Http\Middleware\CustomerMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (MethodNotAllowedHttpException $e, Request $request) {
            return response()->json([
                'error' => 'Method is not supported.'
            ], 401);
        });
        $exceptions->render(function (RouteNotFoundException $e, Request $request) {
            return response()->json([
                'error' => 'Invalid endpoint or unauthorized access.'
            ], 409);
        });
        $exceptions->render(function (ValidationException $e, Request $request) {
            return response()->json([
                'error' => $e->validator->errors()->first()
            ], 422);
        });
        $exceptions->render(function (QueryException $e, Request $request) {
            return response()->json([
                'error' => 'Table not found.'
            ], 503);
        });
    })->create();
