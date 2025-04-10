<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingDateAlreadyReservedException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            ['errors' => 'The selected dates are already reserved.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
