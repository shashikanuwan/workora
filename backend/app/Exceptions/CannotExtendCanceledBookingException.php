<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CannotExtendCanceledBookingException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            ['errors' => 'Only pending or confirmed bookings can be extended.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
