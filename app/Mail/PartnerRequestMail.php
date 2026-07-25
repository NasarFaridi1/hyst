<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PartnerRequestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $partnerType = $this->data['partner_type'] ?? 'Partner';
        
        return $this->subject("New {$partnerType} Request - HYST")
                    ->view('emails.partner-request')
                    ->with('data', $this->data);
    }
}
