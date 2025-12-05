<?php

namespace App\Http\Middleware;

use App\Enum\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!$request->user() || $request->user()->role !== UserRole::tryFrom($role)?->value) {
            return response()->json([
                'statusCode' => 403,
                'success' => false,
                'message' => 'Forbidden',
                'errors' => [
                    'authorization' => ['You do not have permission to access this resource.']
                ],
            ], 403);
        }

        return $next($request);
    }
}


