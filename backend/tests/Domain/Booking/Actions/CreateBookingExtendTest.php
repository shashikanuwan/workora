<?php

use App\Enums\BookingStatus;
use App\Exceptions\BookingAlreadyExtendedForPeriodException;
use App\Exceptions\BookingDateAlreadyReservedException;
use App\Exceptions\CannotExtendCanceledBookingException;
use App\Exceptions\InvalidExtensionDatesException;
use App\Models\Booking;
use App\Models\Extend;
use App\Models\Package;
use Carbon\Carbon;
use Workora\Booking\Actions\CreateBookingExtend;

use function Pest\Laravel\assertDatabaseHas;

beforeEach(function () {
    $this->package = Package::factory()->create();
});

it('can create booking extend', function () {
    $booking = Booking::factory()->create([
        'package_id' => $this->package->id,
        'status' => BookingStatus::CONFIRMED,
        'end_date' => '2025-04-12',
    ]);

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

it('throws exception if booking is canceled', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CANCELED,
        'end_date' => '2025-04-12',
        'package_id' => $this->package->id,
    ]);

    resolve(CreateBookingExtend::class)
        ->execute(
            Carbon::parse('2025-04-13'),
            Carbon::parse('2025-04-14'),
            2000,
            $booking
        );
})->throws(CannotExtendCanceledBookingException::class);

it('throws exception if extension start date is before booking end date', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CONFIRMED,
        'end_date' => '2025-04-13',
        'package_id' => $this->package->id,
    ]);

    resolve(CreateBookingExtend::class)
        ->execute(
            Carbon::parse('2025-04-12'),
            Carbon::parse('2025-04-14'),
            2000,
            $booking
        );
})->throws(InvalidExtensionDatesException::class);

it('throws exception if extension start date is equal to booking end date', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CONFIRMED,
        'end_date' => '2025-04-13',
        'package_id' => $this->package->id,
    ]);

    resolve(CreateBookingExtend::class)
        ->execute(
            Carbon::parse('2025-04-13'),
            Carbon::parse('2025-04-14'),
            2000,
            $booking
        );
})->throws(InvalidExtensionDatesException::class);

it('throws exception if date overlaps with existing extend', function () {
    $booking = Booking::factory()->create([
        'status' => BookingStatus::CONFIRMED,
        'end_date' => '2025-04-12',
        'package_id' => $this->package->id,
    ]);

    Extend::factory()->create([
        'booking_id' => $booking->id,
        'from' => '2025-04-14',
        'to' => '2025-04-16',
    ]);

    resolve(CreateBookingExtend::class)
        ->execute(
            Carbon::parse('2025-04-15'),
            Carbon::parse('2025-04-17'),
            2000,
            $booking
        );
})->throws(BookingAlreadyExtendedForPeriodException::class);

it('throws exception if dates are already reserved by another booking', function () {
    Booking::factory()->create([
        'start_date' => '2025-04-15',
        'end_date' => '2025-04-17',
        'status' => BookingStatus::CONFIRMED,
        'package_id' => $this->package->id,
    ]);

    $booking = Booking::factory()->create([
        'end_date' => '2025-04-14',
        'status' => BookingStatus::CONFIRMED,
        'package_id' => $this->package->id,
    ]);

    resolve(CreateBookingExtend::class)
        ->execute(
            Carbon::parse('2025-04-15'),
            Carbon::parse('2025-04-17'),
            2500,
            $booking
        );
})->throws(BookingDateAlreadyReservedException::class);
