<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConfirmedBookingCannotBeCanceledException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            ['errors' => 'A confirmed booking cannot be canceled.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
