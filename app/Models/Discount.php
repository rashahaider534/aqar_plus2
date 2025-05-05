<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    public function properties(){
        return $this->belongsTo(Property::class);
    }
}
