<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Block;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\charge_balance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class UserController extends Controller
{
    public function showprofile()
    {
        $user = Auth::user();
        return response()->json(
            [
                'name' => $user->name,
                'email' => $user->email,
                'balance' => $user->balance,
                'phone' => $user->phone,
                'profile_photo' => $user->profile_photo

            ],
            200
        );
    }
    public function  updatephoto(Request $request)
    {
        $user = Auth::user();
        if (!$request->hasFile('profile_photo')) {
            return response()->json(['meesage' => 'يرجى ادخال صورة'], 400);
        }
        if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
            Storage::disk('public')->delete($user->profile_photo);
        }
        $file = $request->file('profile_photo');
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profile_photos', $fileName, 'public');
        //تحقق من ان الملف المرفوع صورة
        if (!$file->isValid() || !in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
            return response()->json(['message' => 'الملف المرفوع ليس صورة صالحة'], 400);
        }
        $user->update([
            'profile_photo' => asset('storage/' . $path)
        ]);

        return response()->json(['meesage' => 'تم تعديل الصورة بنجاح'], 200);
    }
    public function searchUser(Request $request)
    {
        $name = $request->name;
        $users = User::all();
        $request_users = array();
        foreach ($users as $user) {
            if (str_contains(strtolower($user->name), strtolower($name)))
                array_push($request_users, $user);
        }
        return response()->json($request_users, 200);
    }
    public function Charge_balance(Request $request)
    {
        $user = Auth::user();
        $balance = $request->balance;
        $user->balance += $balance;
        $user->save();
        $user->notify(new charge_balance($balance, now()));
        return response()->json(['meesage' => 'تم شحن رصيد'], 200);
    }

    public function Block(Request $request)
    {
        $admin = $request->user();
        $seller = User::find($request->seller_id);
        $refual_reason = $request->refual_reason;
        Block::create([
            'user_id' => $seller->id,
            'admin_id' => $admin->id,
            'description' => $refual_reason,
        ]);
        $seller->tokens()->delete();
        return response()->json(['meesage' => 'تم حظر البائع بنجاح'], 200);
    }
    public function pendingSellers()
    {
        $pendingSellers = User::where('consent', 'waiting')->where('type', 'seller')->get();
        $pendingSellers = User::where('consent', 'waiting')->where('type', 'seller')->get();
        return response()->json($pendingSellers, 200);
    }
    public function approveAccountSeller(Request $request)
    {
        $admin = $request->user();
        $superAdmin = Admin::find(1);
        if ($superAdmin) {
            $superAdmin->balance += 100;
            $superAdmin->save();
            $seller = User::find($request->seller_id);
            $seller->consent = 'requested';
            $seller->type = 'seller';
            $seller->name_admin = $admin->name;
            $seller->save();
            $superAdmin = Admin::find(1);
            if ($superAdmin) {
                $superAdmin->balance += 100;
                $superAdmin->save();
            }
            return response()->json(['meesage' => 'تم السماح للحساب بنجاح'], 200);
        }
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
    public function show_users_accounts()
    {
        $users = User::where('type', 'user')->get();
        if ($users->isEmpty())
        {
            return response()->json(['message' => 'لا يوجد مستخدمون حالياً'], 200);
        }
        return response()->json(['users' => $users], 200);
    }
      public function count_users_accounts()
    {
        $count = User::where('type', 'user')->count();
        return response()->json(['countusers' => $count], 200);
    }
     public function show_sellers_accounts()
    {
        $sellers_account = User::where('type', 'seller')->get();
        if ($sellers_account->isEmpty()) {
            return response()->json(['message' => 'لا يوجد بائعون مسجلون حالياً'], 200);
        }
        return response()->json($sellers_account);
    }
      public function count_sellers_accounts()
    {
        $count = User::where('type', 'seller')->count();
        return response()->json(['countseller' => $count], 200);
    }
}
