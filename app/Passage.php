<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    protected $fillable = ['book','chapter','verse','version','text'];
    
    public function songRefs() {
        return $this->hasMany('App\SongRef');
    }
}
