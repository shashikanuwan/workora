<?php

namespace App\Http\Controllers\Booking;

use App\Enums\BookingStatus;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Workora\Booking\Actions\UpdateBookingStatus;

class UpdateBookingStatusController extends Controller
{
    public function __construct(protected UpdateBookingStatus $updateBookingStatus) {}

    public function __invoke(Booking $booking, string $status): JsonResponse
    {
        $statusMap = [
            'confirm' => BookingStatus::CONFIRMED,
            'cancel' => BookingStatus::CANCELED,
        ];

        $this->updateBookingStatus->execute(
            $booking,
            $statusMap[$status]
        );

        return response()->json([
            'status' => 'Booking '.$statusMap[$status]->value,
        ], Response::HTTP_OK);
    }
}
