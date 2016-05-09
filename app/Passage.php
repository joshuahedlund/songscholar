<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    protected $fillable = ['book','chapter','verse'];
    
    public function songRefs() {
        return $this->hasMany('App\SongRef');
    }
    
    public function passageVersions(){
        return $this->hasMany('App\PassageVersion');
    }
}
