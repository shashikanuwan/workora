<?php

namespace App\Http\Controllers\Booking;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Workora\Booking\Actions\UpdateBookingStatus;

class ConfirmBookingController extends Controller
{
    public function __construct(protected UpdateBookingStatus $updateBookingStatus) {}

    public function __invoke(Booking $booking): JsonResponse
    {
        $this->updateBookingStatus->execute(
            $booking,
            BookingStatus::CONFIRMED
        );

        return response()->json([
            'status' => 'Booking confirmed',
        ], Response::HTTP_OK);
    }
}
