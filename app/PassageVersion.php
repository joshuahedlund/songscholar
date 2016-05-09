<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PassageVersion extends Model
{
    protected $table = 'passageVersions';
    
    protected $fillable = ['version','text'];
    
    public function passage() {
        return $this->belongsTo('App\Passage');
    }
    
}
