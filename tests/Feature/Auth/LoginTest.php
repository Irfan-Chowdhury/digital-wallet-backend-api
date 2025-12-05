<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'name' => 'Irfan Chowdhury',
        'email' => 'john@example.com',
        'password' => Hash::make('password123'),
        'role' => 'customer',
    ]);
});



it('logs in successfully with correct credentials', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'john@example.com',
        'password' => 'password123',
    ]);

    $response->assertStatus(200)
             ->assertJsonStructure([
                 'statusCode',
                 'success',
                 'message',
                 'data' => [
                     'token',
                     'user' => [
                         'id',
                         'name',
                         'email',
                         'role',
                         'created_at',
                     ]
                 ]
             ])
             ->assertJson([
                 'success' => true,
                 'statusCode' => 200,
                 'message' => 'Login successful.',
             ]);
});



it('fails with wrong password', function () {
    $response = $this->postJson('/api/login', [
        'email' => 'john@example.com',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
             ->assertJson([
                 'success' => false,
                 'statusCode' => 401,
             ]);
});


it('fails when email is missing', function () {
    $response = $this->postJson('/api/login', [
        'password' => 'password123',
    ]);

    $response->assertStatus(422)
             ->assertJsonValidationErrors(['email']);
});


// ./vendor/bin/pest tests/Feature/Auth/LoginTest.php
