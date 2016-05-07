<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SongRef extends Model
{
    protected $table = 'songRefs';
    
    protected $fillable = ['lyric'];
    
    public function passage(){
       return $this->belongsTo('App\Passage');
    }

    public function song(){
       return $this->belongsTo('App\Song');
    }
}
