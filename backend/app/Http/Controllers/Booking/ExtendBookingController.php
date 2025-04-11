<?php

namespace App\Http\Controllers\Booking;

use App\Exceptions\BookingAlreadyExtendedForPeriodException;
use App\Exceptions\BookingDateAlreadyReservedException;
use App\Exceptions\CannotExtendCanceledBookingException;
use App\Exceptions\InvalidDateRangeException;
use App\Exceptions\InvalidExtensionDatesException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\ExtendBookingRequest;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Workora\Booking\Actions\CreateBookingExtend;

class ExtendBookingController extends Controller
{
    public function __construct(protected CreateBookingExtend $createBookingExtend) {}

    /**
     * @throws InvalidDateRangeException
     * @throws InvalidExtensionDatesException
     * @throws BookingAlreadyExtendedForPeriodException
     * @throws CannotExtendCanceledBookingException
     * @throws BookingDateAlreadyReservedException
     */
    public function __invoke(ExtendBookingRequest $request): JsonResponse
    {
        $fromDate = Carbon::parse($request->validated('from'));
        $toDate = Carbon::parse($request->validated('to'));
        /** @var Booking $booking */
        $booking = Booking::query()->find($request->validated('booking_id'));

        $this->createBookingExtend->execute(
            $fromDate,
            $toDate,
            resolvePricing($fromDate, $toDate, $booking->package->price_per_day),
            $booking,
        );

        return response()->json([
            'status' => 'Booking extended successfully',
        ], Response::HTTP_CREATED);
    }
}
