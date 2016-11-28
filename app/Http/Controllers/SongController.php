<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {        
        $data = $this->getSongAndRefs($id);
        $data['user'] = \Request::user();
        $data['songId'] = $data['song']->id;
             
        return view('song.index', $data);
    }
    
    /** edit song details like name and album */
    public function editSong($id){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $song = \App\Song::with('album.artist')->where('id',$id)->first();
        
        if($song){
            $data['song'] = $song;
            $data['album'] = ($song->album) ? $song->album->name : null;
            return view('song.editSong', $data);
        }else{
            abort(404);
        }
    }
    public function updateSong($songId, Request $request){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $song = \App\Song::with('album.artist')->where('id',$songId)->first();
        $user = $request->user();
        
        if($song){
            $song->name = $request->songname;
            if(!empty($request->albumname)){
                $album = \App\Album::firstOrCreate(array('name'=>$request->albumname,'artist_id'=>$song->artist->id));
                if($album){
                    $album->artist_id = $song->artist->id;
                    $album->save();
                    $albumId=$album->id;
                    $song->album_id = $albumId;
                }
            }
            $song->save();
        }else{
            abort(404);
        }

        return redirect('/song/'.$songId);
    }
    
    /** edit song associated artists */
    public function editSongAssoc($id){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $song = \App\Song::where('id',$id)->first();
        
        if($song){
            $data['song'] = $song;
            
            $data['artists'] = $this->getAssociatedArtists($id);
            
            return view('song.editSongAssoc', $data);
        }else{
            abort(404);
        }
    }
    public function updateSongAssoc($songId, Request $request){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $song = \App\Song::where('id',$songId)->first();
        $user = $request->user();
        
        if($song){
            if(!empty($request->artist)){
                $artist = \App\Artist::firstOrCreate(['name'=>$request->artist]);
                if($artist){
                    $artist->save();
                    DB::table('associatedArtists')->insert(
                        ['song_id'=>$songId,
                        'artist_id'=>$artist->id,
                        'createdBy'=>$user->id]
                    );
                }
            }
        }else{
            abort(404);
        }
        
        return redirect('/song/'.$songId);
    }
    
    /* edit the order of a song's references */
    public function editOrder($id){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $data = $this->getSongAndRefs($id);
        
        return view('song.editOrder', $data);
    }
    
    public function updateOrder($songId, Request $request){
        if(!\Auth::check()){
           return redirect('login');
        }
    
        $data = $this->getSongAndRefs($songId);
        
        $user = $request->user();
        
        foreach($data['songRefs'] as $songRef){
            $order = $request->input('songref'.$songRef->id);
            if(is_numeric($order)){
                $songRef->order = $order;
                $songRef->updatedBy = $user->id;
                $songRef->save();
            }
        }
        
        \Session::flash('flash_message','Song order successfully updated! Thank you!');
    
        return redirect('/song/'.$songId);
    }
    
    private function getSongAndRefs($id){
        $song = \App\Song::with('album.artist')->where('id',$id)->first();
        $assocArtists = [];
        
        if($song){
            $song->load(['songRefs' => function ($q) use ( &$songRefs ) { //from https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
                $songRefs = $q->orderBy('order')->get()->unique();
            }]);
            
            $assocArtists = $this->getAssociatedArtists($id);
        }else{
            abort(404);
        }
        
        return ['song' => $song, 'songRefs' => $songRefs, 'assocArtists' => $assocArtists];
    }
    
    private function getAssociatedArtists($songId){
        $assocArtists = [];
        $assocArtistRows = DB::table('associatedArtists')
                ->join('artists','associatedArtists.artist_id','=','artists.id')
                ->select('artists.name as artistname')
                ->where('song_id',$songId)
                ->get();
            if(!empty($assocArtistRows)){ //extract names and pass as specific array
                foreach($assocArtistRows as $assocArtistRow){
                    $assocArtists[] = $assocArtistRow->artistname;
                }
            }
        return $assocArtists;
    }
    
    /*private function getSongComments($song){
        $song->load(['coments' => function ($q) use ( &$comments ) {
                $comments = $q->orderBy('id')->get()->unique();
            }]);
    }*/
    
}
