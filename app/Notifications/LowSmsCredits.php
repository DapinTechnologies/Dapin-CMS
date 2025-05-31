<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LowSmsCredits extends Notification
{
    protected $credits;

    public function __construct($credits)
    {
        $this->credits = $credits;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line("Your SMS credits are low. Only {$this->credits} left.")
            ->action('Top Up', url('/sms/top-up'))
            ->line('Please top up soon to avoid interruption.');
    }
}
