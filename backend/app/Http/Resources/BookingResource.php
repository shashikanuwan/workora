<?php

namespace App\Http\Resources;

use App\Enums\BookingStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $full_name
 * @property string $company_name
 * @property string $company_telephone_number
 * @property string $company_email
 * @property string $company_address
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property float $price
 * @property BookingStatus $status
 */
class BookingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'company_name' => $this->company_name,
            'company_telephone_number' => $this->company_telephone_number,
            'company_email' => $this->company_email,
            'company_address' => $this->company_address,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'price' => $this->price,
            'status' => $this->status,
        ];
    }
}
