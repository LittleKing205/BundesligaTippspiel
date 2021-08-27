<?php

namespace App\Notifications;

use App\Channels\JoinChannel;
use App\Channels\WebPushChannel;
use App\Messages\PushMessage;
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
        return [JoinChannel::class, WebPushChannel::class];
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
}
