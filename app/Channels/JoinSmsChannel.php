<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class JoinSmsChannel
{
    public function send($notifiable, Notification $notification) {
        $message = $notification->toSMS($notifiable);
        $number = null;

        if ($message->getToNumber() == null) {
            $number = $notifiable->phone;
        } else {
            $number = $message->getToNumber();
        }

        if ($number == null)
            return;

        HTTP::get("https://joinjoaomgcd.appspot.com/_ah/api/messaging/v1/sendPush?apikey=f3ccca8e7c4443a9b1d6bd18cd6e61e9&smsnumber=".$number."&smstext=".$message->getMessage()."&deviceId=e281abc46b9b4ed185c8024d7a987b60");
    }
}
