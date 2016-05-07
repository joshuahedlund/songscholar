<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

ini_set('xdebug.max_nesting_level', 500);

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $artists = \App\Artist::orderBy('name')->get();
        $passages = \App\Passage::select('book')->orderBy('book')->groupBy('book')->get();
        
        return view('home', array('artists' => $artists, 'passages' => $passages));
    }
}