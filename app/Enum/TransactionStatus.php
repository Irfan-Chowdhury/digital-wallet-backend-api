<?php

namespace App\Enum;

enum TransactionStatus: string
{
    case COMPLETED = 'completed';
    case CONFIRMED = 'confirmed';
    case CANCELLED = 'cancelled';
}