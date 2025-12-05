<?php

namespace Database\Seeders;

use App\Models\Interest;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopTravelersSeeder extends Seeder
{
    /**
     * php artisan db:seed --class=TopTravelersSeeder

     */
    public function run(): void
    {
            $travelers = [
                [
                    'name' => 'Sarah Chen',
                    'email' => 'sarah@example.com',
                    'password' => bcrypt('password'),
                    'location' => 'San Francisco, USA',
                    'avatar_url' => 'https://i.pravatar.cc/300?img=5',
                    'bio' => 'Adventure lover & foodie traveler.',
                    'rating_avg' => 4.9,
                    'rating_count' => 47,
                ],
                [
                    'name' => 'Amina Rahman',
                    'email' => 'amina@example.com',
                    'password' => bcrypt('password'),
                    'location' => 'Dhaka, Bangladesh',
                    'avatar_url' => 'https://i.pravatar.cc/300?img=11',
                    'bio' => 'Culture explorer. Loves coffee & museums.',
                    'rating_avg' => 4.8,
                    'rating_count' => 35,
                ],
                [
                    'name' => 'Lucas Martinez',
                    'email' => 'lucas@example.com',
                    'password' => bcrypt('password'),
                    'location' => 'Barcelona, Spain',
                    'avatar_url' => 'https://i.pravatar.cc/300?img=22',
                    'bio' => 'Adventure photographer & world traveler.',
                    'rating_avg' => 4.7,
                    'rating_count' => 52,
                ],
                [
                    'name' => 'Hannah Lee',
                    'email' => 'hannah@example.com',
                    'password' => bcrypt('password'),
                    'location' => 'Seoul, South Korea',
                    'avatar_url' => 'https://i.pravatar.cc/300?img=15',
                    'bio' => 'Budget traveler — Asia & Europe.',
                    'rating_avg' => 4.6,
                    'rating_count' => 28,
                ],
            ];

                foreach ($travelers as $t) {
                    $user = User::create($t);

                    // attach random interests
                    $interestIds = Interest::inRandomOrder()->take(3)->pluck('id');
                    $user->interests()->attach($interestIds);
                }
    }
}
