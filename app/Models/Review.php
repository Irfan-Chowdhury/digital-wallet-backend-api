<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'reviewer_id', 'reviewed_user_id',
        'travel_plan_id', 'rating', 'comment'
    ];
}
