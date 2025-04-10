<?php

use App\Enums\BookingStatus;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Workora\Booking\Actions\CreateBooking;

use function Pest\Laravel\assertDatabaseHas;

it('can create booking', function () {
    $user = User::factory()->create();
    $package = Package::factory()->create();

    $booking = resolve(CreateBooking::class)
        ->execute(
            'John Doe',
            'Company Name',
            '123456789',
            'test@workora.com',
            'Company Address',
            Carbon::parse('2025-04-10'),
            Carbon::parse('2025-04-14'),
            5000.00,
            BookingStatus::PENDING,
            $user,
            $package
        );

    expect($booking)->toBeInstanceOf(Booking::class);

    assertDatabaseHas(Booking::class, [
        'id' => $booking->id,
        'full_name' => 'John Doe',
        'company_name' => 'Company Name',
        'company_telephone_number' => '123456789',
        'company_email' => 'test@workora.com',
        'company_address' => 'Company Address',
        'start_date' => Carbon::parse('2025-04-10'),
        'end_date' => Carbon::parse('2025-04-14'),
        'price' => 5000.00,
        'status' => BookingStatus::PENDING,
        'user_id' => $user->id,
        'package_id' => $package->id,
    ]);
});
