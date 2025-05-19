<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rejected extends Model
{
   public function admin(){
        return $this->belongsTo(Admin::class);
    }
     public function property(){
        return $this->belongsTo(Property::class);
    }
}
