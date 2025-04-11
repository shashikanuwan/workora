<?php

namespace App\Listeners;

use App\Enums\Role;
use App\Events\BookingConfirmed;
use App\Models\User;
use App\Notifications\BookingConfirmedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendBookingConfirmationNotification implements ShouldQueue
{
    public function __construct() {}

    public function handle(BookingConfirmed $event): void
    {
        $booking = $event->booking;

        // Notify user
        $booking->user->notify(new BookingConfirmedNotification($booking, false));

        // Notify all admins
        $admins = User::query()->role(Role::ADMIN->value)->get();
        Notification::send($admins, new BookingConfirmedNotification($booking, true));
    }
}
