<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AddPropertyNotification extends Notification
{
    use Queueable;

    public $sellerName;

    public function __construct($sellerName)
    {
        $this->sellerName = $sellerName;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "قام البائع {$this->sellerName} بإضافة عقار جديد.",
             'time'=>now()
        ];
    }
}