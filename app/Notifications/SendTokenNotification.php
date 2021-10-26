<?php

namespace App\Notifications;

use App\Channels\JoinChannel;
use App\Channels\JoinSmsChannel;
use App\Channels\WebPushChannel;
use App\Messages\PushMessage;
use App\Messages\SmsMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SendTokenNotification extends Notification
{
    private string $number;
    private int $token;

    public function __construct(string $number, int $token) {
        $this->number = $number;
        $this->token = $token;
    }

    public function via($notifiable) {
        return [JoinSmsChannel::class];
    }

    public function toSMS($notifiable) {
        return (new SmsMessage())
            ->line("Dein SMS Code lautet: ".$this->token)
            ->toNumber($this->number);
    }
}
