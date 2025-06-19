<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class charge_balance extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $balance;
    public function __construct($balance)
    {
        $this->balance=$balance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }



    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
         return [
            'type' => 'charge',
            'message' => 'تم شحن رصيدك  بمبلغ قدره "' . $this->balance ,
            'time' => now(),
        ];
    }
}
