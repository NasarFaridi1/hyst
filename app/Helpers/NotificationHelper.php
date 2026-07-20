<?php

use App\Models\Notification;

if (!function_exists('sendNotification')) {

    function sendNotification(
        $userId,
        $type,
        $title,
        $message,
        $referenceType = null,
        $referenceId = null,
        $orderId =null
    ) {

        Notification::create([

            'user_id' => $userId,

            'type' => $type,

            'title' => $title,

            'message' => $message,

            'reference_type' => $referenceType,

            'reference_id' => $referenceId,

            'order_id' => $orderId
        ]);
    }
}