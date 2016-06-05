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
$ajaxGetRoutes = array('selectAlbums','selectSongsByAlbum');
foreach($ajaxGetRoutes as $ajaxRoute){
    Route::get('artist/{id}/'.$ajaxRoute,'ArtistController@'.$ajaxRoute);
}

Route::get('book/{name}','BookController@index');
Route::get('book/{name}/maxChapters','BookController@maxChapters');

Route::get('song/{id}',array('as'=>'song','uses'=>'SongController@index'));

Route::resource('songrefs','SongRefController');

$ajaxGetRoutes = array('editLyric','indexPassage','editPassageReference','editPassageVersion');
foreach($ajaxGetRoutes as $ajaxRoute){
    Route::get('songRef/{id}/'.$ajaxRoute,array('as'=>'songRef.'.$ajaxRoute,'uses'=>'SongRefController@'.$ajaxRoute));
}
$ajaxPostRoutes = array('updateLyric','updatePassageReference','updatePassageVersion');
foreach($ajaxPostRoutes as $ajaxRoute){
    Route::post('songRef/{id}/'.$ajaxRoute,array('as'=>'songRef.'.$ajaxRoute,'uses'=>'SongRefController@'.$ajaxRoute));
}

//Route::get('songRef/{id}/editLyric/','SongRefController@editLyric');
//Route::post('songRef/{id}/updateLyric/',array('as'=>'songRef.updateLyric','uses'=>'SongRefController@updateLyric'));
//Route::get('songRef/{id}/editPassageReference/','SongRefController@editPassageReference');
//Route::post('songRef/{id}/updatePassageReference/',array('as'=>'songRef.updatePassageReference','uses'=>'SongRefController@updatePassageReference'));

