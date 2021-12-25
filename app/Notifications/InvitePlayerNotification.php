<?php

namespace App\Notifications;

use App\Channels\JoinSmsChannel;
use App\Messages\SmsMessage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvitePlayerNotification extends Notification
{
    use Queueable;
    private $channel;
    private $to;

    public function __construct($channel, $to) {
        $this->channel = $channel;
        $this->to = $to;
    }

    public function via($notifiable) {
        $via = array();
        switch ($this->channel) {
            case 'SMS':
                $via[] = JoinSmsChannel::class;
                break;

            default:
                throw new \Exception("Es wurde kein Valider Channel ausgewählt.");
                break;
        }

        return $via;
    }

    public function toSms($notifiable) {
        return (new SmsMessage)
            ->toNumber($this->to)
            ->line("Hallo. Du wurstest von " . $notifiable->name . " zum Tippspiel eingeladen.")
            ->line("Unter der Folgenden Adresse kannst du dich registrieren, um mitzutippen.")
            ->line("Viel Glück")
            ->line("")
            ->line(route('register', ['invite' => $notifiable->currentGroup->invite_code]));
    }
}
