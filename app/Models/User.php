<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'image_url',
        'cover_url',
        'location',
        'age',
        'bio',
        'rating_avg',
        'rating_count'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile(){
        // return $this->hasOne(UserProfile::class);
    }

    // public function interests(): HasMany {
    //     return $this->hasMany(UserInterest::class);
    // }

    public function interests()
    {
        return $this->belongsToMany(
            Interest::class,
            'user_interests',
            'user_id',
            'interest_id'
        );
    }


    public function travelPlans() {
        // return $this->hasMany(TravelPlan::class);
    }

    public function bookings() {
        return $this->hasMany(PlanBooking::class);
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
