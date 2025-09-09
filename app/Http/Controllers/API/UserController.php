<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\ProfileRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;


class UserController extends BaseController
{

    public function dashboard()
    {
        try {
            $wallet = Wallet::where('user_id', auth()->user()->id)->first();

            $depositTotal = $wallet->transactions()->where('type', 'deposit')->sum('amount');
            $withdrawTotal = $wallet->transactions()->where('type', 'withdraw')->sum('amount');
            $sendMoneyTotal = $wallet->transactions()->where('type', 'send-money')->sum('amount');


            $data = [
                'walletRemainingBalance' => $wallet->balance,
                'deposit' => $depositTotal,
                'withdraw' => $withdrawTotal,
                'sendMoney' => $sendMoneyTotal,
            ];

            return $this->successResponse(
            'Data retrieved successfully',
            $data,
            200
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve users: '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }

    public function AgentDashboard()
    {
        try {

            $wallet = Wallet::with(['transactions' => fn($q) => $q
                ->select('id', 'wallet_id', 'type', 'amount', 'from', 'to', DB::raw("DATE_FORMAT(created_at, '%Y-%m-%d') as created_at"))
                ->orderBy('id','DESC')->limit(10)
            ])
            ->where('user_id', auth()->id())
            ->first();


            $cashInTotal = $wallet->transactions()->where('type', 'cash-in')->sum('amount');
            $cashOutTotal = $wallet->transactions()->where('type', 'cash-out')->sum('amount');


            $data = [
                'walletRemainingBalance' => (float)$wallet->balance,
                'cashIn' => (float)$cashInTotal,
                'cashOut' => (float)$cashOutTotal,
                'transactions' => $wallet->transactions->map(function ($row) {
                    $userId = $row->type==='cash-in' ? (int)$row->to : (int) $row->from;

                    return [
                        'id' => $row->id,
                        'type' => $row->type,
                        'amount' => $row->amount,
                        'created_at' => $row->created_at->format('Y-m-d'), // formatted date
                        'userPhone' => User::find($userId)->phone
                    ];
                })
            ];

            return $this->successResponse(
            'Data retrieved successfully',
            $data,
            200
            );
        } catch (Exception $e) {
            return $this->errorResponse('Failed to retrieve users: '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }

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
