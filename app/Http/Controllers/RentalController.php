<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RentalController extends Controller
{
     public function show_rental()
    {
        $user=Auth::user();
        $rental=Rental::with('property.images')->where('user_id',$user->id)->get();
        return response()->json(['rental'=>$rental],200);
    }
}
