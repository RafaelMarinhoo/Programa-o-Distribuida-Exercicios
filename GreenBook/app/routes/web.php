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
Route::resource('home', 'HomeController');
Route::resource('profile', 'ProfileController');

//home
Route::get('/home', 'HomeController@index')->name('home');
Route::post('/comment', 'HomeController@comment')->name('comment');
Route::post('/removeComment', 'HomeController@removeComment')->name('removeComment');

//profile
Route::get('/profile', 'ProfileController@index')->name('profile');
Route::post('/updatePhoto', 'ProfileController@updatePhoto')->name('updatePhoto');
Route::get('/removePhoto', 'ProfileController@removePhoto')->name('removePhoto');
Route::post('/removePost', 'ProfileController@removePost')->name('removePost');
Route::post('/removePlant', 'ProfileController@removePlant')->name('removePlant');
Route::post('/deleteUser', 'ProfileController@deleteUser')->name('deleteUser');
Route::post('/follow', 'ProfileController@follow')->name('follow');
Route::post('/unfollow', 'ProfileController@unfollow')->name('unfollow');
Route::post('/addPlant', 'ProfileController@addPlant')->name('addPlant');

//unknown_profile
Route::get('/unknown_profile', 'UnknownProfileController@index')->name('unknownProfile');

//diary
Route::get('/diary', 'DiaryController@index')->name('diary');
Route::post('/diaryUpdate', 'DiaryController@diaryUpdate')->name('diaryUpdate');

//messages
Route::get('/messages', 'MessagesController@index')->name('messages');

//chat
Route::get('/chat', 'ChatController@index')->name('chat');
Route::get('/list', 'ChatController@list')->name('list');
Route::get('/insertMessage', 'ChatController@insertMessage')->name('insertMessage');

//search
Route::get('/search', 'SearchController@index')->name('search');












