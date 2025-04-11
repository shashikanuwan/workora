<?php

namespace App\Http\Requests\Booking;

use Illuminate\Foundation\Http\FormRequest;

class ExtendBookingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'from' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:today'],
            'to' => ['required', 'date', 'date_format:Y-m-d', 'after_or_equal:from'],
            'booking_id' => ['required', 'integer', 'exists:bookings,id'],
        ];
    }
}
