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

    private function isInsufficientBalance(float $remainingBalance, float $requestAmount)
    {
        if ($remainingBalance < $requestAmount) {
            throw new Exception("Insufficient balance", 422);
        }
    }



}
