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

class DayEndNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private int $league;

    public function __construct(int $league) {
        $this->league = $league;
    }

    public function via($notifiable) {
        $activated = array();
        if (config('join_sms.enable') && !is_null($notifiable->phone))
            $activated[] = JoinSmsChannel::class;
        if (!is_null($notifiable->join_key))
            $activated[] = JoinChannel::class;

        return $activated;
    }

    public function toPush($notifiable) {
        return (new PushMessage())
            ->title("Der Spieltag ist zuende")
            ->line("Es sind nun alle Daten des Spieltages für die ".$this->league.". Bundesliga vorhanden.")
            ->line("Schau gleich nach, auf welchem Platz du bist.")
            ->icon(asset('/images/logo'.$this->league.'.png'))
            ->link(route('dashboard'));
    }

    public function toSMS($notifiable) {
        return (new SmsMessage())
            ->line("[Bundesliga Tippspiel]")
            ->line("Der Spieltag ist zuende")
            ->line("Es sind nun alle Daten des Spieltages für die ".$this->league.". Bundesliga vorhanden.")
            ->line("Schau gleich nach, auf welchem Platz du bist.");
    }
}
