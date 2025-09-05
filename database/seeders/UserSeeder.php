<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $data= [
[
                'name' => 'Admin User',
                'email' => 'admin123@gmail.com',
                'role' => UserRole::ADMIN->value,
                'phone' => '01710000001',
                'address' => 'Admin address, Dhaka, Bangladesh',
                'password' => Hash::make('admin123'),
                'is_active'=> true,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Normal User',
                'email' => 'user123@gmail.com',
                'role' => UserRole::USER->value,
                'phone' => '01710000002',
                'address' => 'User address, Dhaka, Bangladesh',
                'password' => Hash::make('user123'),
                'is_active'=> true,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Agent User',
                'email' => 'agent123@gmail.com',
                'role' => UserRole::AGENT->value,
                'phone' => '01710000003',
                'address' => 'Agent address, Dhaka, Bangladesh',
                'password' => Hash::make('agent123'),
                'is_active'=> true,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->delete();
        User::insert($data);

        Wallet::insert([
            [
                'user_id' => 2,
                'balance' => 50.00,
                'is_block' => false,
                'status' => 'completed'
            ],
            [
                'user_id' => 3,
                'balance' => 50.00,
                'is_block' => false,
                'status' => 'completed'
            ],
        ]);
    }
}
