<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use Exception;
use Illuminate\Http\Request;

class TransactionController extends BaseController
{
    public function userOrAgentTransactionHistory(TransactionService $transactionService)
    {
        try {
            $transactions = $transactionService->geyUserOrAgentTransaction();

            return $this->successResponse(
                'Transaction Retrieve successfully',
                TransactionResource::collection($transactions),
                201
            );

        } catch (Exception $e) {
            return $this->errorResponse('Retrieve failed : '.$e->getMessage(), $e->getCode() ?: 500);
        }
    }
}
