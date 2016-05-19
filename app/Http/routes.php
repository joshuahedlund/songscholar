<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::auth();

Route::get('/', 'HomeController@index');

Route::get('artist/{name}', 'ArtistController@index');

Route::get('book/{name}','BookController@index');

Route::get('song/{id}',array('as'=>'song','uses'=>'SongController@index'));

Route::resource('songrefs','SongRefController');

$ajaxRoutes = array('editLyric','updateLyric','indexPassage','editPassageReference','updatePassageReference');
foreach($ajaxRoutes as $ajaxRoute){
    Route::get('songRef/{id}/'.$ajaxRoute,array('as'=>'songRef.'.$ajaxRoute,'uses'=>'SongRefController@'.$ajaxRoute));
}
//Route::get('songRef/{id}/editLyric/','SongRefController@editLyric');
//Route::post('songRef/{id}/updateLyric/',array('as'=>'songRef.updateLyric','uses'=>'SongRefController@updateLyric'));
//Route::get('songRef/{id}/editPassageReference/','SongRefController@editPassageReference');
//Route::post('songRef/{id}/updatePassageReference/',array('as'=>'songRef.updatePassageReference','uses'=>'SongRefController@updatePassageReference'));

