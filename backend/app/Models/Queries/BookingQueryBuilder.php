<?php

namespace App\Models\Queries;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class BookingQueryBuilder extends Builder
{
    public function whereOverlaps(Carbon $startDate, Carbon $endDate): self
    {
        return $this->where('start_date', '<=', $endDate)
            ->where('end_date', '>=', $startDate);
    }

    public function upcoming(): self
    {
        return $this->whereDate('start_date', '>=', Carbon::now());
    }
}
