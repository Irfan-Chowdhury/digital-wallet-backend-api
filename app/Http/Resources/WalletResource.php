<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'  => $this->id,
            // 'user_id'  => $this->user_id,
            'remainingBalance'  => $this->balance,
            'isBlock' => $this->is_block,
            'status'  => $this->status,
            'user' => new UserResource($this->user),
            'transactions' => new TransactionResource($this->transactions[0])
        ];
    }
}
