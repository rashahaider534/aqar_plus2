<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded=['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function favoriteByUsers(){
        return $this->belongsToMany(User::class,'favorites');
    }
   public function ratings(){
      return $this->hasMany(Rating::class);
   }
    public function rentals(){
      return $this->hasMany(Rental::class);
   }
      public function purchases(){
      return $this->hasMany(Purchase::class);
   }
       public function bookings(){
      return $this->hasMany(Booking::class);
   }
    
   public function block(){
    return $this->hasOne(Block::class);
   }
             
}