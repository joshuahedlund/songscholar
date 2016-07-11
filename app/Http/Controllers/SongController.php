<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {        
        $song = \App\Song::with('album.artist')->where('id',$id)->first();
        
        if($song){
            $song->load(['songRefs' => function ($q) use ( &$songRefs ) { //from https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
                $songRefs = $q->get()->unique();
            }]);
        }else{
            abort(404);
        }
             
        return view('song.index', ['song' => $song, 'songRefs' => $songRefs]);
    }
    
}
