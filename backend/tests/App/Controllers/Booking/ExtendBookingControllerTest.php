<?php

use App\Enums\BookingStatus;
use App\Enums\Role;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role as SpatieRole;
use Symfony\Component\HttpFoundation\Response;
use Workora\Booking\Actions\CreateBooking;

it('can extend a existing booking', function () {
    SpatieRole::create(['name' => Role::ADMIN]);
    $user = User::factory()->create()->assignRole(Role::ADMIN);
    $package = Package::factory()->create();
    $booking = Booking::factory()->create([
        'package_id' => $package->id,
        'start_date' => Carbon::today()->toDateString(),
        'end_date' => Carbon::tomorrow()->toDateString(),
        'status' => BookingStatus::CONFIRMED,
    ]);

    mock(CreateBooking::class)
        ->shouldReceive('execute');

    $response = $this->actingAs($user)
        ->postJson('/api/booking-extend', [
            'from' => now()->addDays(4)->toDateString(),
            'to' => now()->addDays(5)->toDateString(),
            'booking_id' => $booking->id,
        ]);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson([
            'status' => 'Booking extended successfully',
        ]);
});
