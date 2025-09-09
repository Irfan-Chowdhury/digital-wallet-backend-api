<?php

namespace App\Http\Controllers\API;

use App\Enum\TransactionStatus;
use App\Enum\TransactionType;
use App\Http\Requests\Wallet\CashInRequest;
use App\Http\Requests\Wallet\CashOutRequest;
use App\Http\Requests\Wallet\WalletSendRequest;
use App\Http\Requests\Wallet\WalletWithdrawRequest;
use App\Http\Requests\Wallet\WalletDepositRequest;
use App\Http\Resources\WalletResource;
// use App\Http\Requests\WalletDepositRequest;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\WalletService;
use Exception;
use Illuminate\Http\Request;

class WalletController extends BaseController
{
    public function addMoney(WalletDepositRequest $request, WalletService $walletService)
    {
        try {
            $wallet = $walletService->depositMoney($request->validated());

            return $this->successResponse(
                'Money Deposit successfully',
                new WalletResource($wallet),
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse('Add Money failed : '.$e->getMessage(), 500);
        }
    }


    public function withdrawMoney(WalletWithdrawRequest $request, WalletService $walletService)
    {

        try {
            $wallet = $walletService->withdrawMoney($request->validated());

            return $this->successResponse(
                'Money Withdraw successfully',
                new WalletResource($wallet),
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse('Withdraw failed : '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }

    public function sendMoney(WalletSendRequest $request, WalletService $walletService)
    {

        try {
            $wallet = $walletService->sendMoney($request->validated());

            return $this->successResponse(
                'Money Send successfully',
                new WalletResource($wallet),
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse('Sending failed : '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }

    public function cashIn(CashInRequest $request, WalletService $walletService)
    {
        try {
            $wallet = $walletService->cashIn($request->validated());

            return $this->successResponse(
                'Cash In successfully',
                // new WalletResource($wallet),
                $wallet,
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse('Sending failed : '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }

    public function cashOut(CashOutRequest $request, WalletService $walletService)
    {
        try {
            $wallet = $walletService->cashOut($request->validated());

            return $this->successResponse(
                'Cash Out successfully',
                // new WalletResource($wallet),
                $wallet,
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse('Sending failed : '.$e->getMessage(), (int)$e->getCode() ?: 500);
        }
    }

}
