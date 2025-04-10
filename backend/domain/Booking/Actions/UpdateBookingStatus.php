<?php

namespace Workora\Booking\Actions;

use App\Enums\BookingStatus;
use App\Models\Booking;

class UpdateBookingStatus
{
    public function execute(
        Booking $booking,
        BookingStatus $status,
    ): Booking {
        $booking->status = $status;
        $booking->save();

        return $booking;
    }
}
