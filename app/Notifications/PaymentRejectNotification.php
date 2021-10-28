<?php

namespace App\Notifications;

use App\Messages\PushMessage;
use App\Messages\SmsMessage;
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
        $this->bill = $bill;
    }

    public function via($notifiable) {
        return $notifiable->getNotificationChannel();
    }

    public function toSMS($notifiable) {
        return (new SmsMessage)
                    ->line("Der Kassenwart hat eine Zahlung zurückgezogen. Bitte überprüfe dies und veranlasse gegebenenfalls eine neue Zahlung.")
                    ->line("")
                    ->line("Liga / Spieltag: ".$this->bill->league.". Bundesliga / ".$this->bill->day.". Spieltag")
                    ->line("Betrag: ".number_format($this->bill->to_pay, 2, ",", ".")." €");
    }

    public function toPush($notifiable) {
        return (new PushMessage)
                    ->title("Deine Zahlung wurde zurückgezogen")
                    ->line("Der Kassenwart hat eine Zahlung zurückgezogen. Bitte überprüfe dies und veranlasse gegebenenfalls eine neue Zahlung.")
                    ->line("")
                    ->line("Liga / Spieltag: ".$this->bill->league.". Bundesliga / ".$this->bill->day.". Spieltag")
                    ->line("Betrag: ".number_format($this->bill->to_pay, 2, ",", ".")." €")
                    ->link(route('statistics'))
                    ->icon(asset('/images/logo.png'));
    }
}
