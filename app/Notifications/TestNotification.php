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

class TestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct() {
    }

    public function via($notifiable) {
        return $notifiable->getNotificationChannel();
    }

    public function toSMS($notifiable) {
        return (new SmsMessage())
            ->line("Dies ist eine Benachrichtigung, um den Dienst zu Testen");
    }

    public function toPush($notifiable) {
        return (new PushMessage())
            ->title("Bundesliga Tippspiel Testbenachrichtigung")
            ->line("Dies ist eine Benachrichtigung, um den Dienst zu Testen")
            ->link(route('home'))
            ->icon(asset('/images/logo.png'));
    }
}
