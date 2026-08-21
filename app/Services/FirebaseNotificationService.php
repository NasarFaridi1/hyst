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

    public function send($token, $title, $body, $targetUrl = '/my-orders', $soundUrl = null)
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

            // Resolve sound file name and full URL
            $soundFileName = 'hyst_notification.mp3';
            if (!empty($soundUrl)) {
                $soundFileName = basename($soundUrl);
                if (!str_starts_with($soundUrl, 'http://') && !str_starts_with($soundUrl, 'https://')) {
                    $soundUrl = asset('sounds/' . ltrim($soundFileName, '/'));
                }
            } else {
                $soundUrl = asset('sounds/hyst_notification.mp3');
            }

            \Log::info('FCM SEND START', [
                'token' => substr($token, 0, 20) . '...',
                'title' => $title,
                'body'  => $body,
                'sound' => $soundFileName,
            ]);

            $url = url($targetUrl);

            $message = CloudMessage::withTarget('token', (string)$token)
                ->withNotification(Notification::create($title, $body))
                ->withData([
                    'title'        => (string)$title,
                    'body'         => (string)$body,
                    'click_action' => $url,
                    'sound_url'    => $soundUrl,
                    'sound'        => $soundFileName,
                ])
                ->withWebPushConfig([
                    'headers' => [
                        'Urgency' => 'high',
                    ],
                    'notification' => [
                        'title' => (string)$title,
                        'body'  => (string)$body,
                        'icon'  => asset('/images/icons/icon-192x192.png'),
                        'badge' => asset('/images/icons/icon-72x72.png'),
                        'sound' => $soundUrl,
                    ],
                    'fcm_options' => [
                        'link' => $url,
                    ],
                ])
                ->withApnsConfig([
                    'headers' => [
                        'apns-priority'  => '10',
                        'apns-push-type' => 'alert',
                    ],
                    'payload' => [
                        'aps' => [
                            'alert' => [
                                'title' => (string)$title,
                                'body'  => (string)$body,
                            ],
                            'sound'             => $soundFileName,
                            'badge'             => 1,
                            'content-available' => 1,
                            'mutable-content'   => 1,
                            'url'               => $url,
                            'sound_url'         => $soundUrl,
                        ],
                    ],
                ]);

            $this->messaging->send($message);

            \Log::info('FCM SEND SUCCESS', ['title' => $title]);
            return true;

        } catch (\Throwable $e) {
            $errorMsg = $e->getMessage();
            \Log::error('FCM SEND FAILED', [
                'error' => $errorMsg,
                'title' => $title
            ]);

            // Automatically clear dead/unregistered token from database so it doesn't cause recurring failures
            if (
                str_contains($errorMsg, 'Device unregistered') ||
                str_contains($errorMsg, 'NotRegistered') ||
                str_contains($errorMsg, 'NotFound') ||
                str_contains($errorMsg, 'InvalidArgument') ||
                str_contains($errorMsg, 'unregistered')
            ) {
                \Log::warning('Clearing invalid/unregistered FCM token from database: ' . substr($token, 0, 20) . '...');
                \App\Models\User::where('fcm_token', $token)->update(['fcm_token' => null]);
            }

            return false;
        }
    }
}