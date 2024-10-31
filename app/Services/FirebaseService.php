<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging;

class FirebaseService
{
    protected $messaging;

    public function __construct()
    {
        $factory = (new Factory)
            ->withServiceAccount(storage_path('app/firebase_credentials.json'))
            ->withDatabaseUri('https://billpebilling-default-rtdb.asia-southeast1.firebasedatabase.app'); // Replace with your Firebase database URL

        $this->messaging = $factory->createMessaging();
    }

    public function sendNotification($deviceToken, $title, $body, $data = [])
    {
        $notification = [
            'title' => $title,
            'body' => $body,
        ];

        if($deviceToken == null) {
            return false;
        }

        $message = Messaging\CloudMessage::withTarget('token', $deviceToken)
            ->withNotification($notification)
            ->withData($data);

        return $this->messaging->send($message);
    }
}
