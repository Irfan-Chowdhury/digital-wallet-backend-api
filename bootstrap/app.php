<?php

use App\Exceptions\Handler;
use App\Http\Middleware\Authenticate;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Middleware\RoleMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'auth' => Authenticate::class,
            'role' => RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Authentication errors (401 Unauthorized)
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return response()->json([
                'statusCode' => 401,
                'success' => false,
                'message' => 'Authentication required',
                'errors'  => ['auth' => ['You must be logged in to access this resource.']],
            ], 401);
        });

        // Authorization errors (403 Forbidden)
        $exceptions->renderable(function (AuthorizationException $e, $request) {
            return response()->json([
                'statusCode' => 403,
                'success' => false,
                'message' => 'Forbidden',
                'errors'  => ['authorization' => ['You do not have permission to access this resource.']],
            ], 403);
        });


        // Model not found errors
        $exceptions->renderable(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'statusCode' => 404,
                'success' => false,
                'message' => 'Resource not found',
                'errors'  => ['resource' => ['The requested resource does not exist.']],
            ], 404);
        });

        // Validation errors (422 Unprocessable Entity)
        $exceptions->renderable(function (ValidationException $e, $request) {
            return response()->json([
                'statusCode' => 422,
                'success' => false,
                'message' => 'Validation Error',
                'errors'  => $e->errors(),
            ], 422);
        });


        // All other errors
        // $exceptions->renderable(function (\Throwable $e, $request) {
        //     if ($e instanceof \Illuminate\Auth\AuthenticationException ||
        //         $e instanceof \Illuminate\Auth\Access\AuthorizationException) {
        //         return null;
        //     }

        //     return response()->json([
        //         'statusCode' => 500,
        //         'success' => false,
        //         'message' => 'Server Error',
        //         'errors'  => [$e->getMessage()],
        //     ], 500);
        // });

    })->create();
