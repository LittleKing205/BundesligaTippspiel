<?php

namespace App\Notifications;

use App\Messages\PushMessage;
use App\Messages\SmsMessage;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CustomMessage extends Notification
{
    use Queueable;
    private $lines = array();
    private $title;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $title = null) {
        if (is_null($title))
            $title = env('APP_NAME');
        $this->title = $title;

        if (is_array($message)) {
            $this->lines = $message;
        } else {
            $this->lines[] = $message;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->getNotificationChannel();
    }

    public function toPush($notifiable) {
        $message = new PushMessage();
        $message->icon(asset('/images/logo.png'))
            ->link(route('dashboard'))
            ->title($this->title);
        foreach($this->lines as $line) {
            $message->line($line);
        }
        return $message;
    }

    public function toSMS($notifiable) {
        $message = new SmsMessage();
        foreach($this->lines as $line) {
            $message->line($line);
        }
    }
}
