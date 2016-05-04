<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    protected $fillable = ['name'];

    public function songs(){
	return $this->hasMany('Song');
    }

    public function artist(){
        return $this->belongsTo('App\Artist');
    }
}
