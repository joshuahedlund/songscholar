<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['name'];

    public function album(){
        return $this->belongsTo('App\Album');
    }
    
    public function artist(){
        return $this->belongsTo('App\Artist');
    }
    
    public function songRefs(){
        return $this->hasMany('App\SongRef');
    }
    
    public function comments(){
        return $this->hasMany('App\Comment');
    }
}
