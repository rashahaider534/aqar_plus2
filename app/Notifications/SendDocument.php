<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDocument extends Notification
{
    use Queueable;
     protected $purchase,$sellername;
    /**
     * Create a new notification instance.
     */
    public function __construct($purchase,$sellername)
    {
        $this->purchase = $purchase;
        $this->sellername=$sellername;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('مرحبًا ' .$this->purchase->full_name)
            ->line('تم نقل ملكية العقار إليك بنجاح.')
            ->line('من السيد :'.$this->sellername)
            ->line('اسم العقار: ' . $this->purchase->property->name)
            ->line('تاريخ الشراء: ' . $this->purchase->purchase_date->format('Y-m-d'))
            ->line('المبلغ المدفوع: ' . number_format($this->purchase->property->final_price) . ' ل.س')
            // ->action('عرض تفاصيل العقار', url('/properties/' . $this->purchase->property_id))
            ->line('شكرًا لاستخدامك منصتنا!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
