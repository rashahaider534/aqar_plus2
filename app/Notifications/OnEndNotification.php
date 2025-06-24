<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OnEndNotification extends Notification
{
    use Queueable;


    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }


    public function toArray(object $notifiable): array
    {
        return [
            "message" => "لقد انتهت مدة الحجز، يرجى الخروج من العقار.",
            'time' => now()
        ];
    }
}