<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group(['middleware' => ['web']], function () {
	Route::get('/', 'PostController@getGal');

	Route::get('/post', 'PostController@getPost');
	Route::post('/post', 'PostController@postPost');

	Route::get('/num/{id}', 'PostController@getNum');

	Route::post('/comm/{id}', 'PostController@postComment');
	
	Route::auth();
	
	Route::get('/dpost/{id}', 'PostController@dropPost');
	Route::get('/dcomm/{id}', 'PostController@dropComment');
	
	Route::get('/plu/{id}', 'PostController@plusPost');
	Route::get('/min/{id}', 'PostController@minusPost');
	
	Route::get('/best', 'PostController@getBest');
	Route::get('/bad', 'PostController@getBad');
});
