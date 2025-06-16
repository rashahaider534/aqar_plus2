<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
     use HasFactory, Notifiable,HasApiTokens;
      protected $guarded=['id'];
   
     public function blocks(){
      return $this->hasMany(Block::class);
   }
        public function rejecteds(){
    return $this->hasMany(Rejected::class);
   }

}
