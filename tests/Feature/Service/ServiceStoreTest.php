<?php

use App\Enum\UserRole;
use App\Models\User;
use Laravel\Sanctum\Sanctum;



it('allows admin to create a service', function () {
    // Given: An admin user
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    Sanctum::actingAs($admin);

    // When: Sending POST request
    $response = $this->postJson('/api/services', [
        'name' => 'Laptop Repair',
        'description' => 'Full laptop repair service',
        'price' => 3500,
        'status' => true,
    ]);

    // Then: Should succeed
    $response->assertStatus(201)
        ->assertJson([
            'success' => true,
            'message' => 'Service created successfully.',
            'data' => [
                'name' => 'Laptop Repair',
                'description' => 'Full laptop repair service',
                'price' => '3500.00',
                'status' => true,
            ],
        ]);

    $this->assertDatabaseHas('services', [
        'name' => 'Laptop Repair',
        'price' => 3500,
    ]);
});



it('prevents non-admin user from creating a service', function () {
    // Given: A customer user
    $customer = User::factory()->create([
        'role' => UserRole::CUSTOMER->value,
    ]);

    Sanctum::actingAs($customer);

    // When: Sending POST request
    $response = $this->postJson('/api/services', [
        'name' => 'AC Repair',
        'price' => 2500,
    ]);

    // Then: Should fail with 403 Forbidden
    $response->assertStatus(403)
        ->assertJson([
            'statusCode' => 403,
            'success' => false,
        ]);
});


it('fails validation with missing fields', function () {
    // Given: Admin user
    $admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    Sanctum::actingAs($admin);

    // When: Sending POST request without name and price
    $response = $this->postJson('/api/services', []);

    // Then: Should fail with validation errors
    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Validation Error',
        ])
        ->assertJsonStructure([
            'errors' => ['name', 'price'],
        ]);
});


// ./vendor/bin/pest tests/Feature/Service/ServiceStoreTest.php
