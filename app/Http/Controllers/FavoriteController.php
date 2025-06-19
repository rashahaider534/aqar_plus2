<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FavoriteController extends Controller
{
    public function favorite(Request $request)
    {
        $user = Auth::user();
        DB::table('favorites')->insert([
            'property_id' => $request->property_id,
            'user_id' => $user->id
        ]);
        return response()->json(['message' => 'تم الاضافة للمفضلة بنجاح'], 200);
    }
    public function index()
    {
        $user = Auth::user();
        $favorites = $user->favoriteProperties;
        if ($favorites->isEmpty()) {
            return response()->json([
                'message' => 'لا توجد عقارات مضافة إلى المفضلة حتى الآن.',
                'data' => []
            ], 200);
        }
        return response()->json($favorites);
    }
    public function deletefavorite(Request $request)
    {
        $user = Auth::user();
        $user->favoriteProperties()->detach($request->property_id);
        return response()->json(['message' => 'تمت الإزالة من المفضلة']);
    }
}
