<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanceledBookingCannotBeConfirmedException extends Exception
{
    public function render(Request $request): JsonResponse
    {
        return response()->json(
            ['errors' => 'A canceled booking cannot be confirmed.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
