<?php

use App\Enums\Role;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Illuminate\Support\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;

beforeEach(function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $this->user = User::factory()->create()->assignRole(Role::ADMIN);
    Package::factory()->create();
});

function extendPayload(array $overrides = [])
{
    $booking = Booking::factory()->create();

    $default = [
        'from' => '2025-04-11',
        'to' => '2025-04-12',
        'booking_id' => $booking->id,
    ];

    return test()->actingAs(test()->user)
        ->postJson('/api/booking-extend', array_merge($default, $overrides));
}

it('fails when required fields are missing', function () {
    $response = extendPayload([
        'from' => null,
        'to' => null,
        'booking_id' => null,
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['from', 'to', 'booking_id']);
});

it('fails when date formats are invalid', function () {
    $response = extendPayload([
        'from' => '01-01-2025',
        'to' => '05-01-2025',
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['from', 'to']);
});

it('fails when the from date is before today', function () {
    $response = extendPayload([
        'from' => Carbon::yesterday()->toDateString(),
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['from']);
});

it('fails when the to date is before the from date', function () {
    $response = extendPayload([
        'from' => Carbon::tomorrow()->toDateString(),
        'to' => Carbon::yesterday()->toDateString(),
    ]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['to']);
});

it('fails when booking_id does not exist', function () {
    $response = extendPayload(['booking_id' => 999999]);

    $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
        ->assertJsonValidationErrors(['booking_id']);
});
