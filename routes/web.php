<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [
	'uses' => 'HomeController@index',
	'as' => 'home'
]);

Route::get('/newchat/{id}', [
	'uses' => 'ChatController@newchat',
	'as' => 'newchat'
]);

Route::get('/chat/{id}', [
	'uses' => 'ChatController@chat',
	'as' => 'chat'
]);

Route::post('/sendMessage', [
	'uses' => 'ChatController@sendMessage',
	'as' => 'send.message'
]);
