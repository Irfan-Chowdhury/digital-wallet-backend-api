<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    // public function toArray(Request $request): array
    // {
    //     return [
    //         'id'  => $this->id,
    //         'sendFrom'  => $this->from,
    //         // 'sendTo'  => $this->to,
    //         'recipient'  => $this->to,
    //         'amount'  => $this->amount,
    //         'type'  => $this->type,
    //         'createdAt' => $this->created_at->toDateString()
    //     ];
    // }

    public function toArray(Request $request): array
    {
        $recipient = $this->to;
        $type = $this->type;

        if (is_numeric($recipient)) {
            if ($type === 'deposit') {
                // Deposit to self
                $recipientData = 'self';
            } else {
                // Lookup user
                $user = User::select('id','name','email','phone')->find($recipient);
                $recipientData = $user ? $user->only(['id','name','email','phone']) : null;
            }
        } else {
            // Non-numeric → keep as string
            $recipientData = $recipient;
        }


        return [
            'id'        => $this->id,
            'sendFrom'  => $this->from,
            'recipient' => $recipientData,
            'amount'    => $this->amount,
            'type'      => $this->type,
            'createdAt' => $this->created_at->toDateString(),
        ];
    }
}
