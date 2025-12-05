<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'plan_booking_id', 'user_id', 'provider', 'provider_charge_id',
        'amount', 'currency', 'status', 'payment_method', 'meta'
    ];

    protected $casts = [
        'meta' => 'array'
    ];
}
