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
        $data = $this->getSongAndRefs($id);
             
        return view('song.index', $data);
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
        
        if($song){
            $song->load(['songRefs' => function ($q) use ( &$songRefs ) { //from https://softonsofa.com/laravel-querying-any-level-far-relations-with-simple-trick/
                $songRefs = $q->orderBy('order')->get()->unique();
            }]);
        }else{
            abort(404);
        }
        
        return ['song' => $song, 'songRefs' => $songRefs];
    }
    
}
