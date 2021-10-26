<?php

namespace App\Notifications;

use App\Messages\PushMessage;
use App\Models\Bill;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentRejectNotification extends Notification
{
    use Queueable;

    private Bill $bill;

    public function __construct($bill)
    {
        $this->bill = $bill
    }

    public function via($notifiable)
    {
        $activated = array();
        if (config('join_sms.enable') && !is_null($notifiable->phone))
            $activated[] = JoinSmsChannel::class;
        if (!is_null($notifiable->join_key))
            $activated[] = JoinChannel::class;
        if (config('firebase.enable') && !is_null($notifiable->device_key))
            $activated[] = WebPushChannel::class;

        return $activated;
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toSMS($notifiable) {

    }

    public function toPush($notifiable) {
        return (new PushMessage)
            ->title("Deine Zahlung wurde zurückgezogen");
    }
}
