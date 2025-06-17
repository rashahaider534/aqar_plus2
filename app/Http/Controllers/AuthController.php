<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\welcome;
use App\Models\Admin;
use App\Models\Block;
use App\Models\Rejected;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{

 public function register_user(RegisterRequest $request)
    {
        $filePath = null;//profile_photos/default_profile_photo.png
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('profile_photos', $fileName, 'public'); // Saves in storage/app/public/profile_photos
        }
         $code=rand(10000,99999);
        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'profile_photo' => $filePath,
            'email'=>$request->email,
            'code'=>$code,
            'balance'=>1000
        ]);
        $token = $user->CreateToken('user_active')->plainTextToken;
        Mail::to($user->email)->send(new welcome($code));
        return response()->json([
            'message' => 'تم إنشاء حساب',
            'token' => $token
        ], 201);
    }
 public function login_user(LoginRequest $request) {
        $user=User::where('name', $request->name)->first();
        if(!$user)
          return response()->json(['message'=>'الاسم غير موجود'],401);
        if(!Hash::check($request->password, $user->password))
          return response()->json(['message'=>'كلمة السر خاطئة'],401);
        if(!$user->in_code)
         return response()->json(['message'=>'قم بتأكيد بريدك الالكتروني'],401);
         if($user->block)
         return response()->json(['message'=>'نعتذر ولكن حسابك محظور',401]);
         $token = $user->createToken('user_active')->plainTextToken;
          return response()->json([
        'message' => 'تم تسجيل الدخول',
        'token' => $token
         ], 200);
     }
 public function login_admin(LoginRequest $request)  {
     $admin=Admin::where('name', $request->name)->first();
        if(!$admin)
          return response()->json(['message'=>'الاسم غير موجود'],401);
        if(!Hash::check($request->password, $admin->password))
          return response()->json(['message'=>'كلمة السر خاطئة'],401);
         $token = $admin->createToken('user_active')->plainTextToken;
          return response()->json([
        'message' => 'تم تسجيل الدخول',
        'token' => $token
         ], 200);
     }
 public function logout(Request  $request){
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'logout successfully'],200);
         }
 public function checkcode(Request  $request){
        $user=Auth::user();
        $code=$request->code;
       if($code==$user->code)
       {
        $user->update([
            'in_code'=>1
        ]);
        return response()->json([
            'message' => 'correct code',
        ], 200);
       }
       else
       return response()->json([
        'message' => 'Incorrect code',
      ], 422);
    }
    
}
