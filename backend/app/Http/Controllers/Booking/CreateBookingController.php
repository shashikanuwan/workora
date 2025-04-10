<?php

namespace App\Http\Controllers\Booking;

use App\Enums\BookingStatus;
use App\Exceptions\InvalidDateRangeException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\CreateBookingRequest;
use App\Models\Package;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Workora\Booking\Actions\CreateBooking;

class CreateBookingController extends Controller
{
    public function __construct(protected CreateBooking $createBooking) {}

    /**
     * @throws InvalidDateRangeException
     */
    public function __invoke(CreateBookingRequest $request): JsonResponse
    {
        $startDate = Carbon::parse($request->validated('start_date'));
        $endDate = Carbon::parse($request->validated('end_date'));
        $package = Package::query()->find($request->validated('package_id'));

        $this->createBooking->execute(
            $request->validated('full_name'),
            $request->validated('company_name'),
            $request->validated('company_telephone_number'),
            $request->validated('company_email'),
            $request->validated('company_address'),
            $startDate,
            $endDate,
            resolvePricing($startDate, $endDate, $package->price_per_day),
            BookingStatus::PENDING,
            $request->user(),
            $package
        );

        return response()->json([
            'status' => 'Booking created successfully',
        ], Response::HTTP_CREATED);
    }
}
