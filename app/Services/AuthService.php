<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function register(array $data): array
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password']);

            $user = User::create($data);

            Wallet::create([
                'user_id' => $user->id,
                'balance' => 50.00,
                'is_block' => false
            ]);

            return [
                'token' => $user->createToken('dw_token')->plainTextToken,
                'user' => $user,
            ];
        });
    }

    public function login(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            throw new Exception('Invalid credentials', 401);
        }

        $user = Auth::user();
        $token = $user->createToken('dw_token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function logout($user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function profileUpdate(array $data, int $userId)
    {
        return DB::transaction(function () use ($data, $userId) {

            $user = User::find($userId);

            $user->update($data);

            return $user;
        });
    }
}
