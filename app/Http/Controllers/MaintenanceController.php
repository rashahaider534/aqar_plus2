<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Maintenance;
use App\Models\Property;
use App\Models\User;
use App\Notifications\AddMaintenanceNotification;
use App\Notifications\ApproveMaintenanceNotification;
use App\Notifications\ApprovePropertyNotification;
use App\Notifications\RejectMaintenanceNotification;
use App\Notifications\SendPriceMaintenanceNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MaintenanceController extends Controller
{
    public function fixCost(Request $request)
    {

        $request->validate([
            'price' => ['required', 'numeric', 'gt:0'],
            'period' => ['required', 'numeric', 'gt:0'],
        ], [
            'price.required' => 'يجب إدخال السعر.',
            'price.numeric'  => 'يجب أن يكون السعر رقمًا.',
            'price.gt'       => 'يجب أن يكون السعر أكبر من صفر.',


            'period.required' => 'يجب إدخال المدة.',
            'period.numeric'  => 'يجب أن يكون المدة رقمًا.',
            'period.gt'       => 'يجب أن يكون المدة أكبر من صفر.',
        ]);
        $price = $request->price;
        $period = $request->period;
        $maintenance = Maintenance::find($request->maintenance_id);
        $maintenance->price = $price;
        $maintenance->period = $period;
        $maintenance->status = 'responded';

        $maintenance->save();
        $property = Property::find($maintenance->property_id);
        $user = User::find($maintenance->user_id);
        $user->notify(new SendPriceMaintenanceNotification($price, $period, $property->name, $maintenance->type), now());
        return response()->json(['message' => 'تم ارسال الطلب بنجاح'], 200);
    }

    public function show_Maintenance_Requests()
    {
        $maintenances = Maintenance::with('property:id,name')->where('status', 'waiting')->select('id', 'property_id', 'type')->get();
        if ($maintenances->isEmpty()) {
            return response()->json(['message' => 'لا توجد طلبات صيانة حالياً'], 200);
        }
        return  response()->json($maintenances, 200);
    }

    public function details_maintenance_requests(Request $request)
    {
        $maintenance = Maintenance::with('property:id,name')
            ->where('id', $request->maintenance_id)
            ->select('id', 'type', 'description', 'property_id')
            ->first();
        if (!$maintenance) {
            return response()->json(['message' => 'طلب الصيانة غير موجود'], 404);
        }
        return response()->json($maintenance);
    }
    public function addMaintenance(Request $request)
    {
        $request->validate([
            'maintenance' => ['required', 'unique:admins,name'],
        ], [
            'maintenance.required' => 'يجيب ادخال هذا الحقل',
        ]);
        $user = Auth::user();
        Maintenance::create([
            'property_id' => $request->property_id,
            'user_id' => $user->id,
            'type' => $request->type,
            'description' => $request->maintenance
        ]);
        $admins = Admin::where('type', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AddMaintenanceNotification());
        }
        return response()->json(['message' => 'تم ارسال طلب الصيانة بنجاح'], 200);
    }
    public function approveMaintenance(Request $request)
    {
        $maintenance = Maintenance::find($request->maintenance_id);
        $maintenance->status = 'approved';
        $maintenance->save();
        $admins = Admin::where('type', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new ApproveMaintenanceNotification());
        }
        return response()->json(['message' => 'تم الوافقة على الصيانة بنجاح'], 200);
    }
    public function rejectMaintenance(Request $request)
    {
        $maintenance = Maintenance::find($request->maintenance_id);
        $maintenance->status = 'rejected';
        $maintenance->save();

        return response()->json(['message' => 'تم رفض على الصيانة بنجاح'], 200);
    }
}