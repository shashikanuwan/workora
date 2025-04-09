<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class InvalidDateRangeException extends Exception
{
    public function render(): JsonResponse
    {
        return response()->json(
            ['errors' => 'End date must be greater than or equal to the start date.'],
            Response::HTTP_UNPROCESSABLE_ENTITY
        );
    }
}
