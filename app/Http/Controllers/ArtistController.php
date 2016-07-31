<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($name)
    {        
        $artist = \App\Artist::where('name',str_replace('-',' ',$name))->first();
        
        $artist->load(['songs' => function ($q) use ( &$songs ) { //from https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
            $songs = $q->orderBy('name')->get()->unique();
        }]);
     
        return view('artist.index', ['artist' => $artist, 'songs' => $songs]);
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
