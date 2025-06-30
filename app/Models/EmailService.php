<?php

namespace App\Services;

class EmailService
{
    public function sendFeeNotification($email, $message)
    {
        // Implementation using Laravel Mail
        \Mail::to($email)->send(new \App\Mail\FeeNotification($message));
    }
}