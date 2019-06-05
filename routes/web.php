<?php

use App\Http\Controllers\PagesContoller;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PagesController@index');
Route::get('/test','PagesController@test');
Route::get('/profile', 'PagesController@prof');
Route::post('/profile','PagesController@update');
Route::get('showfile/{file}', 'PagesController@showfile');
Route::get('/about','PagesController@about');
Route::get('/references','PagesController@references');
Route::get('/home', 'HomeController@index')->name('home');
Route::resource('team','TeamController');
Route::resource('project','ProjectController');

Route::post('question/create','QuestionController@finalcreate');

Route::resource('question','QuestionController');

// for other user to answer question and stuff
Route::get('set/showform/{id}','SetController@showform');
// Route::get('set/showform/{id}', function($id){
//     return 'This is user with an id of '.$id;
// });


Route::post('set/showform','SetController@storeanswer');

// for coach to send form to user and add relation many to many
Route::post('set/sendform','SetController@SendForm');

// for chart stuff
// note this is id not $id !!!!!
Route::get('set/analysis/{id}', 'SetController@showanalysis');
Route::post('set/analysis','SetController@calculateanalysis');


Route::resource('set','SetController');

Auth::routes();
