<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingAlreadyConfirmedException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            ['errors' => 'Booking is already confirmed.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
