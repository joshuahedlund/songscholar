<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongRef extends Model
{
    public function passageId(){
       return $this->belongsTo('App\Passage');
    }

    public function songId(){
       return $this->belongsTo('App\Song');
    }
}
