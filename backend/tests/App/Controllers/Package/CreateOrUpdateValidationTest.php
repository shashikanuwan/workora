<?php

use App\Enums\Role;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $this->user = User::factory()->create()->assignRole(Role::ADMIN);
});

function postPackage(array $overrides = [])
{
    $default = [
        'name' => 'Test Package',
        'description' => 'This is a test package.',
        'seat' => 5,
        'price_per_day' => 1000,
    ];

    return test()->actingAs(test()->user)
        ->postJson('/api/packages', array_merge($default, $overrides));
}

it('requires name field', function () {
    $response = postPackage(['name' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['name']);
});

it('requires description field', function () {
    $response = postPackage(['description' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['description']);
});

it('requires seat field', function () {
    $response = postPackage(['seat' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['seat']);
});

it('requires price_per_day field', function () {
    $response = postPackage(['price_per_day' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['price_per_day']);
});

it('requires name to be a string and not exceed 255 characters', function () {
    $response = postPackage(['name' => str_repeat('A', 256)]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['name']);
});

it('requires description to be a string and not exceed 500 characters', function () {
    $response = postPackage(['description' => str_repeat('A', 501)]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['description']);
});

it('requires seat to be an integer and at least 1', function () {
    $response = postPackage(['seat' => 0]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['seat']);
});

it('requires price_per_day to be numeric', function () {
    $response = postPackage(['price_per_day' => 'foo']);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['price_per_day']);
});
