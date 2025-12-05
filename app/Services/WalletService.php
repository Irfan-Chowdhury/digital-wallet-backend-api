<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Enum\TransactionStatus;
use App\Enum\TransactionType;

class WalletService
{

    public function depositMoney(array $data)
    {
        return DB::transaction(function () use ($data)  {
            $wallet = Wallet::where('user_id', auth()->user()->id)->firstOrFail();
            $wallet->balance += $data['amount'];
            $wallet->update();

            $data = [
                'wallet_id' => $wallet->id,
                'user_id' => auth()->user()->id,
                'from' => $data['from'],
                "to" => auth()->user()->id,
                "amount" => $data['amount'],
                "type" => TransactionType::DEPOSIT,
                "status" => TransactionStatus::COMPLETED,
            ];

            Transaction::create($data);

            // attach "from" temporarily (not saved in DB)
            $wallet->setAttribute('from', $data['from']);

            return $wallet;
        });
    }


    public function withdrawMoney(array $data)
    {
        return DB::transaction(function () use ($data)  {
            $wallet = Wallet::with([
                'transactions' => fn($q) => $q->latest()->limit(1),
                'user:id,name,email,phone,address'
                ])
            ->where('user_id', auth()->user()->id)->firstOrFail();

            if ($wallet->balance < $data['amount']) {
                throw new Exception("Insufficient balance", 422);
            }

            $wallet->balance -= $data['amount'];
            $wallet->update();

            $data = [
                'wallet_id' => $wallet->id,
                'user_id' => auth()->user()->id,
                'from' => auth()->user()->id,
                "to" => $data['to'],
                "amount" => $data['amount'],
                "type" => TransactionType::WITHDRAW,
                "status" => TransactionStatus::COMPLETED,
            ];

            Transaction::create($data);

            return $wallet;
        });
    }

    public function sendMoney(array $data)
    {
        return DB::transaction(function () use ($data)  {

            $senderWallet = Wallet::with(['transactions' => fn($q) => $q->latest()->limit(1)])
                                ->where('user_id', auth()->user()->id)
                                ->firstOrFail();

            $this->isInsufficientBalance((float)$senderWallet->balance, (float)  $data['amount']);


            $receiverUser = User::where('phone', $data['receiver_phone'])->first();
            if (!$receiverUser || !$receiverUser->wallet) {
                throw new Exception("No Wallet Found", 422);
            }

            $senderWallet->balance -= $data['amount'];
            $receiverUser->wallet->balance -= $data['amount'];


            $senderWallet->update();
            $receiverUser->wallet->save();


            $data = [
                'wallet_id' => $senderWallet->id,
                'user_id' => auth()->user()->id,
                'from' => auth()->user()->id,
                "to" => $receiverUser->id,
                "amount" => $data['amount'],
                "type" => TransactionType::SENDMONEY,
                "status" => TransactionStatus::COMPLETED,
            ];

            Transaction::create($data);

            return $senderWallet;
        });
    }

    public function cashIn(array $data)
    {
        $agentId = auth()->id();
        $amount = $data['amount'];
        $receiverPhone = $data['receiver_phone'];

        return DB::transaction(function () use ($agentId, $amount, $receiverPhone) {
            // Agent wallet
            $agentWallet = Wallet::where('user_id', $agentId)->first();
            if (!$agentWallet) {
                throw new Exception('Wallet not found', 404);
            }

            // Receiver user + wallet
            $receiverUser = User::where('phone', $receiverPhone)->first();
            if (!$receiverUser) {
                throw new Exception('Receiver not found', 404);
            }

            $receiverWallet = Wallet::where('user_id', $receiverUser->id)->first();
            if (!$receiverWallet) {
                throw new Exception('Receiver wallet not found', 404);
            }

            // Balance check
            if ($agentWallet->balance < $amount) {
                throw new Exception('Insufficient balance', 400);
            }

            Transaction::create([
                'wallet_id' => $agentWallet->id,
                'user_id' => $agentId,     
                'from'    => $agentId,
                'to'      => $receiverUser->id,
                'type'    => 'cash-in',
                'amount'  => $amount,
                'status'  => 'completed',
            ]);

            // ✅ Update balances atomically
            $agentWallet->decrement('balance', $amount);
            $receiverWallet->increment('balance', $amount);


            // ✅ Return fresh balances with user relation
            return [
                'agent' => $agentWallet->fresh(['user:id,name,email,phone,address']),
                'receiver' => $receiverWallet->fresh(['user:id,name,email,phone,address']),
            ];
        });
    }


    public function cashOut(array $data)
    {
        $agentId = auth()->id(); // current logged-in agent
        $amount = $data['amount'];
        $userPhone = $data['user_phone']; // 👈 replaced receiver_phone with user_phone

        return DB::transaction(function () use ($agentId, $amount, $userPhone) {
            // ✅ Step 1: Find the user by phone
            $user = User::where('phone', $userPhone)->first();
            if (!$user) {
                throw new Exception('User not found', 404);
            }

            // ✅ Step 2: Find user wallet
            $userWallet = Wallet::where('user_id', $user->id)->first();
            if (!$userWallet) {
                throw new Exception('User wallet not found', 404);
            }

            // ✅ Step 3: Check balance
            if ($userWallet->balance < $amount) {
                throw new Exception('Insufficient balance', 422);
            }

            // ✅ Step 4: Find agent wallet
            $agentWallet = Wallet::where('user_id', $agentId)->first();
            if (!$agentWallet) {
                throw new Exception('Agent wallet not found', 404);
            }

            // ✅ Step 5: Update balances atomically
            $userWallet->decrement('balance', $amount);
            $agentWallet->increment('balance', $amount);

            // ✅ Step 6: Record transaction (optional, if you track it)
            Transaction::create([
                'wallet_id' => $agentWallet->id,
                'user_id' => $agentId,     // Agent performed the cash-out
                'from'    => $user->id,    // Money deducted from user
                'to'      => $agentId,     // Money sent to agent
                'type'    => 'cash-out',
                'amount'  => $amount,
                'status'  => 'completed',
            ]);

            // ✅ Step 7: Return updated wallets with relations
            return [
                'agent' => $agentWallet->fresh(['user:id,name,email,phone,address']),
                'user'  => $userWallet->fresh(['user:id,name,email,phone,address']),
            ];
        });
    }





    private function isInsufficientBalance(float $remainingBalance, float $requestAmount)
    {
        if ($remainingBalance < $requestAmount) {
            throw new Exception("Insufficient balance", 422);
        }
    }



}
