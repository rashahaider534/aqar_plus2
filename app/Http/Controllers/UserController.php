<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\charge_balance;
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
                    ? asset('storage/' . $user->profile_photo)
                    : null,
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
        if (!$file->isValid() || !in_array($file->extension(), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
        {
            return response()->json(['message' => 'الملف المرفوع ليس صورة صالحة'], 400);
        }
        $user->update([
            'profile_photo' => $path
        ]);

        return response()->json(['meesage' => 'تم تعديل الصورة بنجاح'], 200);
    }
    public function searchUser(Request $request){
        $name=$request->name;
        $users=User::all();
        $request_users=array();
        foreach($users as $user){
            if(str_contains(strtolower($user->name),strtolower($name)))
            array_push($request_users,$user);
        }
        return response()->json($request_users, 200);

    }
    public function Charge_balance(Request $request)
    {
        $user=Auth::user();
        $balance=$request->balance;
        $user->balance += $balance;
        $user->save();
        $user->notify(new charge_balance( $balance, now()));
        return response()->json(['meesage'=>'تم شحن رصيد'],200);
    }
}
