<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function properties(){
        return $this->belongsTo(Property::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
    public function complaints(){
        return $this->hasMany(Complaint::class,'complaints');
        }
}
