<?php

namespace Workora\Booking\Actions;

use App\Enums\BookingStatus;
use App\Exceptions\BookingDateAlreadyReservedException;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;

class CreateBooking
{
    /**
     * @throws BookingDateAlreadyReservedException
     */
    public function execute(
        string $fullName,
        string $companyName,
        string $companyTelephoneNumber,
        string $companyEmail,
        string $companyAddress,
        Carbon $startDate,
        Carbon $endDate,
        float $price,
        BookingStatus $status,
        User $user,
        Package $package
    ): Booking {
        $this->ensureBookingDateIsAvailable($startDate, $endDate, $package);

        $booking = new Booking;
        $booking->full_name = $fullName;
        $booking->company_name = $companyName;
        $booking->company_telephone_number = $companyTelephoneNumber;
        $booking->company_email = $companyEmail;
        $booking->company_address = $companyAddress;
        $booking->start_date = $startDate;
        $booking->end_date = $endDate;
        $booking->price = $price;
        $booking->status = $status;
        $booking->user_id = $user->id;
        $booking->package_id = $package->id;
        $booking->save();

        return $booking;
    }

    /**
     * @throws BookingDateAlreadyReservedException
     */
    private function ensureBookingDateIsAvailable(Carbon $startDate, Carbon $endDate, Package $package): void
    {
        $existingBooking = Booking::query()
            ->where('package_id', $package->id)
            ->whereOverlaps($startDate, $endDate)
            ->exists();

        if ($existingBooking) {
            throw new BookingDateAlreadyReservedException;
        }
    }
}
