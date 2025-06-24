<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    public function unread_user(){
        $notifications=Auth::user()->unreadNotifications;
        return response()->json($notifications, 200);
    }
     public function unread_admin(Request $request){
        $notifications=$request->user()->unreadNotifications;
        return response()->json($notifications, 200);
    }
    public function markAllAsRead_user()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'تم تعليم كل الإشعارات كمقروءة']);
    }
    public function markAllAsRead_admin(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();
        return response()->json(['message' => 'تم تعليم كل الإشعارات كمقروءة']);
    }
      public function markAsRead_user(Request $request)
    {
        $notification = Auth::user()->notifications()->find($request->notification_id);

            $notification->markAsRead();
            return response()->json(['message' => 'تم التعليم كمقروء']);
    }
       public function markAsRead_admin(Request $request)
    {
        $notification = Auth::user()->notifications()->find($request->notification_id);

            $notification->markAsRead();
            return response()->json(['message' => 'تم التعليم كمقروء']);
    }
    
}