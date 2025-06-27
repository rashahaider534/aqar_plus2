<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
  use SoftDeletes;
  protected $guarded = [];
  public function province()
  {
    return $this->belongsTo(Province::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class, 'seller_id');
  }
  public function images()
  {
    return $this->hasMany(Image::class);
  }
  public function favoriteByUsers()
  {
    return $this->belongsToMany(User::class, 'favorites');
  }

  public function ratings()
  {
    return $this->hasMany(Rating::class);
  }
  public function rentals()
  {
    return $this->hasMany(Rental::class);
  }
  public function purchases()
  {
    return $this->hasMany(Purchase::class);
  }
  public function bookings()
  {
    return $this->hasMany(Booking::class);
  }
  public function rejected()
  {
    return $this->hasOne(Rejected::class,);
  }
  public function maintenances()
  {
    return $this->hasMany(Maintenance::class);
  }
}