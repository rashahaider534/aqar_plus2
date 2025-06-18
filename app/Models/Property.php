<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $guarded = [];
    public function province(){
        return $this->belongsTo(Province::class);
    }
    public function images(){
        return $this->hasMany(Image::class);
        }
     public function favoriteProperties(){
     return $this->belongsToMany(Property::class,'favorites');
   }
    public function ratings(){
     return $this->hasMany(Rating::class);
   }
    public function rentals(){
     return $this->hasMany(Rental::class);
   }
     public function purchases(){
      return $this->hasMany(Purchase::class);
   }
     public function bookings(){
      return $this->hasMany(Booking::class);
   }
     public function rejected(){
    return $this->hasOne(Rejected::class,);
   }
      public function maintenances(){
      return $this->hasMany(Maintenance::class);
   }



}
