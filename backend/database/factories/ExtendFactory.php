<?php

namespace Database\Factories;

use App\Exceptions\InvalidDateRangeException;
use App\Models\Booking;
use App\Models\Extend;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Extend>
 */
class ExtendFactory extends Factory
{
    /**
     * @throws InvalidDateRangeException
     */
    public function definition(): array
    {
        /** @var Booking $booking */
        $booking = Booking::query()->inRandomOrder()->first();
        $extendedFrom = Carbon::parse($booking->end_date)->addDay();
        $extendedTo = Carbon::parse($extendedFrom)->addDays(5);

        return [
            'from' => $extendedFrom,
            'to' => $extendedTo,
            'price' => resolvePricing($extendedFrom, $extendedTo, $booking->package->price_per_day),
            'booking_id' => $booking,
        ];
    }
}
