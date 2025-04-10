<?php

namespace App\Http\Requests\Package;

use Illuminate\Foundation\Http\FormRequest;

class CreatePackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'seat' => ['required', 'integer', 'min:1'],
            'price_per_day' => ['required', 'numeric', 'min:0'],
        ];
    }
}
