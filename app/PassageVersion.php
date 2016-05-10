<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PassageVersion extends Model
{
    protected $table = 'passageVersions';
    
    protected $fillable = ['version','text'];
    
    public function songRefs() {
        return $this->hasMany('App\SongRef','passageVersion_id','id');
    }
    
    public function passage() {
        return $this->belongsTo('App\Passage');
    }
    
}
