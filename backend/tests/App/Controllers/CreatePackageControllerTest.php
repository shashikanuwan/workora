<?php

use App\Enums\Role;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;
use Workora\Package\Actions\CreateOrUpdatePackage;

it('can create a new package', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    mock(CreateOrUpdatePackage::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'description' => 'This is a test package.',
            'seat' => 5,
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson(['status' => 'Package created successfully']);
});

it('requires name field', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'description' => 'This is a test package.',
            'seat' => 5,
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['name']);
});

it('requires description field', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'seat' => 5,
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['description']);
});

it('requires seat field', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'description' => 'This is a test package.',
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['seat']);
});

it('requires price_per_day field', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'description' => 'This is a test package.',
            'seat' => 5,
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['price_per_day']);
});

it('requires name to be a string and not exceed 255 characters', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => str_repeat('A', 256),
            'description' => 'This is a test package.',
            'seat' => 5,
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['name']);
});

it('requires description to be a string and not exceed 255 characters', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'description' => str_repeat('A', 501),
            'seat' => 5,
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['description']);
});

it('requires seat to be a integer and minimum must not be less than 1', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'description' => 'This is a test package.',
            'seat' => 0,
            'price_per_day' => 1000,
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['seat']);
});

it('requires price_per_day to be a numeric', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);

    $response = $this->actingAs($user)
        ->postJson('/api/packages', [
            'name' => 'Test Package',
            'description' => 'This is a test package.',
            'seat' => 5,
            'price_per_day' => 'foo',
        ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    $response->assertJsonValidationErrors(['price_per_day']);
});
