<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    public function register(RegisterRequest $request, AuthService $authService)
    {
        try {
            $result = $authService->register($request->validated());

            return $this->successResponse(
                'User registered successfully',
                [
                    'token' => $result['token'],
                    'user' => new UserResource($result['user']),
                ],
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse('Registration failed : '.$e->getMessage(), 500);
        }
    }

    public function login(LoginRequest $request, AuthService $authService)
    {
        try {
            $result = $authService->login($request->validated());

            return $this->successResponse(
                'Login successful.',
                [
                    'token' => $result['token'],
                    'user' => new UserResource($result['user']),
                ],
                200
            );

        } catch (Exception $e) {
            $statusCode = $e->getCode() === 401 ? 401 : 500;

            return $this->errorResponse('Login failed: '.$e->getMessage(), $statusCode);
        }
    }

    public function logout(Request $request, AuthService $authService): JsonResponse
    {
        try {
            $user = $request->user();

            if ($user && $user->currentAccessToken()) {
                $user->currentAccessToken()->delete();
            }
            return $this->successResponse('Logged out successfully', [], 200);
        } catch (Exception $e) {
            return $this->errorResponse('Logout failed: '.$e->getMessage(), 500);
        }
    }
}
