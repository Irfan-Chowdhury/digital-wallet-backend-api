<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPlan extends Model
{
    protected $fillable = [
        'user_id', 'destination', 'start_date', 'end_date',
        'budget', 'travel_type', 'itinerary', 'group_size', 'status'
    ];

    protected $casts = [
        'itinerary' => 'array'
    ];

    public function host(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }
}
}
