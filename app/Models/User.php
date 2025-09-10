<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Carbon\Carbon;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'role',
        'phone',
        'address',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'is_active' => 'boolean',
            'password' => 'hashed',
            'created_at' => 'datetime:Y-m-d'
        ];
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return date('Y-m-d', strtotime($value));
    // }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value);
    }

    protected function serializeDate(\DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

}
