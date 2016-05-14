<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Book;

class SongRefController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $songs = \App\Song::all();
        return view('songref.index', ['songs' => $songs]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!\Auth::check()){
           return redirect('login');
        }

        $books = Book::orderBy('id')->get();
	foreach($books as $book){$data['books'][$book->name]=$book->name;}
        return view('songref.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
             'song' => 'required',
             'album' => 'required',
             'artist' => 'required'
        ]);

        //Create the stuff
        $artist = \App\Artist::firstOrCreate(array('name'=>$request->artist));
        $artist->save();

        $album = \App\Album::firstOrCreate(array('name'=>$request->album,'artist_id'=>$artist->id));
        $album->artist_id = $artist->id;
        $album->save();

        $song = \App\Song::firstOrCreate(array('name'=>$request->song,'album_id'=>$album->id));
        $song->album_id = $album->id;
        $song->save();
        
        $passage = \App\Passage::firstOrCreate(array('book'=>$request->book,'chapter'=>$request->chapter,'verse'=>$request->verse));
        $passage->save();
        
        $passageVersion = \App\PassageVersion::firstOrCreate(array('passage_id'=>$passage->id,'version'=>$request->version));
        $passageVersion->passage_id = $passage->id;
        $passageVersion->text = $request->text;
        $passageVersion->save();
        
        $songRef = \App\SongRef::create(array('lyric'=>$request->lyric));
        $songRef->song_id = $song->id;
        $songRef->passageVersion_id = $passageVersion->id;
        $songRef->save();
        
        if($songRef->id){
            $user = $request->user();
            $user->points += 10;
            $user->save();
            
            \Session::flash('flash_message','Song reference successfully added! +10 points!');
        }
        return redirect('/songrefs');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    
    public function editLyric($songRefId){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $songRef = \App\SongRef::where('id',$songRefId)->first();
        return view('song.editLyric',['songRef' => $songRef]);
    }
    
    public function updateLyric($songRefId, Request $request){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $songRef = \App\SongRef::where('id',$songRefId)->first();
        $songRef->lyric = $request->lyric;
        $songRef->save();
        
        return redirect()->route('song',$songRef->song->id);
    }
}
