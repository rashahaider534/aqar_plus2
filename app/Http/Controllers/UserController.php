<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function showprofile()
    {
         $user = Auth::user();
         return response()->json(
            [
                'name'=>$user->name,
                'email' => $user->email,
                'balance' => $user->balance,
                'phone'=>$user->phone,
                'profile_photo'=>$user->profile_photo
                 ? asset('storage/profile_photos/'  . $user->profile_photo)
                 : null,
            ]
            );
    }
    public function  updatephoto()
    {
        
    }
}
