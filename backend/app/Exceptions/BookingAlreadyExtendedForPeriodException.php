<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BookingAlreadyExtendedForPeriodException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            ['errors' => 'This period has already been extended.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
