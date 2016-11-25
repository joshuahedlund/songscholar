<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artist extends Model
{
    protected $fillable = ['name'];

    public function albums(){
	return $this->hasMany('App\Album');
    }
    
    public function songs(){
        //return $this->hasManyThrough('App\Song','App\Album'); //allow optional albums
        return $this->hasMany('App\Song');
    }
    
    /* returns url friendly version of name with hyphens replacing spaces */
    public function getUrlName(){
        return str_replace(' ','-',$this->name);
    }
}
