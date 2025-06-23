<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendPriceMaintenanceNotification extends Notification
{
    use Queueable;

    public $price;
    public $period;
    public $name_property;
    public $type_maintenance;
    public function __construct($price, $period, $name_property, $type_maintenance)
    {
        $this->price = $price;
        $this->period = $period;
        $this->name_property = $name_property;
        $this->type_maintenance = $type_maintenance;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => 'تم النظر في مشكلة الصيانة التي من نوع ' . $this->type_maintenance .
                ' للعقار ' . $this->name_property .
                '، حيث بلغ سعر الصيانة ' . $this->price . ' دولار' .
                '، بمدة تتراوح إلى ' . $this->period . ' يوم.',
            'time' => now()
        ];
    }
}
