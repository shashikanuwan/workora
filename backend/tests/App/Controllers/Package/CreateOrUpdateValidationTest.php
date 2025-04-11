<?php

use App\Enums\Role;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $this->user = User::factory()->create()->assignRole(Role::ADMIN);
});

function packagePayload(array $overrides = [])
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
    $response = packagePayload(['name' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['name']);
});

it('requires description field', function () {
    $response = packagePayload(['description' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['description']);
});

it('requires seat field', function () {
    $response = packagePayload(['seat' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['seat']);
});

it('requires price_per_day field', function () {
    $response = packagePayload(['price_per_day' => null]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['price_per_day']);
});

it('requires name to be a string and not exceed 255 characters', function () {
    $response = packagePayload(['name' => str_repeat('A', 256)]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['name']);
});

it('requires description to be a string and not exceed 500 characters', function () {
    $response = packagePayload(['description' => str_repeat('A', 501)]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['description']);
});

it('requires seat to be an integer and at least 1', function () {
    $response = packagePayload(['seat' => 0]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['seat']);
});

it('requires price_per_day to be numeric', function () {
    $response = packagePayload(['price_per_day' => 'foo']);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['price_per_day']);
});
