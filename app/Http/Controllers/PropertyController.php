<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Province;
use App\Models\User;
use Illuminate\Http\Request;

class PropertyController extends Controller
{
    public function properties(){
        $properties= Property::where('status','waiting')->get();
         return response()->json($properties,200);  
    }
      public function filter_name(Request $request){
        $properties= Property::where('status','waiting')->where('name',$request->name_property)->get();
           return response()->json($properties,200); 
    }
    public function filter_room(Request $request){
        $properties= Property::where('status','waiting')->where('room',$request->room_property)->get();
           return response()->json($properties,200); 
    }
    
    public function filter_province(Request $request){
         $province=Province::where('string',$request->province_property)->first();
       $properties=  $province->properties->where('status','waiting');
           return response()->json($properties,200); 
    }
    
    public function filter_price(Request $request){
        $properties= Property::where('status','waiting')->where('final_price','>=',$request->start_range)->
        where('final_price','<=',$request->end_range)->get();
           return response()->json($properties,200); 
    }
    
    public function filter_area(Request $request){
        $properties= Property::where('status','waiting')->where('area',$request->area_property)->get();
           return response()->json($properties,200); 
    }
    
    public function filter_type(Request $request){
        $properties= Property::where('status','waiting')->where('type',$request->type_property)->get();
           return response()->json($properties,200); 
    }
       public function filter_name_Admin(Request $request){
        $properties=Property::where('name',$request->name_property)->get();
           return response()->json($properties,200); 
    }
         public function filter_status_Admin(Request $request){
        $properties=Property::where('status',$request->status_property)->get();
           return response()->json($properties,200); 
    }
         public function filter_seller_Admin(Request $request){
       $seller=User::where('name',$request->name_seller)->first();
           return response()->json(  $seller->properties,200); 
    }
}
