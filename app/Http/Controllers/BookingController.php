<?php

namespace App\Http\Controllers;

use App\Jobs\BookingEnd;
use App\Models\Admin;
use App\Models\Booking;
use App\Models\Property;
use App\Models\Purchase;
use App\Models\User;
use App\Notifications\SendDocument;
use App\Notifications\Soldtoseller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
class BookingController extends Controller
{
    public function booking(Request $request){
         $user=Auth::user();
         $property=Property::where('id',$request->property_id)->first();
         $booking_price=$property->final_price*0.2;
       $seller=User::where('id',$property->seller_id)->first();
         if($booking_price>$user->balance)
            return response()->json(['message'=>'ليس لديك مال كافي للحجز'],401);
        else{
             $seller->update([
             'balance'=>$seller->balance+$booking_price
            ]);
            $user->update([
             'balance'=>$user->balance-$booking_price
            ]);
          $booking=  Booking::create([
             'property_id'=>$property->id,
             'user_id'=>Auth::id(),
             'start_rentals'=>now()->toDateString(),
             'end_rentals'=>now()->addDays(5)->toDateString(),
             'active'=>1
            ]);
            $property->update([
                'status'=>'booked'
            ]);
            BookingEnd::dispatch($booking->id,$user->id,$property->name)->delay(now()->addMinute());
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
          $superAdmin = Admin::find(1);
        if ($superAdmin) {
            $superAdmin->balance += $superadmin_price;
            $superAdmin->save();
        }

        $user->balance -= $property->final_price-($property->final_price*0.2);
        $user->save();

        $seller = User::find($property->seller_id);
        $sellername=$seller->name;
        $seller->balance += $seller_price;
        $seller->save();

        $property->status = 'Sold';
        $property->seller_id = $user->id;
        $property->save();
        $booking->status='Sold';
        $booking->save();

        $filePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('images', $fileName, 'public'); // Saves in storage/app/public/profile_photos
        }
        $purchase = Purchase::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'full_name' => $request->full_name,
            'National_Number' => $request->National_Number,
            'purchase_date' => now(),
            'identity_document' => 'wee',
            'image_file' => $filePath,
        ]);

        Notification::send($user, new  SendDocument($purchase,$sellername));
        $user->notify(new Soldtoseller($purchase,$property->final_price-($property->final_price*0.03), now()));
        return response()->json(['message' => 'تمت عملية الشراء بنجاح']);
    }
     public function show_booking()
    {
        $user=Auth::user();
        $booking=Booking::with('property.images')->where('user_id',$user->id)->get();
        return response()->json(['booking'=>$booking],200);
    }
}
