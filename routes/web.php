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

Route::get('/', 'UserController@index');

// Route::get('/{pattern}/{example}', function ($pattern, $example) {
//     return view('patternfly.'.$pattern.'.'.$example);
// });

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/leky-na-pobocce', 'LekyController@lekyNaPobocce')->name('home');
// Route::get('/pobocky', 'PobockyController@index')->name('pobocky');
Route::get('/leky', 'LekyController@index')->name('leky');
Route::get('/leky/{id}', 'LekyController@show')->name('ukazlek');
Route::get('/poistovny','PoistovnyController@index')->name('poistovny');
Route::resource('pobocky', 'PobockyController');
Route::resource('dodavatele', 'DodavateliaController');
Route::get('/pobocky/{id}/confirm-delete', 'PobockyController@confirmDelete')->name('pobocky.confirmDelete');
// Route::get('/dodavatele', 'DodavateliaController@index')->name('dodavatele');


Auth::routes();


Route::get('/users', 'UserController@index')->name('users');
Route::get('/user/{id}', 'UserController@show');
Route::get('/user/{id}/edit', 'UserController@edit')->name('user-edit');
Route::post('/user/{id}/edit', 'UserController@update')->name('user-update');
Route::get('/user/{id}/delete', 'UserController@confirmDelete')->name('users.confirmDelete');
Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy');
