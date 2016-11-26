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
        $cntArtist=0;
        $cntBook=0;
        $cntSongs=0;
        $cnRefs=0;
                        
        
        $data['searchTerm'] = $request->search;
        
        //Find matching book/chapter
        $searchBook = $request->search;
        $searchCh = 0;
        //See if last word is chapter
        $searchWords = explode(' ',$request->search);
        $lastWord = count($searchWords);
        if(count($searchWords)>1 && is_numeric($searchCh = array_pop($searchWords))){ //if last word is numeric, pop it off (assume as chapter) and...
            $searchBook = implode(' ',$searchWords); //put the rest back together for the book
        }
        //Search for book, either original string or with chapter popped off
        $book = \App\Book::where('name',$searchBook)->first();
        if($book){
            $bookUrl = '/book/'.$book->getUrlName();
            if($searchCh){
                $bookUrl .= '/'.$searchCh;
            }
            return redirect($bookUrl);
        }
            
        //Find matching artists
        $data['artists'] = \App\Artist::whereRaw("MATCH (name) AGAINST (:search IN BOOLEAN MODE)",['search'=>$request->search])->orderBy('name')->get();
        $cntArtist = count($data['artists']);
        
        //Find matching songs
        $data['songs'] = \App\Song::whereRaw("MATCH (name) AGAINST (:search IN BOOLEAN MODE)",['search'=>$request->search])->orderBy('name')->get();
        $cntSongs = count($data['songs']);
        
        //Find matching lyrics or text
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
        $cntRefs = count($data['songRefs']);
        
        //If artist result(s) and no other results, see if we can go directly
        if($cntArtist>=1 && $cntSongs==0 && $cntRefs==0){
            if($cntArtist==1){ //if one artist go to that artist
                $artist = $data['artists'][0];
                return redirect('/artist/'.$artist->getUrlName());
            }else if ($cntArtist>1){ //if more than one
                //see if one is an exact match
                foreach($data['artists'] as $artist){
                    if(strtolower($artist->name) == strtolower($request->search)){
                        return redirect('/artist/'.$artist->getUrlName());
                    }
                }
            }
        }
        
        return view('search.index', $data);
    }
}
