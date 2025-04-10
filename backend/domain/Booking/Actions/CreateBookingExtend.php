<?php

namespace Workora\Booking\Actions;

use App\Models\Booking;
use App\Models\Extend;
use Carbon\Carbon;

class CreateBookingExtend
{
    public function execute(
        Carbon $from,
        Carbon $to,
        float $price,
        Booking $booking,
    ): Extend {
        $extend = new Extend;
        $extend->from = $from;
        $extend->to = $to;
        $extend->price = $price;
        $extend->booking_id = $booking->id;
        $extend->save();

        return $extend;
    }
}
