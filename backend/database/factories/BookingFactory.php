<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Exceptions\InvalidDateRangeException;
use App\Models\Booking;
use App\Models\Package;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * @throws InvalidDateRangeException
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('now', '+1 month');
        $endDate = $this->faker->dateTimeBetween($startDate, '+1 month');

        return [
            'company_name' => $this->faker->company(),
            'company_telephone_number' => $this->faker->phoneNumber(),
            'company_email' => $this->faker->unique()->safeEmail(),
            'company_address' => $this->faker->address(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'price' => resolvePricing(Carbon::parse($startDate), Carbon::parse($endDate), 100.0),
            'status' => $this->faker->randomElement(BookingStatus::cases()),
            'user_id' => User::query()->inRandomOrder()->first(),
            'package_id' => Package::query()->inRandomOrder()->first(),
        ];
    }
}
