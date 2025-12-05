<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPlanParticipant extends Model
{
    protected $fillable = ['travel_plan_id', 'user_id', 'role', 'status'];
}
