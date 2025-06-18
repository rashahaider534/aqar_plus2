<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendDocument extends Notification
{
    use Queueable;

    protected $purchase, $sellername;

    /**
     * Create a new notification instance.
     */
    public function __construct($purchase, $sellername)
    {
        $this->purchase = $purchase;
        $this->sellername = $sellername;
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
        $buyer = $this->purchase->full_name;
        $seller = $this->sellername;
        $property = $this->purchase->property->name;
        $date = $this->purchase->purchase_date->format('Y-m-d');
        $amount = number_format($this->purchase->property->final_price);

        $document = <<<EOD
في هذا اليوم الموافق {$date}، تم الاتفاق بين:

الطرف الأول: السيد/السيدة {$seller} (المالك الحالي)،  
والطرف الثاني: السيد/السيدة {$buyer} (المشتري الجديد)،

حيث أقر الطرف الأول بأنه قد باع ونقل إلى الطرف الثاني العقار المسمى "{$property}" نقلاً كاملاً ونهائيًا، وتم الاتفاق على مبلغ قدره {$amount} ل.س، وتم دفعه بالكامل من قبل الطرف الثاني.

ويقر الطرف الثاني بقبوله نقل الملكية ويتعهد بتحمل كافة الالتزامات القانونية والمالية المتعلقة بالعقار اعتبارًا من تاريخ الشراء.

تم تحرير هذه الوثيقة والتوقيع عليها من الطرفين بكامل إرادتهما.

مع تحياتنا،
فريق المنصة.
EOD;

        return (new MailMessage)
            ->greeting('مرحبًا ' . $buyer)
            ->line('تم نقل ملكية العقار إليك بنجاح.')
            ->line($document)
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

