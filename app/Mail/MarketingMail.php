<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MarketingMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectText;
    public $messageText;
    public $user;

    public function __construct($subjectText, $messageText, User $user)
    {
        $this->subjectText = $subjectText;
        $this->messageText = $messageText;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject($this->subjectText)
            ->view('emails.marketing');
    }
}