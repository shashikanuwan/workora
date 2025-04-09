<?php

use App\Exceptions\InvalidDateRangeException;
use Carbon\Carbon;

/**
 * @throws InvalidDateRangeException
 */
function resolvePricing(Carbon $startDate, Carbon $endDate, float $pricePerDay): float
{
    if ($endDate->lessThan($startDate)) {
        throw new InvalidDateRangeException;
    }

    $days = $startDate->diffInDays($endDate) + 1;

    return $days * $pricePerDay;
}
