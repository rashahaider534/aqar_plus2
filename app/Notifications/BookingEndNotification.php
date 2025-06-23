<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingEndNotification extends Notification
{
    use Queueable;

    public $proprty_name;
    public function __construct($proprty_name)
    {
        $this->proprty_name = $proprty_name;
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


    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'تم انهاء حجز عقار' . $this->proprty_name . 'الخاص بك',
            'time' => now()
        ];
    }
}
