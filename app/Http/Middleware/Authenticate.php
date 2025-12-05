<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request): ?string
    {
        if (! $request->expectsJson()) {
            abort(response()->json([
                'statusCode' => 401,
                'success' => false,
                'message' => 'Authentication required',
                'errors' => ['auth' => ['You must be logged in to access this resource.']],
            ], 401));
        }

        return null;
    }
}
