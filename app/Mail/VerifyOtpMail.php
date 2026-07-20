<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class VerifyOtpMail extends Mailable
{
    public $otp;
    public $verifyUrl;

    public function __construct($otp,$verifyUrl)
    {
        $this->otp = $otp;
        $this->verifyUrl = $verifyUrl;
        
    }

    public function build()
    {
        return $this->subject('Verify Your Email')
                    ->view('emails.verify-otp');
    }
}