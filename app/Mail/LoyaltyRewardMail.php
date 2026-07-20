<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;

use Illuminate\Mail\Mailables\Content;

use Illuminate\Mail\Mailables\Envelope;

use Illuminate\Queue\SerializesModels;


class LoyaltyRewardMail extends Mailable
{

    use Queueable;

    use SerializesModels;


    public $customer;

    public $offers;

    public $rewardType;

    public $festivalName;

    public $emailSubject;

    public $emailMessage;


    public function __construct(

        $customer,

        $offers,

        $rewardType,

        $festivalName,

        $emailSubject,

        $emailMessage

    ) {

        $this->customer =
            $customer;

        $this->offers =
            $offers;

        $this->rewardType =
            $rewardType;

        $this->festivalName =
            $festivalName;

        $this->emailSubject =
            $emailSubject;

        $this->emailMessage =
            $emailMessage;

    }


    public function envelope(): Envelope
    {

        return new Envelope(

            subject:
                $this->emailSubject

        );

    }


    public function content(): Content
    {

        return new Content(

            view:
                'emails.loyalty-reward'

        );

    }


    public function attachments(): array
    {

        return [];

    }

}