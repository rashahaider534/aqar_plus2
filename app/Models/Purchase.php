<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $guarded = [];
    public function property(){
        return $this->belongsTo(Property::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }


}

