<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Purchase;
use App\Models\Rating;
use App\Models\Rental;
use App\Models\User;

class PropertyController extends Controller
{
    public function properties()
    {
        $properties = Property::with('province')->get();
        return response()->json($properties);
    }
    public function property_details(Request $request)
    {
        $property = Property::with('images.province')->find($request->property_id);
        if (!$property) {
            return response()->json(['message' => 'العقار غير موجود'], 404);
        }
        $allratings = Rating::where('property_id', $request->property_id)->pluck('rating');
        $avgratings = $allratings->avg();

        return response()->json([
            'property' => $property,
            'average_rating' => round($avgratings, 1),
        ], 200);
    }
    public function destroy(Request $request)
    {
        $admin = Auth::user();
        $property = Property::where('id', $request->property_id)->first();
        if (!$request->has('property_id')) {
            return response()->json(['message' => 'رقم العقار غير موجود'], 400);
        }
        $property->name_admin = $admin->name;
        $property->save();
        $property->delete();
        return response()->json(['meesage' => 'تم ارشفة العقار'], 200);
    }
    public function show_archived()
    {
        $admin = Auth::user();
        $archivedProperties = Property::onlyTrashed()->with('province')->get()->makeHidden(['name_admin']);
        if ($admin->type == 'superadmin')
            $archivedProperties = Property::onlyTrashed()->with('province')->get();

        return response()->json(['archived_properties' => $archivedProperties], 200);
    }

    public function show_sellers_accounts()
    {
        $sellers_account = User::where('type', 'seller')->get();
        if ($sellers_account->isEmpty()) {
            return response()->json(['message' => 'لا يوجد بائعون مسجلون حالياً'], 200);
        }
        return response()->json($sellers_account);
    }

    public function properties_purchase_rental_booking()
    {
        $purchases = Purchase::with('property.user')->get();
        $bookings = Booking::with('property.user')->get();
        $rentals = Rental::with('property.user')->get();
        return response()->json([
            'purchased_properties' => $purchases,
            'booked_properties'    => $bookings,
            'rented_properties'    => $rentals,
        ], 200);
    }
}