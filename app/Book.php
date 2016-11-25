<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public static function numChapters($bookName){
        $maxChapter = \DB::table('passages')->where('book',$bookName)->max('chapter');
        return $maxChapter;
    }
    
    public static function numVerses($bookName,$ch){
        $maxVerse = \DB::table('passages')->where('book',$bookName)->where('chapter',$ch)->max('verse');
        return $maxVerse;
    }
    
    /* returns url friendly version of name with hyphens replacing spaces */
    public function getUrlName(){
        return str_replace(' ','-',$this->name);
    }
}
