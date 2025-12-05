<?php

use App\Models\User;
use App\Models\Service;
use App\Enum\UserRole;
use Laravel\Sanctum\Sanctum;

beforeEach(function () {
    $this->admin = User::factory()->create([
        'role' => UserRole::ADMIN->value,
    ]);

    $this->customer = User::factory()->create([
        'role' => UserRole::CUSTOMER->value,
    ]);

    $this->service = Service::factory()->create([
        'name' => 'Laptop Repair',
        'price' => 5000,
        'status' => true,
    ]);
});

it('allows admin to update a service', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->putJson("/api/services/{$this->service->id}", [
        'name' => 'Updated Laptop Repair',
        'price' => 6000,
    ]);

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Service updated successfully.',
            'data' => [
                'name' => 'Updated Laptop Repair',
                'price' => '6000.00',
            ],
        ]);

    $this->assertDatabaseHas('services', [
        'id' => $this->service->id,
        'name' => 'Updated Laptop Repair',
    ]);
});


it('fails validation if name is not unique', function () {
    Sanctum::actingAs($this->admin);

    // Create another service with a name
    Service::factory()->create(['name' => 'Mobile Repair']);

    // Try updating first service with duplicate name
    $response = $this->putJson("/api/services/{$this->service->id}", [
        'name' => 'Mobile Repair',
    ]);

    $response->assertStatus(422)
        ->assertJson([
            'success' => false,
            'message' => 'Validation Error',
        ])
        ->assertJsonStructure(['errors' => ['name']]);
});


it('prevents non-admin user from updating a service', function () {
    Sanctum::actingAs($this->customer);

    $response = $this->putJson("/api/services/{$this->service->id}", [
        'name' => 'Illegal Update',
    ]);

    $response->assertStatus(403)
        ->assertJson([
            'statusCode' => 403,
            'success' => false,
            'message' => 'Forbidden',
        ]);
});


it('allows admin to delete a service', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->deleteJson("/api/services/{$this->service->id}");

    $response->assertStatus(200)
        ->assertJson([
            'success' => true,
            'message' => 'Service deleted successfully.',
        ]);

    $this->assertDatabaseMissing('services', [
        'id' => $this->service->id,
    ]);
});


it('returns 404 when trying to delete non-existing service', function () {
    Sanctum::actingAs($this->admin);

    $response = $this->deleteJson("/api/services/999999");

    $response->assertStatus(404)
        ->assertJson([
            'success' => false,
            'message' => 'Resource not found',
        ]);
});



// ./vendor/bin/pest tests/Feature/Service/ServiceUpdateDeleteTest.php
