<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function show_admins_accounts()
    {
        $admins = Admin::where('type', 'admin')->get();
        if ($admins->isEmpty()) {
            return response()->json(['message' => 'لا يوجد مشرفين حالياً'], 200);
        }
        return response()->json(['admins' => $admins], 200);
    }
    public function count_admins_accounts()
    {
        $count = Admin::where('type', 'admin')->count();
        return response()->json(['countadmins' => $count], 200);
    }
    public function searchAdmin(Request $request)
    {
        $name = $request->name;
        $users = Admin::all();
        $request_users = array();
        foreach ($users as $user) {
            if (str_contains(strtolower($user->name), strtolower($name)))
                array_push($request_users, $user);
        }
        return response()->json($request_users, 200);
    }
    public function addAdmin(Request $request)
    {

        $request->validate([
            'name' => ['required', 'unique:admins,name'],
            'password' => ['required', 'max:8'],
        ], [
            'name.required' => 'يجب ادخال الاسم',
            'name.unique'  => 'هذا الاسم موجود بالفعل',

            'password.required' => 'يجب ادخال كلمة السر',
            'password.max'  => 'يجب ان تكون كلمة السر اكبر من ثماني ارقام',
        ]);
        Admin::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'type' => 'admin',
        ]);
        return response()->json(['meesage' => 'تم اضافة المشرف بنجاح'], 200);
    }
    public function destroy_admin(Request $request)
    {
        $admin = Admin::where('id', $request->admin_id)
            ->where('type', 'admin')
            ->first();
        if (!$admin) {
            return response()->json(['message' => 'المشرف غير موجود'], 404);
        }
        $admin->forceDelete();
        return response()->json(['meesage' => 'تم حذف المشرف بنجاح', 200]);
    }
}
