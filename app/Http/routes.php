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
Route::get('book/{name}/numChapters','BookController@numChapters');
Route::get('book/{name}/{ch}/numVerses','BookController@numVerses');
Route::get('book/{name}/{ch}/{v}/editPassageVersionFields','BookController@editPassageVersionFields');

Route::get('modal/feedback',function(){ return View::make('modal/feedback');});
Route::post('modal/feedback','ModalController@storeFeedback');

Route::get('song/{id}',array('as'=>'song','uses'=>'SongController@index'));
Route::get('song/{id}/order','SongController@editOrder');
Route::get('song/{id}/edit','SongController@editSong');
Route::get('song/{id}/comments','CommentController@index');
Route::post('song/{id}/updateOrder',['as'=>'song.updateOrder','uses'=>'SongController@updateOrder']);
Route::post('song/{id}/updateSong',['as'=>'song.updateSong','uses'=>'SongController@updateSong']);

Route::resource('songrefs','SongRefController');
Route::get('songref/add/{id}','SongRefController@add');
Route::post('songref/delete',['as'=>'songRef.delete','uses'=>'SongRefController@delete']);

$ajaxGetRoutes = array('editLyric','indexPassage','editPassageReference','editPassageVersion');
foreach($ajaxGetRoutes as $ajaxRoute){
    Route::get('songRef/{id}/'.$ajaxRoute,array('as'=>'songRef.'.$ajaxRoute,'uses'=>'SongRefController@'.$ajaxRoute));
}
$ajaxPostRoutes = array('updateLyric','updatePassageReference','updatePassageVersion');
foreach($ajaxPostRoutes as $ajaxRoute){
    Route::post('songRef/{id}/'.$ajaxRoute,array('as'=>'songRef.'.$ajaxRoute,'uses'=>'SongRefController@'.$ajaxRoute));
}

Route::post('comment',['as'=>'comment.store','uses'=>'CommentController@store']);
Route::post('comment/delete/',['as'=>'comment.delete','uses'=>'CommentController@delete']);

//Route::get('songRef/{id}/editLyric/','SongRefController@editLyric');
//Route::post('songRef/{id}/updateLyric/',array('as'=>'songRef.updateLyric','uses'=>'SongRefController@updateLyric'));
//Route::get('songRef/{id}/editPassageReference/','SongRefController@editPassageReference');
//Route::post('songRef/{id}/updatePassageReference/',array('as'=>'songRef.updatePassageReference','uses'=>'SongRefController@updatePassageReference'));

