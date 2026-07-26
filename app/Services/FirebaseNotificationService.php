<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class FirebaseNotificationService
{
    protected $messaging = null;

    public function __construct()
    {
        try {
            $credentialsPath = storage_path('app/firebase/firebase.json');

            if (file_exists($credentialsPath)) {
                $factory = (new Factory)->withServiceAccount($credentialsPath);
                $this->messaging = $factory->createMessaging();
            } else {
                \Log::warning('Firebase service account credentials file missing at: ' . $credentialsPath);
            }
        } catch (\Throwable $e) {
            \Log::error('Firebase initialization failed: ' . $e->getMessage());
            $this->messaging = null;
        }
    }

    public function send($token, $title, $body, $targetUrl = '/my-orders')
    {
        try {
            if (!$this->messaging) {
                \Log::warning('FCM messaging client not initialized. Skipping notification.');
                return false;
            }

            if (empty($token)) {
                \Log::error('FCM TOKEN NULL OR EMPTY');
                return false;
            }

            \Log::info('FCM SEND START', [
                'token' => substr($token, 0, 20) . '...',
                'title' => $title,
                'body'  => $body,
            ]);

            $url = url($targetUrl);

            $message = CloudMessage::withTarget('token', (string)$token)
                ->withNotification(Notification::create($title, $body))
                ->withData([
                    'title' => (string)$title,
                    'body'  => (string)$body,
                    'click_action' => $url,
                ])
                ->withWebPushConfig([
                    'notification' => [
                        'title' => (string)$title,
                        'body'  => (string)$body,
                        'icon'  => asset('/images/icons/icon-192x192.png'),
                        'badge' => asset('/images/icons/icon-72x72.png'),
                    ],
                    'fcm_options' => [
                        'link' => $url,
                    ],
                ])
                ->withApnsConfig([
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => (string)$title,
                                'body'  => (string)$body,
                            ],
                            'sound' => 'default',
                            'badge' => 1,
                        ],
                    ],
                ]);

            $this->messaging->send($message);

            \Log::info('FCM SEND SUCCESS', ['title' => $title]);
            return true;

        } catch (\Throwable $e) {
            \Log::error('FCM SEND FAILED', [
                'error' => $e->getMessage(),
                'title' => $title
            ]);
            return false;
        }
    }
}