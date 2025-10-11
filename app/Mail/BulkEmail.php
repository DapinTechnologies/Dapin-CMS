<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BulkEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;

    // Constructor to accept the email content
    public function __construct($messageContent)
    {
        $this->messageContent = $messageContent;
    }

    public function build()
    {
        return $this->subject('Bulk Email Notification')
                    ->view('emails.bulk_email') // Your email view
                    ->with([
                        'messageContent' => $this->messageContent,
                    ]);
    }
}
