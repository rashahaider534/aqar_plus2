<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rejected extends Model
{
    protected $guarded = ['id'];
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
