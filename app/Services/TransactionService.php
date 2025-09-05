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

class TransactionService
{
    public function geyUserTransaction()
    {
        return Transaction::where('user_id', auth()->user()->id)->get();
    }

}
