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

class TestNotification extends Notification
{

    public function __construct() {
    }

    public function via($notifiable) {
        $activated = array();
        if (config('join_sms.enable') && !is_null($notifiable->phone))
            $activated[] = JoinSmsChannel::class;
        if (!is_null($notifiable->join_key))
            $activated[] = JoinChannel::class;
        if (config('firebase.enable') && !is_null($notifiable->device_key))
            $activated[] = WebPushChannel::class;

        return $activated;
    }

    public function toSMS($notifiable) {
        return (new SmsMessage())
            ->line("[Bundesliga Tippspiel]")
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
