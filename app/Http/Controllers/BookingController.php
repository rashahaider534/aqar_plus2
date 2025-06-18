<?php

namespace App\Http\Controllers;

use App\Jobs\BookingEnd;
use App\Models\Booking;
use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function booking(Request $request){
         $user=Auth::user();
         $property=Property::where('id',$request->property_id)->first();
         $booking_price=$property->final_price*0.2;
         if($booking_price>$user->balance)
            return response()->json(['message'=>'ليس لديك مال كافي للحجز'],401);
        else{
            $user->update([
             'balance'=>$user->balance-$booking_price
            ]);
          $booking=  Booking::create([
             'property_id'=>$property->id,
             'user_id'=>Auth::id(),
             'start_rentals'=>now()->toDateString(),
             'end_rentals'=>now()->addDays(5)->toDateString()
            ]);
            $property->update([
                'status'=>'booked'
            ]);
            BookingEnd::dispatch($booking->id,$user->id,$property->name)->delay(now()->addDays(5));
            return response()->json(['message'=>'تم الحجز بنجاح'],201);
        }
    }
    public function cancelBooking(Request $request){
        $booking=Booking::where('id',$request->booking_id)->first();
        $property=Property::where('id',$booking->property_id)->first();
        $seller=User::where('id',$property->seller_id)->first();
         $property->update([
                'status'=>'available'
            ]);
        $seller->update([
             'balance'=>$seller->balance+$property->final_price*0.2
            ]);
             $booking->update([
                'status'=>'rejected',
                'active'=>0
            ]);     
            return response()->json(['message'=>'تم الغاء الحجز'],200); 
    }
    public function completeBooking(Request $request){
        $user=Auth::user();
        $booking=Booking::where('id',$request->booking_id)->first();
        $property=Property::where('id',$booking->property_id)->first();
        $seller=User::where('id',$property->seller_id)->first();
        if($property->final_price-($property->final_price*0.2)>$user->balance)
            return response()->json(['message'=>'ليس لديك مال كافي للحجز'],401);
        $superadmin_price=$property->final_price*0.03;
        $seller_price=($property->final_price-($property->final_price*0.2))-$superadmin_price;
    } 
}