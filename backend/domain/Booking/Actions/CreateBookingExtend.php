<?php

namespace Workora\Booking\Actions;

use App\Enums\BookingStatus;
use App\Exceptions\BookingAlreadyExtendedForPeriodException;
use App\Exceptions\BookingDateAlreadyReservedException;
use App\Exceptions\CannotExtendCanceledBookingException;
use App\Exceptions\InvalidExtensionDatesException;
use App\Models\Booking;
use App\Models\Extend;
use App\Models\Package;
use Carbon\Carbon;

class CreateBookingExtend
{
    /**
     * @throws InvalidExtensionDatesException
     * @throws BookingAlreadyExtendedForPeriodException
     * @throws CannotExtendCanceledBookingException
     * @throws BookingDateAlreadyReservedException
     */
    public function execute(
        Carbon $fromDate,
        Carbon $toDate,
        float $price,
        Booking $booking,
    ): Extend {

        if (! in_array($booking->status, [BookingStatus::PENDING, BookingStatus::CONFIRMED])) {
            throw new CannotExtendCanceledBookingException;
        }

        if ($fromDate->lte(Carbon::parse($booking->end_date))) {
            throw new InvalidExtensionDatesException(
                'The extension start date must be after the booking end date of '.Carbon::parse($booking->end_date)->format('Y-m-d').'.'
            );
        }

        $this->ensureBookingDateIsAvailable($fromDate, $toDate, $booking->package);

        $overlappingExtendExists = Extend::query()
            ->where('booking_id', $booking->id)
            ->where(function ($query) use ($fromDate, $toDate) {
                $query->where('from', '<=', $toDate)
                    ->where('to', '>=', $fromDate);
            })
            ->exists();

        if ($overlappingExtendExists) {
            throw new BookingAlreadyExtendedForPeriodException;
        }

        $extend = new Extend;
        $extend->from = $fromDate;
        $extend->to = $toDate;
        $extend->price = $price;
        $extend->booking_id = $booking->id;
        $extend->save();

        return $extend;
    }

    /**
     * @throws BookingDateAlreadyReservedException
     */
    private function ensureBookingDateIsAvailable(Carbon $startDate, Carbon $endDate, Package $package): void
    {
        $existingBooking = Booking::query()
            ->where(function ($query) use ($startDate, $endDate, $package) {
                $query->where('package_id', $package->id);
                $query->unavailable();
                $query->whereOverlaps($startDate, $endDate);
            })
            ->exists();

        if ($existingBooking) {
            throw new BookingDateAlreadyReservedException;
        }
    }
}
