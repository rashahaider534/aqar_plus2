<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Purchase;
use App\Models\Admin;
use App\Models\User;

class PurchaseController extends Controller
{
    public  function Purchase(Request $request, $id)
    {
        $user = Auth::user();
        $property = Property::findOrFail($id);
        $price = $property->final_price;
        $commission = $price * 0.03; // 3%
        $purchprice = $price - $commission;
        if ($user->balance < $price) {
            return response()->json(['message' => 'ليس لديك رصيد كافي يرجى شحن حسابك', 400]);
        }
        if ($property->status == 'Sold') {
            return response()->json(['message' => 'العقار تم بيعه ', 400]);
        }
        $user->balance -= $price;
        $user->save();

        $superAdmin = Admin::find(1);
        if ($superAdmin) {
            $superAdmin->balance += $commission;
            $superAdmin->save();
        }

        $seller = User::find($property->seller_id);
        $seller->balance += $purchprice;
        $seller->save();

        $property->status = 'Sold';
        $property->seller_id = $user->id;
        $property->save();

        $filePath = null;
        if ($request->hasFile('image_file')) {
            $file = $request->file('image_file');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('images', $fileName, 'public'); // Saves in storage/app/public/profile_photos
        }
        Purchase::create([
            'user_id' => $user->id,
            'property_id' => $property->id,
            'full_name' => $request->full_name,
            'National_Number' => $request->National_Number,
            'purchase_date' => now(),
            'identity_document' => 'wee',
            'image_file' => $filePath,
        ]);
        return response()->json(['message' => 'تمت عملية الشراء بنجاح']);
    }
}
