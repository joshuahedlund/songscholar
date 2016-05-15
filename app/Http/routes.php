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
Route::get('songRef/{id}/editLyric/','SongRefController@editLyric');
Route::post('songRef/{id}/updateLyric/',array('as'=>'songRef.updateLyric','uses'=>'SongRefController@updateLyric'));
Route::get('songRef/{id}/editPassage/','SongRefController@editPassage');
Route::post('songRef/{id}/updatePassage/',array('as'=>'songRef.updatePassage','uses'=>'SongRefController@updatePassage'));

