<?php

namespace Database\Seeders;

use App\Models\Interest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InterestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $interests = [
            ['name' => 'Adventure', 'category' => 'Travel'],
            ['name' => 'Food & Cuisine', 'category' => 'Lifestyle'],
            ['name' => 'Culture', 'category' => 'Travel'],
            ['name' => 'Hiking', 'category' => 'Adventure'],
            ['name' => 'Photography', 'category' => 'Creative'],
            ['name' => 'Beach Relaxation', 'category' => 'Travel'],
            ['name' => 'Budget Travel', 'category' => 'Finance'],
            ['name' => 'City Exploration', 'category' => 'Urban'],
        ];

        Interest::insert($interests);
    }
}
