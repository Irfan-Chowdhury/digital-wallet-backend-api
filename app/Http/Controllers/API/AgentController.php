<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class AgentController extends BaseController
{
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
}
