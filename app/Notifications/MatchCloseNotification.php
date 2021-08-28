<?php

namespace App\Notifications;

use App\Channels\JoinChannel;
use App\Channels\JoinSmsChannel;
use App\Channels\WebPushChannel;
use App\Messages\PushMessage;
use App\Messages\SmsMessage;
use App\Models\Game;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class MatchCloseNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private Game $match;

    public function __construct(Game $match) {
        $this->match = $match;
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

    public function toPush($notifiable) {
        return (new PushMessage())
            ->title("Ein Spiel wird gleich gesperrt")
            ->line($this->match->team1->name.' - '.$this->match->team2->name)
            ->line("Das Spiel beginnt um ".$this->match->match_start->format('H:i')." und ist gesperrt ab ".$this->match->match_start->subHours(2)->format('H:i').".")
            ->line("Jetzt noch schnell Tippen!")
            ->icon(asset('/images/logo'.$this->match->league.'.png'))
            ->link(route('tipps', [$this->match->league, $this->match->day])."#".$this->match->id);
    }

    public function toSMS($notifiable)
    {
        return (new SmsMessage())
            ->line("[Bundesliga Tippspiel]")
            ->line($this->match->team1->name . ' - ' . $this->match->team2->name)
            ->line("Das Spiel beginnt um " . $this->match->match_start->format('H:i') . " und ist gesperrt ab " . $this->match->match_start->subHours(2)->format('H:i') . ".")
            ->line("Jetzt noch schnell Tippen!")
            ->line("")
            ->line(route("tipps", ["league" => $this->match->league, "day" => $this->match->day]));
    }
}
