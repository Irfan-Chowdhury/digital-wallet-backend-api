<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model
{
    protected $fillable = ['name', 'category'];

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'user_interests',
            'interest_id',
            'user_id'
        );
    }

}
