<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    public function properties(){
        return $this->belongsTo(Property::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
