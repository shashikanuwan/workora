<?php

namespace App\Models;

use Database\Factories\ContractFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $document
 * @property int $user_id
 * @property int $booking_id
 */
class Contract extends Model
{
    /** @use HasFactory<ContractFactory> */
    use HasFactory;
}
