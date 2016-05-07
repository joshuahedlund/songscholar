<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = ['name'];

    public function album(){
        return $this->belongsTo('App\Album');
    }
    
    public function songRefs(){
        return $this->hasMany('App\SongRef');
    }
}
