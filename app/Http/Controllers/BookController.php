<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {
        /*\DB::listen(function($sql) {
            var_dump($sql->sql);
            var_dump($sql->bindings);
        });*/
        
        $book = str_replace('-',' ',$name);
        $passages = \App\Passage::where('book',$book)->get();
        
        $passages->load(['passageVersions.songRefs' => function ($q) use ( &$songRefs ) { //from https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
            $songRefs = $q->get()->unique();
        }]);
        //$passageV = $passages->passageVersions;
     
        //$songRefs = \App\Songref::with('song')->with('album')->with(['artist'=>function($query) use ($artist){$query->where('artists.id',$artist->id);}])->get();
        
        //$songRefs = \App\SongRef::with(['song.album.artist'=>function($query) use ($artist){$query->where('artists.id',$artist->id);}])->get();
        //$songRefs = \App\SongRef::with(['song','song.album','song.album.artist'=>function($query) use ($artist){$query->where('artists.id',$artist->id);}])->get();
        
        //$songRefs = \App\SongRef::with(['song','song.album','song.album.artist'])->where('artists.id',$artist->id)->get();
        
        
        return view('book.index', ['book' => $book, 'songRefs' => $songRefs]);
    }
    
    public function numChapters($bookName){
        $maxChapter = DB::table('passages')->where('book',$bookName)->max('chapter');
        return $maxChapter;
    }
    
    public function numVerses($bookName,$ch){
        $maxVerse = DB::table('passages')->where('book',$bookName)->where('chapter',$ch)->max('verse');
        return $maxVerse;
    }
}
