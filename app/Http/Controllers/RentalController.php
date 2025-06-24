<?php

namespace App\Http\Controllers;

use App\Jobs\FiveDaysEndJob;
use App\Jobs\OnEndJob;
use App\Models\Property;
use App\Models\Rental;
use App\Models\User;
use App\Notifications\FiveDaysEndNotification;
use App\Notifications\OnEndNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
    public function show_rental()
    {
        $user = Auth::user();
        $rental = Rental::with('property.images')->where('user_id', $user->id)->get();
        return response()->json(['rental' => $rental], 200);
    }
    public function renting(Request $request){
        $user = Auth::user();
        $property = Property::where('id', $request->property_id)->first();
        $rent_price=$property->final_price;
        $seller = User::where('id', $property->seller_id)->first();
        if ($rent_price > $user->balance)
            return response()->json(['message' => 'ليس لديك مال كافي لاستئجار'], 401);
        else {
            $seller->balance = $seller->balance + $rent_price;
            $seller->save();

            $user->update([
                'balance' => $user->balance - $rent_price
            ]);
              if ($request->hasFile('ownership_image')) {
            $file = $request->file('ownership_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('Personal identity', $fileName, 'public'); // Saves in storage/app/public/ownership_doc
        }
            $renting =  Rental::create([
                'property_id' => $property->id,
                'user_id' => Auth::id(),
                'end_rentals' => now()->addMonth($property->month)->toDateString(),
                'active' => 1,
                'full_name'=>$request->full_name,
                'National Number'=>$request->National_Number,
                'image_file'=>asset('storage/' . $filePath),
            ]);
            $endtime=now()->addMonth($property->month);
            $property->update([
                'status' => 'rented'
            ]);
           // OnEndJob::dispatch($user)->delay(now()->addMonth($property->month));
           // FiveDaysEndJob::dispatch($user)->delay($endtime->copy()->subDays(5));
           OnEndJob::dispatch($user)->delay(now()->addMinute(2));
            FiveDaysEndJob::dispatch($user)->delay(now()->addMinute());
            return response()->json(['message' => 'تم دفع الاجار بنجاح',] ,200);
            
            
    }
}
}