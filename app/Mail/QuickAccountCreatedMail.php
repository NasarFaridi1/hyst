<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class QuickAccountCreatedMail extends Mailable
{
    public $user;
    public $password;

    public function __construct($user, $password)
    {
        $this->user = $user;
        $this->password = $password;
    }

    public function build()
    {
        return $this->subject('Your Account Details - HYST')
                    ->view('emails.quick-account-created');
    }
}
