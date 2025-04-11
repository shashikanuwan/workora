<?php

use App\Enums\BookingStatus;
use App\Events\BookingCanceled;
use App\Events\BookingConfirmed;
use App\Exceptions\BookingAlreadyCanceledException;
use App\Exceptions\BookingAlreadyConfirmedException;
use App\Exceptions\CanceledBookingCannotBeConfirmedException;
use App\Exceptions\ConfirmedBookingCannotBeCanceledException;
use App\Models\Booking;
use App\Models\Package;
use Illuminate\Support\Facades\Event;
use Workora\Booking\Actions\UpdateBookingStatus;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    Event::fake();
    Package::factory()->create();
});

it('confirms a pending booking and dispatches event', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::PENDING,
    ]);

    $updated = resolve(UpdateBookingStatus::class)
        ->execute(
            $booking,
            BookingStatus::CONFIRMED,
        );

    expect($updated)->toBeInstanceOf(Booking::class);

    assertDatabaseHas(Booking::class, [
        'id' => $booking->id,
        'status' => BookingStatus::CONFIRMED,
    ]);

    Event::assertDispatched(BookingConfirmed::class);
});

it('cancels a pending booking and dispatches event', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::PENDING,
    ]);

    $updated = resolve(UpdateBookingStatus::class)
        ->execute($booking, BookingStatus::CANCELED);

    expect($updated)->toBeInstanceOf(Booking::class);

    assertDatabaseHas(Booking::class, [
        'id' => $booking->id,
        'status' => BookingStatus::CANCELED,
    ]);
    Event::assertDispatched(BookingCanceled::class);
});

it('throws exception when confirming an already confirmed booking', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CONFIRMED,
    ]);

    resolve(UpdateBookingStatus::class)
        ->execute($booking, BookingStatus::CONFIRMED);
})->throws(BookingAlreadyConfirmedException::class);

it('throws exception when canceling an already canceled booking', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CANCELED,
    ]);

    resolve(UpdateBookingStatus::class)
        ->execute($booking, BookingStatus::CANCELED);
})->throws(BookingAlreadyCanceledException::class);

it('throws exception when confirming a canceled booking', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CANCELED,
    ]);

    resolve(UpdateBookingStatus::class)
        ->execute($booking, BookingStatus::CONFIRMED);
})->throws(CanceledBookingCannotBeConfirmedException::class);

it('throws exception when canceling a confirmed booking', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CONFIRMED,
    ]);
    resolve(UpdateBookingStatus::class)
        ->execute($booking, BookingStatus::CANCELED);
})->throws(ConfirmedBookingCannotBeCanceledException::class);
