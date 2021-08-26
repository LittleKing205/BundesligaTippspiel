<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class JoinChannel
{
    public function send($notifiable, Notification $notification) {
        $message = $notification->toPush($notifiable);
        $apiKey = $notifiable->join_key;

        if (is_null($apiKey))
            return;

        $response = Http::get("https://joinjoaomgcd.appspot.com/_ah/api/messaging/v1/sendPush?apikey=".$apiKey."&text=".$message->getMessage()."&title=".$message->getTitle().
            "&icon=".$message->getIcon()."&deviceId=group.all&url=".$message->getLink());
    }
}
