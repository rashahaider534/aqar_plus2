<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function province(){
        return $this->belongsTo(Province::class);
    }
    public function images(){
        return $this->hasMany(Image::class,'images');
        }
     public function favoriteProperties(){
     return $this->belongsToMany(Property::class,'favorites');
   }
    public function ratings(){
     return $this->hasMany(Rating::class,'ratings');
   }
    public function rentals(){
     return $this->hasMany(Rental::class,'rentals');
   }   
     public function purchases(){
      return $this->hasMany(Purchase::class,'purchases');
   }                       
     public function bookings(){
      return $this->hasMany(Booking::class,'bookings');
   }
     public function rejected(){
    return $this->hasOne(Rejected::class,'rejecteds');
   }
      public function maintenances(){
      return $this->hasMany(Maintenance::class,'maintenances');
   }
        
               
    
}