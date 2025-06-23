<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\Rating;
use App\Models\User;

class PropertyController extends Controller
{
    public function properties()
    {
        $properties = Property::all();
        return response()->json($properties);
    }
    public function property_details(Request $request)
    {
        $property = Property::with('images')->find($request->property_id);
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
        $property = Property::where('id', $request->property_id)->first();
        if (!$request->has('property_id')) {
            return response()->json(['message' => 'رقم العقار غير موجود'], 400);
        }
        $property->delete();
        session()->flash('delete_at');
        return response()->json(['meesage' => 'تم ارشفة العقار'], 200);
    }
    public function show_archived()
    {
        $archivedProperties = Property::onlyTrashed()->with('province')->get();

        return response()->json(['archived_properties' => $archivedProperties], 200);
    }
   

}
