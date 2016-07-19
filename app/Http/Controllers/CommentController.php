<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{
    public function store(Request $request){    
        if(!\Auth::check()){
           return redirect('login');
        }
                
        $user = $request->user();
        
        if(!empty($request->text)){
            $comment = \App\Comment::create(['text'=>$request->text]);
            $comment->song_id = $request->song_id;
            $comment->user_id = $user->id;
            $comment->save();  
        }
        
        return redirect('/song/'.$request->song_id);
    }
}
