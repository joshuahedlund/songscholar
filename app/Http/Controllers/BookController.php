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
        
        $songRefs = DB::table('songRefs')
                    ->join('passageVersions','songRefs.passageVersion_id','=','passageVersions.id')
                    ->join('passages','passageVersions.passage_id','=','passages.id')
                    ->join('songs','songRefs.song_id','=','songs.id')
                    ->join('artists','songs.artist_id','=','artists.id')
                    ->select('lyric', 'version', 'text', 'chapter', 'verse', 'artists.name as artist_name', 'songs.name as song_name','song_id')
                    ->where('book',$book)
                    ->orderBy('chapter')->orderBy('verse')
                    //->get();
                    ->paginate(20);
        
        /*$passages = \App\Passage::where('book',$book)->get();
        
        $passages->load(['passageVersions.songRefs' => function ($q) use ( &$songRefs ) { //from https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
            $songRefs = $q->get()->unique();
        }]);*/        
        
        return view('book.index', ['book' => $book, 'songRefs' => $songRefs]);
    }
    
    public function numChapters($bookName){
        $maxChapter = \App\Book::numChapters($bookName);
        return $maxChapter;
    }
    
    public function numVerses($bookName,$ch){
        $maxVerse = \App\Book::numVerses($bookName,$ch);
        return $maxVerse;
    }
    
    /* creating a song reference: after choosing a verse, populate the texts */
    public function editPassageVersionFields($bookName,$ch,$v){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $passage = \App\Passage::where('book',$bookName)->where('chapter',$ch)->where('verse',$v)->first();
        $pvs = $passage->passageVersions;
        
        return view('song.editPassageVersionFields',['passage' => $passage, 'pvs' => $pvs]);
    }
}
