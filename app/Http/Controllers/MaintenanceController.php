<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Property;
use App\Models\User;
use App\Notifications\SendPriceMaintenanceNotification;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function fixCost(Request $request){

       $request->validate([
        'price' => ['required', 'numeric', 'gt:0'],
        'period' => ['required', 'numeric', 'gt:0'],
    ], [
        'price.required' => 'يجب إدخال السعر.',
        'price.numeric'  => 'يجب أن يكون السعر رقمًا.',
        'price.gt'       => 'يجب أن يكون السعر أكبر من صفر.',

        'period.required' => 'يجب إدخال المدة.',
        'period.numeric'  => 'يجب أن يكون المدة رقمًا.',
        'period.gt'       => 'يجب أن يكون المدة أكبر من صفر.',
    ]);
        $price=$request->price;
        $period=$request->period;
        $maintenance=Maintenance::find($request->maintenance_id);
        $maintenance->price=$price;
        $maintenance->period=$period;
        $maintenance->save();
        $property=Property::find($maintenance->property_id);
        $user= User::find($maintenance->user_id);
        $user->notify(new SendPriceMaintenanceNotification($price,$period,$property->name,$maintenance->type), now());
            return response()->json(['message'=>'تم ارسال الطلب بنجاح'],200);

        
    }
}
