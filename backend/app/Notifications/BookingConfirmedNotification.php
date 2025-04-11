<?php

namespace App\Notifications;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingConfirmedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Booking $booking,
        public bool $isAdmin = false
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject($this->isAdmin ? 'New Booking Confirmed' : 'Your Booking is Confirmed')
            ->greeting($this->isAdmin ? 'Hello Admin,' : 'Hello '.$this->booking->user->name.',')
            ->line($this->isAdmin
                ? 'A new booking has been confirmed.'
                : 'Your booking has been successfully confirmed.')
            ->line('Booking Details:')
            ->line('Company Name: '.$this->booking->company_name)
            ->line('Package Name: '.$this->booking->package->name)
            ->line('Start Date: '.$this->booking->start_date)
            ->line('End Date: '.$this->booking->end_date)
            ->line('Price:'.$this->booking->price)
            ->line('Status: '.$this->booking->status->label())
            ->line($this->isAdmin ? 'Thank you for using our service!' : '');
    }
}
