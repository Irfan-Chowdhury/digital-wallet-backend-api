<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPlan extends Model
{
    protected $fillable = [
        'user_id',
        'destination',
        'start_date',
        'end_date',
        'budget',
        'travel_type',
        'itinerary',
        'group_size',
        'status'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function host(): BelongsTo {
        return $this->belongsTo(User::class, 'user_id');
    }

}
