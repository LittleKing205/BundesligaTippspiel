<?php

namespace App\Channels;

use App\Models\User;
use Illuminate\Notifications\Notification;

class WebPushChannel
{
    public function send($notifiable, Notification $notification) {
        $message = $notification->toPush($notifiable);
        $url = 'https://fcm.googleapis.com/fcm/send';
        $FcmToken = $notifiable->device_key;
        $serverKey = env('FIREBASE_SERVER_KEY');

        $data = [
            "notification" => [
                "title" => $message->getTitle(),
                "body" => $message->getMessage(),
                "icon" => $message->getIcon(),
                "click_action" => $message->getLink()
            ],
            "to" => $FcmToken
        ];

        $encodedData = json_encode($data);

        $headers = [
            'authorization:key=' . $serverKey,
            'content-type:application/json'
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);

        // Execute post
        $result = curl_exec($ch);

        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        // Close connection
        curl_close($ch);
    }
}
