<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlanBooking extends Model
{
    protected $fillable = [
        'travel_plan_id',
        'user_id',
        'seats',
        'price_per_seat',
        'currency',
        'total_amount',
        'payment_status',
        'status',
    ];

}
