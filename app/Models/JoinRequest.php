<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JoinRequest extends Model
{
    protected $fillable = ['travel_plan_id', 'user_id', 'message', 'status'];
}
