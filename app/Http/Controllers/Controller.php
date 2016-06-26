<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Contracts\Validation\Validator;


ini_set('xdebug.max_nesting_level', 500);

class Controller extends BaseController
{
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'artist.not_in' => 'Artist is required',
            'artistname.required_if'  => 'Artist is required',
            'song.not_in' => 'Song is required',
            'songname.required_if' => 'Song is required',
            'songname.required_without' => 'Song is required',
            'pvid.required' => 'A passage version is required',
            'text.required_if' => 'Text is required to add a new version of the verse'
        ];
    }
}
