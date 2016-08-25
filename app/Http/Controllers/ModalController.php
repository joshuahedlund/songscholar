<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ModalController extends Controller
{
    public function storeFeedback(Request $request){    
        if(!\Auth::check()){
           return redirect('login');
        }
                
        $user = $request->user();
        
        if(!empty($request->text)){
            $feedback = \App\Feedback::create(['type'=>$request->type,'text'=>$request->text]);
            $feedback->user_id = $user->id;
            $feedback->refPage = $_SERVER['HTTP_REFERER'];
            
            $feedback->save();
        }
        
        $s = '<p>Thank you for your feedback!</p>';
        
        return $s;
    }
}
