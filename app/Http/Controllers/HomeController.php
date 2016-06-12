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
        //Get artists
        $artists = \App\Artist::orderBy('name')->get();
        
        //Get books with count of song references per book
        $books = DB::table('songRefs')
            ->join('passageVersions','songRefs.passageVersion_id','=','passageVersions.id')
            ->join('passages','passageVersions.passage_id','=','passages.id')
            ->join('books','passages.book','=','books.name')
            ->select(DB::raw('count(*) as cnt, passages.book as bookname'))
            ->groupBy('books.id')
            ->orderBy('books.id')
            ->get();
        
        return view('home', array('artists' => $artists, 'books' => $books));
    }
}