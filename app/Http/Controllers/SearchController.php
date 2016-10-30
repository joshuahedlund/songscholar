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
        //Get artists with count of references per artist
        $data['searchTerm'] = $request->search;
            
        $data['artists'] = \App\Artist::whereRaw("MATCH (name) AGAINST (:search IN BOOLEAN MODE)",['search'=>$request->search])->get();
        $data['songs'] = \App\Song::whereRaw("MATCH (name) AGAINST (:search IN BOOLEAN MODE)",['search'=>$request->search])->get();
        
        return view('search.index', $data);
    }
}
