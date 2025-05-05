<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    public function complaints (){
        return $this->belongsTo(Complaint::class);
    }
    public function users(){
        return $this->belongsTo(User::class);
    }
}
