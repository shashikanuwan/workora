<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Carbon\Carbon;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Carbon $end_date
 * @property Package $package
 */
class Booking extends Model
{
    /** @use HasFactory<BookingFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => BookingStatus::class,
        ];
    }

    // relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function extends(): HasMany
    {
        return $this->hasMany(Extend::class);
    }
}
