<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class Soldtoseller extends Notification
{
    use Queueable;

    protected $purchase, $purchprice;
    /**
     * Create a new notification instance.
     */
    public function __construct($purchase, $purchprice)
    {
        $this->purchase = $purchase;
        $this->purchprice = $purchprice;
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
            'type' => 'sold',
            'message' => 'تم بيع العقار "' . $this->purchase->property->name . '" الخاص بك. تم تحويل مبلغ بقيمة "' . $this->purchprice . '" إلى حسابك.',
            'time' => now(),
        ];
    }
}
