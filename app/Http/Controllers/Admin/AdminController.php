<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function show_admins_accounts()
    {
        $admins = Admin::where('type', 'admin')->get();
        if ($admins->isEmpty()) {
            return response()->json(['message' => 'لا يوجد ادمن حالياً'], 200);
        }
        return response()->json(['admins' => $admins], 200);
    }
    public function count_admins_accounts()
    {
        $count = Admin::where('type', 'admin')->count();
        return response()->json(['countadmins' => $count], 200);
    }
}
