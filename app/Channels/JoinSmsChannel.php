<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class JoinSmsChannel
{
    public function send($notifiable, Notification $notification) {
        if (!config('join_sms.enable'))
            return;

        $message = $notification->toSMS($notifiable);
        $number = null;

        if ($message->getToNumber() == null) {
            $number = $notifiable->phone;
        } else {
            $number = $message->getToNumber();
        }

        if ($number == null)
            return;

        HTTP::get("https://joinjoaomgcd.appspot.com/_ah/api/messaging/v1/sendPush?apikey=".config('join_sms.api_key')."&smsnumber=".$number."&smstext=".$message->getMessage()."&deviceId=".config('join_sms.device_id'));
    }
}
