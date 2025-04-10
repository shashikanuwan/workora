<?php

namespace App\Repositories;

use App\Models\Booking;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository
{
    public function getAllBooking($perPage = 10): LengthAwarePaginator
    {
        return Booking::query()
            ->paginate($perPage);
    }
}
