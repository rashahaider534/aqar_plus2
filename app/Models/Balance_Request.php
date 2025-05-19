<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance_Request extends Model
{
     public function admin(){
        return $this->belongsTo(Admin::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
