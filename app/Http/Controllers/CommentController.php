<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class CommentController extends Controller
{  
    /*public function index($songId){
        $comments = \App\Comment::where(['song_id'=>$songId'])->get();
        
        return view('comment.index',['comments'=>$comments]);
    }*/
        
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
        
        $comments = \App\Comment::where(['song_id'=>$request->song_id])->orderBy('id')->get();
        
        return view('comment.index',['comments'=>$comments,'user'=>$user,'songId'=>$request->song_id]);
    }
    
    public function delete(Request $request){
        $songId=0;
        $user = $request->user();
        if(\Auth::check()){
            $comment = \App\Comment::where(['id'=>$request->delete_id])->first();
            if($comment){ //comment with this id exists
                $songId=$comment->song_id;
                if($comment->user_id==$user->id || $user->isAdmin){ //if user's own comment, or permission to delete any comment
                    $comment->delete();
                }
            }
        }
        
        if($songId){        
            $comments = \App\Comment::where(['song_id'=>$songId])->orderBy('id')->get();
            
            return view('comment.index',['comments'=>$comments,'user'=>$user,'songId'=>$songId]);
        }else{
            abort(404);
        }
    }
}
