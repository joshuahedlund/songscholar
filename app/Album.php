<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    public function artistId(){
        return $this->belongsTo('App\Artist');
    }
}
