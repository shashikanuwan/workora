<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Package;
use Workora\Booking\Actions\UpdateBookingStatus;

use function Pest\Laravel\assertDatabaseHas;

it('can update booking', function () {
    $package = Package::factory()->create([
        'price_per_day' => 1000,
    ]);

    $booking = Booking::factory()->create([
        'status' => BookingStatus::PENDING,
        'package_id' => $package->id,
    ]);

    $updatedBooking = resolve(UpdateBookingStatus::class)
        ->execute(
            $booking,
            BookingStatus::CONFIRMED,
        );

    expect($updatedBooking)->toBeInstanceOf(Booking::class);

    assertDatabaseHas(Booking::class, [
        'id' => $booking->id,
        'status' => BookingStatus::CONFIRMED,
    ]);
});
