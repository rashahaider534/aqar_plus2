<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Models\User;
use App\Notifications\BookingEndNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class BookingEnd implements ShouldQueue
{
    use Queueable;
     public $booking_id;
     public $user_id;
      public $proprty_name;
    public function __construct($booking_id,$user_id,$proprty_name)
    {
        $this->booking_id=$booking_id;
        $this->user_id=$user_id;
        $this->proprty_name=$proprty_name;
    }

   public function handle(): void
    {
     $booking=Booking::where('id',$this->booking_id)->first();
        if(!$booking->active)
        return;
    else{
        $user=User::where('id',$this->user_id)->first();
        $user->notify(new BookingEndNotification($this->proprty_name));
   }

        
    }
}
