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
        $data['artists'] = DB::table('songRefs')
            ->join('songs','songRefs.song_id','=','songs.id')
            //->join('albums','songs.album_id','=','albums.id') //cut out middleman to make albums optional
            ->join('artists','songs.artist_id','=','artists.id')
            ->select(DB::raw('count(*) as cnt, artists.name as artistname'))
            ->groupBy('artists.id')
            ->orderBy('cnt','desc')
            ->orderBy('artists.name')
            ->take(25)
            ->get();            
        
        //Get books with count of song references per book
        $data['books'] = DB::table('songRefs')
            ->join('passageVersions','songRefs.passageVersion_id','=','passageVersions.id')
            ->join('passages','passageVersions.passage_id','=','passages.id')
            ->join('books','passages.book','=','books.name')
            ->select(DB::raw('count(*) as cnt, passages.book as bookname'))
            ->groupBy('books.id')
            ->orderBy('books.id')
            ->get();
            
        //Get new references
        $data['newRefs'] = DB::table('songRefs')
            ->join('songs','songRefs.song_id','=','songs.id')
            ->join('artists','songs.artist_id','=','artists.id')
            ->join('passageVersions','songRefs.passageVersion_id','=','passageVersions.id')
            ->join('passages','passageVersions.passage_id','=','passages.id')
            ->join('users','users.id','=','songRefs.createdBy')
            ->select('songRefs.created_at as dateadded', 'songs.id as songid', 'songs.name as songname', 'artists.name as artistname', 'book', 'chapter', 'verse','users.name as username')
            ->orderBy('songRefs.id','desc')
            ->take(10)
            ->get();
            
        //Get new comments
        $data['newComments'] = DB::table('comments')
            ->join('users','users.id','=','comments.user_id')
            ->join('songs','songs.id','=','comments.song_id')
            ->join('artists','artists.id','=','songs.artist_id')
            ->select('comments.created_at','users.name','songs.name as songname','songs.id as songid','artists.name as artistname')
            ->orderBy('comments.id','desc')
            ->take(4)
            ->get();        
        
        return view('home', $data);
    }
}