<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Repositories\BookingRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class FetchBookingController extends Controller
{
    public function __invoke(BookingRepository $bookingRepository): AnonymousResourceCollection
    {
        return BookingResource::collection($bookingRepository->getAllBooking());
    }
}
