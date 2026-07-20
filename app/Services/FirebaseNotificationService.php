<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    protected $messaging;

    public function __construct()
    {
        $factory =
            (new Factory)

            ->withServiceAccount(

                storage_path(
                    'app/firebase/firebase.json'
                )

            );

        $this->messaging =
            $factory->createMessaging();
    }

    public function send(
        $token,
        $title,
        $body
    ) {

        try {

            /*
            -----------------------
            TOKEN CHECK
            -----------------------
            */

            if (
                empty($token)
            ) {

                \Log::error(
                    'FCM TOKEN NULL'
                );

                return false;
            }

            \Log::info(
                'FCM SEND START',
                [

                    'token' =>
                        substr(
                            $token,
                            0,
                            20
                        ),

                    'title' =>
                        $title
                ]
            );

            $message =
                CloudMessage::withTarget(

                    'token',

                    (string)$token

                )

                ->withNotification(

                    Notification::create(

                        $title,

                        $body
                    )
                );

            $this->messaging
                ->send(
                    $message
                );

            \Log::info(
                'FCM SEND SUCCESS'
            );

            return true;

        }

        catch (
            \Exception $e
        ) {

            \Log::error(

                'FCM SEND FAILED',

                [

                    'message' =>
                        $e->getMessage()

                ]

            );

            return false;
        }
    }
}