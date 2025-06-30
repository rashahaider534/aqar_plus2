<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddPropertyRequest;
use App\Models\Admin;
use App\Models\Image;
use App\Models\Property;
use App\Models\Province;
use App\Models\Purchase;
use App\Models\Rating;
use App\Models\Rejected;
use App\Models\User;
use App\Notifications\AddPropertyNotification;
use App\Notifications\ApprovePropertyNotification;
use App\Notifications\RejectPropertyNotification;
use App\Notifications\PropertyPriceUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    public function addRating(Request $request)
    {
        $user = Auth::user();
        Rating::create([
            'property_id' => $request->property_id,
            'user_id' => $user->id,
            'rating' => $request->rating
        ]);
        return response()->json(['message' => 'تم اضافة التقيم بنجاح'], 200);
    }
    //no token
    public function filter(Request $request)
    {
         $properties = Property::with(['images', 'province'])
        ->where('status', 'available');

    if ($request->name)
        $properties->where('name', $request->name);

    if ($request->room)
        $properties->where('room', $request->room);

    if ($request->province) {
        $province = Province::where('string', $request->province)->first();
        if ($province)
            $properties->where('province_id', $province->id);
    }

    if ($request->price_start && $request->price_end)
        $properties->whereBetween('final_price', [$request->price_start, $request->price_end]);

    if ($request->area_start && $request->area_end)
        $properties->whereBetween('area', [$request->area_start, $request->area_end]);

    if ($request->type)
        $properties->where('type', $request->type);

    $properties = $properties->get();

    return response()->json($properties, 200);
}
    //user
    public function filter_user(Request $request)
    {
          $user = Auth::user();

      $properties = Property::with(['images', 'province'])
        ->where('status', 'available');

    if ($request->name)
        $properties->where('name', $request->name);

    if ($request->room)
        $properties->where('room', $request->room);

    if ($request->province) {
        $province = Province::where('string', $request->province)->first();
        if ($province)
            $properties->where('province_id', $province->id);
    }

    if ($request->price_start && $request->price_end)
        $properties->whereBetween('final_price', [$request->price_start, $request->price_end]);

    if ($request->area_start && $request->area_end)
        $properties->whereBetween('area', [$request->area_start, $request->area_end]);

    if ($request->type)
        $properties->where('type', $request->type);

    $properties = $properties->get();

    foreach ($properties as $property) {
        $property->is_favorite = DB::table('favorites')
            ->where('property_id', $property->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    return response()->json($properties, 200);
    }
    //admin and suberadmin
    public function filter_admin(Request $request)
    {  $properties = Property::with(['images', 'province'])
        ->where('status', 'available');

    if ($request->status)
        $properties->where('status', $request->status);

    if ($request->name_seller) {
        $seller = User::where('name', $request->name_seller)->first();
        if ($seller)
            $properties->where('seller_id', $seller->id);
    }

    if ($request->type)
        $properties->where('type', $request->type);

    return response()->json($properties->get(), 200);
    }

    //seller

    public function filter_seller(Request $request)
    {
        $user = Auth::user();

    $properties = Property::with(['images', 'province'])
        ->where('status', 'available')
        ->where('seller_id', '!=', $user->id);  

    if ($request->name)
        $properties->where('name', $request->name);

    if ($request->room)
        $properties->where('room', $request->room);

    if ($request->province) {
        $province = Province::where('string', $request->province)->first();
        if ($province)
            $properties->where('province_id', $province->id);
    }

    if ($request->price_start && $request->price_end)
        $properties->whereBetween('final_price', [$request->price_start, $request->price_end]);

    if ($request->area_start && $request->area_end)
        $properties->whereBetween('area', [$request->area_start, $request->area_end]);

    if ($request->type)
        $properties->where('type', $request->type);

    $properties = $properties->get();

    foreach ($properties as $property) {
        $property->is_favorite = DB::table('favorites')
            ->where('property_id', $property->id)
            ->where('user_id', $user->id)
            ->exists();
    }

    return response()->json($properties, 200);
    }


    public function waitProperties()
    {
        $properties = Property::where('status', 'waiting')->get();
        return response()->json($properties, 200);
    }
    public function reject_property(Request $request)
    {
        $user = $request->user();
        $property = Property::find($request->property_id);
        $refual_reason = $request->refual_reason;
        $property->status = 'rejected';
        $property->save();
        Rejected::create([
            'property_id' => $property->id,
            'admin_id' => $user->id,
            'description' => $refual_reason,
        ]);

        return response()->json(['message' => 'تم رفض العقار بنجاح'], 200);

        $seller = User::find($property->seller_id);
        $seller->notify(new RejectPropertyNotification($property->name));
        return response()->json(['message' => 'تم رفض العقار بنجاح'], 200);
    }
    public function approve_property(Request $request)
    {
        $admin = Auth::user();
        $property = Property::find($request->property_id);
        $property->name_admin = $admin->name;
        $property->status = 'available';
        $property->save();
        $seller = User::find($property->seller_id);
        $seller->notify(new ApprovePropertyNotification($property->name));
        return response()->json(['message' => 'تم الموافقة على العقار بنجاح'], 200);
    }

    public function show_rejecte_property()
    {
        $user = Auth::user();
        $rejecte_properties = Rejected::whereHas('property', function ($query) use ($user) {
            $query->where('seller_id', $user->id);
        })->with('property')->get();


        return response()->json($rejecte_properties, 200);
    }
    public function show_approve_property()
    {
        $user = Auth::user();
        $approve_properties = Property::where('seller_id', $user->id)
            ->where('status', 'available')
            ->get();
        return response()->json($approve_properties, 200);
    }
    public function property_details(Request $request)
    {
        $property = Property::with('images')->find($request->property_id);
        if (!$property) {
            return response()->json(['message' => 'العقار غير موجود'], 404);
        }
        $allratings = Rating::where('property_id', $request->property_id)->pluck('rating');
        $avgratings = $allratings->avg();
        $userrating = null;
        if (Auth::check()) {
            $user = Auth::user();
            $userrating = Rating::where('property_id', $request->property_id)
                ->where('user_id', $user->id)
                ->value('rating');
        }

        return response()->json([
            'property' => $property,
            'average_rating' => round($avgratings, 1),
            'user_rating' => $userrating
        ], 200);
    }

    public function destroy(Request $request)
    {
        $user = Auth::user();
        $property = Property::where('id', $request->property_id)
            ->where('status', 'available')
            ->where('seller_id', $user->id)->first();
        if (!$property) {
            return response()->json(['message' => 'العقار غير موجود أو غير متاح للحذف'], 404);
        }
        $property->delete();
        return response()->json(['meesage' => 'تم حذف العقار بنجاح'], 200);
    }

    public function getPropertyStatusReport(Request $request)
    {
        $count_property = Property::where('status', 'rejected')->where('status', 'waiting')->count();
        if ($count_property == 0)
            return response()->json([
                'count_property' => 0,
                'sold' => 0,
                'booked' => 0,
                'rejected' => 0,
            ], 200);
        $count_sold = Property::where('status', 'Sold')->count();
        $ans_sold = ($count_sold * 100) / $count_property;
        $count_booked = Property::where('status', 'booked')->count();
        $ans_booked = ($count_booked * 100) / $count_property;
        $count_rejected = Property::where('status', 'rejected')->count();
        $ans_rejected = ($count_rejected * 100) / $count_property;
        return response()->json([
            'count_property' => $count_property,
            'sold' => $ans_sold,
            'booked' => $ans_booked,
            'rejected' => $ans_rejected,
        ], 200);
    }

    public function profitsByMonth(Request $request)
    {
        $request->validate([
            'year' => 'required|integer|min:2000|max:' . now()->year,
        ]);
        $year = $request->year;
        $purchases = Purchase::with('property')
            ->whereYear('created_at', $year)
            ->get();
        $monthlyProfits = [];
        for ($i = 1; $i <= 12; $i++) {
            $month = str_pad($i, 2, '0', STR_PAD_LEFT);
            $monthlyProfits[$month] = 0;
        }

        foreach ($purchases as $purchase) {
            $month = $purchase->created_at->format('m');
            $finalPrice = $purchase->property->final_price ?? 0;
            $monthlyProfits[$month] += $finalPrice * 0.03;
        }

        return response()->json([
            'year' => $year,
            'profits' => $monthlyProfits,
        ], 200);
    }
    public function sellerSolded()
    {
        $seller = Auth::user();
        $properties = $seller->properties->where('status', 'Sold');
        return response()->json($properties, 200);
    }
    public function sellerRented()
    {
        $seller = Auth::user();
        $properties = $seller->properties->where('status', 'rented');
        return response()->json($properties, 200);
    }
    public function sellerBooked()
    {
        $seller = Auth::user();
        $properties = $seller->properties->where('status', 'booked');
        return response()->json($properties, 200);
    }
    public function sellerWaiting()
    {
        $seller = Auth::user();
        $properties = $seller->properties->where('status', 'waiting');
        return response()->json($properties, 200);
    }
    public function approvedSellerAdmin(Request $request)
    {
        $admin = Admin::find($request->admin_id);
        $sellers = User::where('name_admin', $admin->name)->get();
        return response()->json($sellers, 200);
    }

    public function update_price(Request $request)
    {
        $user = Auth::user();
        $property = Property::where('id', $request->property_id)
            ->where('seller_id', $user->id)
            ->first();
        if (!$property) {
            return response()->json(['message' => 'العقار غير موجود أو لا تملكه'], 404);
        }
        $property->update([
            'final_price' => $request->price
        ]);
        $favoriteUsers = $property->favoriteByUsers()->get();
        foreach ($favoriteUsers as $favUser) {
            $favUser->notify(new PropertyPriceUpdated($property));
        }
        return response()->json(['meesage' => '  تم تعديل السعر و ارسال اشعار للمهتمين'], 200);
    }
    public function addProperty(AddPropertyRequest $request)
    {
        $seller = Auth::user();
        if ($request->hasFile('ownership_image')) {
            $file = $request->file('ownership_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('ownership_doc', $fileName, 'public'); // Saves in storage/app/public/ownership_doc
        }
        $province = Province::where('string', $request->province)->first();
        if ($request->type == 'rent') {
            $property = Property::create([
                'seller_id' => $seller->id,
                'province_id' => $province->id,
                'name' => $request->name,
                'type' => $request->type,
                'ownership_image' => asset('storage/' . $filePath),
                'room' => $request->room,
                'final_price' => $request->final_price,
                'area' => $request->area,
                'description' => $request->description,
                'month' => $request->month
            ]);
            foreach ($request->file('images') as $img) {
                $path = $img->store('property_images', 'public');

                Image::create([
                    'property_id' => $property->id,
                    'image_path' => asset('storage/' . $path),
                ]);
            }
            $property = Property::with('images')->find($property->id);
            $admins = Admin::where('type', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new AddPropertyNotification($seller->name));
            }
        } else {
            $property = Property::create([
                'seller_id' => $seller->id,
                'province_id' => $province->id,
                'name' => $request->name,
                'type' => $request->type,
                'ownership_image' => asset('storage/' . $filePath),
                'room' => $request->room,
                'final_price' => $request->final_price + ($request->final_price * 0.03),
                'area' => $request->area,
                'description' => $request->description,

            ]);
            foreach ($request->file('images') as $img) {
                $path = $img->store('property_images', 'public');

                Image::create([
                    'property_id' => $property->id,
                    'image_path' => asset('storage/' . $path),
                ]);
            }
            $property = Property::with('images')->find($property->id);
            $admins = Admin::where('type', 'admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new AddPropertyNotification($seller->name));
            }
        }
        return response()->json(['meesage' => 'تم اضافة العقار بنجاح'], 200);
    }
}