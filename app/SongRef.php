<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongRef extends Model
{
    protected $table = 'songRefs';
    
    protected $fillable = ['lyric'];
    
    public function passageVersion(){
       return $this->belongsTo('App\PassageVersion','passageVersion_id');
    }

    public function song(){
       return $this->belongsTo('App\Song');
    }
}
