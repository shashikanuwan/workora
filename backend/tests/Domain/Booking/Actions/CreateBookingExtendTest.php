<?php

use App\Models\Booking;
use App\Models\Extend;
use App\Models\Package;
use Carbon\Carbon;
use Workora\Booking\Actions\CreateBookingExtend;

use function Pest\Laravel\assertDatabaseHas;

it('can create booking extend', function () {
    Package::factory()->create();
    $booking = Booking::factory()->create();

    $extend = resolve(CreateBookingExtend::class)
        ->execute(
            Carbon::parse('2025-04-13'),
            Carbon::parse('2025-04-14'),
            2000,
            $booking,
        );

    expect($extend)->toBeInstanceOf(Extend::class);

    assertDatabaseHas(Extend::class, [
        'from' => Carbon::parse('2025-04-13'),
        'to' => Carbon::parse('2025-04-14'),
        'price' => 2000,
        'booking_id' => $booking->id,
    ]);
});
