<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        /*\DB::listen(function($sql) {
            var_dump($sql->sql);
            var_dump($sql->bindings);
        });*/
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get artists with count of references per artist
        $artists = DB::table('songRefs')
            ->join('songs','songRefs.song_id','=','songs.id')
            //->join('albums','songs.album_id','=','albums.id') //cut out middleman to make albums optional
            ->join('artists','songs.artist_id','=','artists.id')
            ->select(DB::raw('count(*) as cnt, artists.name as artistname'))
            ->groupBy('artists.id')
            ->orderBy('artists.name')
            ->get();
        
        //Get books with count of song references per book
        $books = DB::table('songRefs')
            ->join('passageVersions','songRefs.passageVersion_id','=','passageVersions.id')
            ->join('passages','passageVersions.passage_id','=','passages.id')
            ->join('books','passages.book','=','books.name')
            ->select(DB::raw('count(*) as cnt, passages.book as bookname'))
            ->groupBy('books.id')
            ->orderBy('books.id')
            ->get();
            
        $newRefs = DB::table('songRefs')
            ->join('songs','songRefs.song_id','=','songs.id')
            ->join('artists','songs.artist_id','=','artists.id')
            ->join('passageVersions','songRefs.passageVersion_id','=','passageVersions.id')
            ->join('passages','passageVersions.passage_id','=','passages.id')
            ->select('songRefs.created_at as dateadded', 'songs.id as songid', 'songs.name as songname', 'artists.name as artistname', 'book', 'chapter', 'verse')
            ->orderBy('songRefs.id','desc')
            ->take(10)
            ->get();
        
        return view('home', array('artists' => $artists, 'books' => $books, 'newRefs' => $newRefs));
    }
}