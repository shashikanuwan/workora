<?php

namespace App\Repositories;

use App\Models\Booking;
use App\Models\Package;
use App\Models\Queries\BookingQueryBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BookingRepository
{
    public function getAllBookings(?Package $package = null, int $perPage = 10): LengthAwarePaginator
    {
        return $this->getBookingsQuery($package)
            ->with('user', 'package')
            ->orderBy('start_date')
            ->paginate($perPage);
    }

    public function getUpcomingBookings(?Package $package = null, ?int $perPage = null): LengthAwarePaginator|Collection
    {
        $query = $this->getBookingsQuery($package)
            ->orderBy('start_date')
            ->upcoming();

        if ($perPage) {
            return $query->paginate($perPage);
        }

        return $query->get();
    }

    private function getBookingsQuery(?Package $package = null): BookingQueryBuilder
    {
        $query = Booking::query();

        if ($package) {
            $query->where('package_id', $package->id);
        }

        return $query;
    }
}
