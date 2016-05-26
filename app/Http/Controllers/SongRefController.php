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
        
        $user = $request->user();
        
        $songRef = \App\SongRef::create(array('lyric'=>$request->lyric));
        $songRef->song_id = $song->id;
        $songRef->passageVersion_id = $passageVersion->id;
        $songRef->createdBy = $user->id;
        $songRef->save();
        
        if($songRef->id){
            $user->points += 10;
            $user->save();
            
            \Session::flash('flash_message','Song reference successfully added! +10 points!');
        }
        return redirect('/');
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
        
        $user = $request->user();
        
        $songRef = \App\SongRef::where('id',$songRefId)->first();
        $songRef->lyric = $request->lyric;
        $songRef->updatedBy = $user->id;
        $songRef->save();
        
        return redirect()->route('song',$songRef->song->id);
    }
    
    public function indexPassage($songRefId){
        $songRef = \App\SongRef::with('passageVersion.passage')->where('id',$songRefId)->first();
        return view('song.indexPassage', ['songRef'=>$songRef]);
    }
    
    public function editPassageReference($songRefId){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $data = array();
        
        $books = Book::orderBy('id')->get();
	foreach($books as $book){$data['books'][$book->name]=$book->name;}
        
        $songRef = \App\SongRef::with('passageVersion.passage')->where('id',$songRefId)->first();
        $data['songRef'] = $songRef;        
        $data['pv'] = $songRef->passageVersion;
        
        return view('song.editPassageReference',$data);
    }
    
    public function updatePassageReference($songRefId, Request $request){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $songRef = \App\SongRef::with('passageVersion.passage')->where('id',$songRefId)->first();
        /*$passageVersion = $songRef->passageVersion;
        $passageVersion->passage->book = $request->book;
        $passageVersion->passage->chapter = $request->chapter;
        $passageVersion->passage->verse = $request->verse;
        $passageVersion->passage->save();*/

        //$user = $request->user();
        
        $passage = \App\Passage::firstOrCreate(array('book'=>$request->book,'chapter'=>$request->chapter,'verse'=>$request->verse));
        $passage->save();
        
        $pvs = $passage->passageVersions;
        
        return view('song.editPassageVersion',['songRef' => $songRef, 'passage' => $passage, 'pvs' => $pvs]);
    }
    
    public function editPassageVersion($songRefId){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $songRef = \App\SongRef::with('passageVersion.passage')->where('id',$songRefId)->first();
        $passage = $songRef->passageVersion->passage;
        
        $pvs = $passage->passageVersions;
        
        return view('song.editPassageVersion',['songRef' => $songRef, 'passage' => $passage, 'pvs' => $pvs]);        
    }
    
    public function updatePassageVersion($songRefId, Request $request){
        if(!\Auth::check()){
           return redirect('login');
        }
        
        $songRef = \App\SongRef::with('passageVersion.passage')->where('id',$songRefId)->first();
        $passage = $songRef->passageVersion->passage;
        $user = $request->user();
        
        if($request->pvid>0){ //existing version
            if($request->pvid!=$songRef->passageVersion->id){ //changed version
                $songRef->passageVersion_id = $request->pvid;
                $songRef->updatedBy = $user->id;
                $songRef->save();
                
                \Session::flash('flash_message','Song reference successfully updated!');
            }
        }else if($request->pvid==0){ //new version
            if(!empty($request->version) && !empty($request->text)){
                $passageVersion = \App\PassageVersion::firstOrCreate(array('passage_id'=>$passage->id,'version'=>$request->version));
                $passageVersion->passage_id = $request->passageId; //may be new (if coming from editPassageReference) or same
                $passageVersion->text = $request->text;
                $passageVersion->save();
                
                $songRef->passageVersion_id = $passageVersion->id;
                $songRef->updatedBy = $user->id;
                $songRef->save();
                
                \Session::flash('flash_message','Song reference successfully updated! New version added!');
            }
        }
        
        return redirect()->route('song',$songRef->song->id);
    }
}
