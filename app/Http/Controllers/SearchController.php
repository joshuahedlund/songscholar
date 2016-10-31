<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class SearchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //Get artists with count of references per artist
        $data['searchTerm'] = $request->search;
            
        $data['artists'] = \App\Artist::whereRaw("MATCH (name) AGAINST (:search IN BOOLEAN MODE)",['search'=>$request->search])->orderBy('name')->get();
        $data['songs'] = \App\Song::whereRaw("MATCH (name) AGAINST (:search IN BOOLEAN MODE)",['search'=>$request->search])->orderBy('name')->get();
        
        $match = 'MATCH (songRefs.lyric) AGAINST(:lyric IN BOOLEAN MODE) OR MATCH (passageVersions.text) AGAINST(:text IN BOOLEAN MODE)';
        $data['songRefs'] = DB::table('songRefs')
            ->join('songs','songRefs.song_id','=','songs.id')
            ->join('artists','songs.artist_id','=','artists.id')
            ->join('passageVersions','songRefs.passageVersion_id','=','passageVersions.id')
            ->join('passages','passageVersions.passage_id','=','passages.id')
            ->select('songs.name as songname','songs.id as songid','songRefs.lyric','artists.name as artistname','book','chapter','verse')
            ->selectRaw('('.$match.') as score',['lyric'=>$request->search,'text'=>$request->search])
            ->havingRaw('score > 0')
            ->orderBy('score','desc')
            ->get();
        
        return view('search.index', $data);
    }
}
