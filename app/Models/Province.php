<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
     protected $guarded=['id'];
   public function properties(){
   return $this->hasMany(Property::class);
   }
}
