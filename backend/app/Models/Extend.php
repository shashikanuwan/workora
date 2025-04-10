<?php

namespace App\Models;

use Carbon\Carbon;
use Database\Factories\ExtendFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Carbon $from
 * @property Carbon $to
 * @property float $price
 * @property int $booking_id
 */
class Extend extends Model
{
    /** @use HasFactory<ExtendFactory> */
    use HasFactory;
}
