<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passage extends Model
{
    protected $fillable = ['book','chapter','verse','version','text'];
    
    public function songRef() {
        return $this->hasMany('App\SongRef');
    }
}
