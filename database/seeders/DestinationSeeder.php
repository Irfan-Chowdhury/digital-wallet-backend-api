<?php

namespace Database\Seeders;

use App\Models\Destination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DestinationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('destinations')->truncate();

        $destinations = [
            [
                'name' => 'Bangkok',
                'country' => 'Thailand',
                'image_url' => 'https://images.unsplash.com/photo-1508009603885-50cf7c579365?w=800',
                'active_travelers' => 234,
            ],
            [
                'name' => 'Paris',
                'country' => 'France',
                'image_url' => 'https://images.unsplash.com/photo-1502602898657-3e91760cbb34?w=800',
                'active_travelers' => 189,
            ],
            [
                'name' => 'Tokyo',
                'country' => 'Japan',
                'image_url' => 'https://images.unsplash.com/photo-1540959733332-eab4deabeeaf?w=800',
                'active_travelers' => 312,
            ],
            [
                'name' => 'Barcelona',
                'country' => 'Spain',
                'image_url' => 'https://images.unsplash.com/photo-1583422409516-2895a77efded?w=800',
                'active_travelers' => 156,
            ],
            [
                'name' => 'Bali',
                'country' => 'Indonesia',
                'image_url' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
                'active_travelers' => 278,
            ],
            [
                'name' => 'New York',
                'country' => 'USA',
                'image_url' => 'https://images.unsplash.com/photo-1496442226666-8d4d0e62e6e9?w=800',
                'active_travelers' => 201,
            ],
        ];

        Destination::insert($destinations);

    }
}
