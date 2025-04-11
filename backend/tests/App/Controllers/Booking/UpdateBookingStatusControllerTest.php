<?php

use App\Enums\Role;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;
use Workora\Booking\Actions\UpdateBookingStatus;

beforeEach(function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $this->user = User::factory()->create()->assignRole(Role::ADMIN);
    Package::factory()->create();
    $this->booking = Booking::factory()->pending()->create();
});

it('updates booking status to confirmed', function () {
    mock(UpdateBookingStatus::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($this->user)
        ->patchJson("api/bookings/{$this->booking->id}/confirm");

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'status' => 'Booking confirmed',
        ]);
});

it('updates booking status to canceled', function () {
    mock(UpdateBookingStatus::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($this->user)
        ->patchJson("api/bookings/{$this->booking->id}/cancel");

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'status' => 'Booking canceled',
        ]);
});
