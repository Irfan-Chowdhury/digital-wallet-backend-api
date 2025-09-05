<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ProfileRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class UserController extends BaseController
{
    public function index()
    {
        try {
            $users = User::where('role', "USER")->get();

            return $this->successResponse(
                'User retrieved successfully',
                UserResource::collection($users),
                200
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve users: '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }

    public function getAllAgents()
    {
        try {
            $users = User::where('role', "AGENT")->get();

            return $this->successResponse(
                'Agent retrieved successfully',
                UserResource::collection($users),
                200
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve users: '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }

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
            Log::error('Registration error: '.$e->getMessage(), ['exception' => $e]);

            return $this->errorResponse('Registration failed : '.$e->getMessage(), 500);
        }
    }

    public function statusChange($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active; // flip value
        $user->save();

        return $this->successResponse(
            'User status updated successfully',
            new UserResource($user),
            201
        );
    }

    public function profile(Request $request)
    {
        try {
            $user = auth()->user();

            return $this->successResponse(
                'Profile retrive succesfully',
                new UserResource($user),
                200
            );

        } catch (Exception $e) {
            return $this->errorResponse('failed: '.$e->getMessage(), 500);
        }
    }


    public function profileUpdate(ProfileRequest $request, AuthService $authService)
    {
        try {
            $user = $authService->profileUpdate($request->validated(), auth()->user()->id);

            return $this->successResponse(
                'Profile updated succesfully',
                new UserResource($user),
                200
            );

        } catch (Exception $e) {
            return $this->errorResponse('failed: '.$e->getMessage(), 500);
        }
    }
}
