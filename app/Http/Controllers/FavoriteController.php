<?php

namespace App\Http\Controllers;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Rating;

class FavoriteController extends Controller
{
    public function favorite(Request $request)
    {
        $user = Auth::user();
        $exists = DB::table('favorites')
            ->where('property_id', $request->property_id)
            ->where('user_id', $user->id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'العقار موجود بالفعل في المفضلة'], 409); // 409 Conflict
        }
        DB::table('favorites')->insert([
            'property_id' => $request->property_id,
            'user_id' => $user->id
        ]);
        return response()->json(['message' => 'تم الاضافة للمفضلة بنجاح'], 200);
    }
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favoriteProperties()->with('province','images')->get();
        if ($favorites->isEmpty()) {
            return response()->json([
                'message' => 'لا توجد عقارات مضافة إلى المفضلة حتى الآن.',
                'data' => []
            ], 200);
        }
        // إضافة تقييم المستخدم ومتوسط التقييم لكل عقار
        $favoritesWithRating = $favorites->map(function ($property) use ($user) {
            // جميع التقييمات لهذا العقار
            $allRatings = Rating::where('property_id', $property->id)->pluck('rating');
            $avgRating = $allRatings->avg();
            // تقييم المستخدم الحالي
            $userRating = Rating::where('property_id', $property->id)
                ->where('user_id', $user->id)
                ->value('rating');
            // إضافتهم للكائن
            $property->average_rating = $avgRating;
            $property->user_rating = $userRating;
            return $property;
        });

        return response()->json([
            'message' => 'قائمة العقارات المفضلة',
            'data' => $favoritesWithRating
        ], 200);
    }

    public function deletefavorite(Request $request)
    {
        $user = Auth::user();
        $user->favoriteProperties()->detach($request->property_id);
        return response()->json(['message' => 'تمت الإزالة من المفضلة']);
    }
}
