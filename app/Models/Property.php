<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    public function province(){
        return $this->belongsTo(Province::class);
    }
    public function images(){
        return $this->hasMany(Image::class,'images');
        }
        public function discounts(){
            return $this->hasMany(Discount::class,'discounts');
            }
            public function favoriteProperties(){
                return $this->belongsToMany(Property::class,'favorites');
            }
            public function comments(){
                return $this->hasMany(Comment::class,'comments');
                }
                public function likes(){
                    return $this->hasMany(Like::class,'likes');
                    }
                    public function ratings(){
                        return $this->hasMany(Rating::class,'ratings');
                        }
               
    
}
