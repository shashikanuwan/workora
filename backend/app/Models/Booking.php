<?php

namespace App\Models;

use App\Enums\BookingStatus;
use App\Models\Queries\BookingQueryBuilder;
use Carbon\Carbon;
use Database\Factories\BookingFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $full_name
 * @property string $company_name
 * @property mixed|string $company_telephone_number
 * @property string $company_email
 * @property string $company_address
 * @property Carbon $start_date
 * @property Carbon $end_date
 * @property float $price
 * @property BookingStatus $status
 * @property int $user_id
 * @property int $package_id
 * @property Package $package
 * @property User $user
 *
 * @method static BookingQueryBuilder query()
 * @method static BookingQueryBuilder
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

    public function contracts(): HasMany
    {
        return $this->hasMany(Contract::class);
    }

    // accessors and mutators
    protected function startDate(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Carbon::parse($value)
                ->format('d M y') : null,
        );
    }

    protected function endDate(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? Carbon::parse($value)
                ->format('d M y') : null,
        );
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => $value ? 'Rs.'.$value : null,
        );
    }

    #[Scope]
    public function unavailable(Builder $query): Builder
    {
        return $query->whereIn('status', [BookingStatus::PENDING, BookingStatus::CONFIRMED]);
    }

    public function newEloquentBuilder($query): Builder
    {
        return new BookingQueryBuilder($query);
    }
}
