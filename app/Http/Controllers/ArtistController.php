<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class ArtistController extends Controller
{
    public function index(){
        //Get artists with count of songs per artist
        $artists = DB::table('artists')
            //->join('albums','songs.album_id','=','albums.id') //cut out middleman to make albums optional
            ->leftJoin('songs','songs.artist_id','=','artists.id')
            ->select(DB::raw('count(songs.id) as cnt, artists.name as artistname'))
            ->groupBy('artists.id')
            ->orderBy('artists.name')
            ->get();
        
        return view('artist.index', ['artists' => $artists]);
    }
    
    public function displayArtist($name){        
        $artist = \App\Artist::where('name',str_replace('-',' ',$name))->first();
        
        if($artist){
            $songs = DB::table('songs')
                ->leftJoin('albums','songs.album_id','=','albums.id')
                ->leftJoin('comments','comments.song_id','=','songs.id')
                ->select(DB::raw('songs.name, songs.id, albums.name as albumname, count(comments.id) as cnt_comment'))
                ->where('songs.artist_id','=',$artist->id)
                ->groupBy('songs.id')
                ->orderBy('songs.name')
                ->get();
            
            /*$songs = \App\Song::where('artist_id','=',$artist->id);
            $artist->load(['songs' => function ($q) use ( &$songs ) { //from https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
                $songs = $q->orderBy('name')->get()->unique();
            }]);*/
        }else{
            abort(404);
        }
     
        return view('artist.displayArtist', ['artist' => $artist, 'songs' => $songs]);
    }
    
    /* Show the form for creating a new resource */
    public function create(){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        return view('artist.create');
    }
    
    /* Store a newly created resource */
    public function store(Request $request){
        $this->validate($request, [
            'artistname' => 'required'
        ],$this->messages());
        
        $artist = \App\Artist::firstOrCreate(['name'=>$request->artistname]);
        $artist->save();
        
        \Session::flash('flash_Message','New artist added! Now add your reference!');
        
        return redirect('/artist/'.str_replace(' ','-',$request->artistname));
    }
    
    public function selectAlbums($artistId){
        $data['albums'][-1]='Select Album';
        $albums = \App\Album::where('artist_id',$artistId)->orderBy('name')->get();
        foreach($albums as $album){
            $data['albums'][$album->id]=$album->name;
        }
        $data['albums'][0]='New...';
        
        return view('artist.selectAlbums',$data);
    }
    
    public function selectSongsByAlbum($albumId){
        $data['songs'][-1]='Select Song';
        $songs = \App\Song::where('album_id',$albumId)->orderBy('name')->get();
        foreach($songs as $song){
            $data['songs'][$song->id]=$song->name;
        }
        $data['songs'][0]='New...';
        
        return view('artist.selectSongsByAlbum',$data);
    }
}
