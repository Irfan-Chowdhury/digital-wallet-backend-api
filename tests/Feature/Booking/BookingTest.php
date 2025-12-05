<?php

use App\Models\User;
use App\Models\Service;
use App\Models\Booking;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\Sanctum;


beforeEach(function () {
    // Create a test customer and authenticate
    $this->user = User::factory()->create([
        'role' => 'customer',
    ]);

    Sanctum::actingAs($this->user, ['*']);

    // Create a test service
    $this->service = Service::factory()->create();
});


it('successfully books a service with valid date', function () {
    $response = $this->postJson('/api/bookings', [
        'service_id' => $this->service->id,
        'booking_date' => now()->addDay()->toDateString(),
    ]);

    $response->assertStatus(201);
    $response->assertJson([
        'success' => true,
        'message' => 'Booking created successfully',
    ]);
});


it('fails to book a service on a past date', function () {
    $response = $this->postJson('/api/bookings', [
        'service_id' => $this->service->id,
        'booking_date' => now()->subDay()->toDateString(),
    ]);

    $response->assertStatus(422);
    $response->assertJsonValidationErrors(['booking_date']);
    $response->assertJsonFragment([
        'message' => 'Validation Error',
    ]);
});

it('fails to book the same service on the same date twice', function () {
    $date = now()->addDays(2)->toDateString();

    // First booking
    Booking::create([
        'user_id' => $this->user->id,
        'service_id' => $this->service->id,
        'booking_date' => $date,
        'status' => 'pending',
    ]);

    // Second booking attempt with same service & date
    $response = $this->postJson('/api/bookings', [
        'service_id' => $this->service->id,
        'booking_date' => $date,
    ]);

    $response->assertStatus(422); // or 409 if you're throwing manually
    $response->assertJsonValidationErrors(['message']);
    $response->assertJsonFragment([
        'message' => 'Validation Error',
    ]);
});



// ./vendor/bin/pest tests/Feature/Booking/BookingTest.php
