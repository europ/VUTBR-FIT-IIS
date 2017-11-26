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
|--------------------------------------------------------------------------
| Example
|--------------------------------------------------------------------------
|
| Route::get('/{pattern}/{example}', function ($pattern, $example) {
|     return view('patternfly.'.$pattern.'.'.$example);
| });
|
*/

Auth::routes();

// ROOT => goto => HOME
Route::get('/', 'HomeController@index')->name('home');

// HOME
Route::get('/home', 'HomeController@index')->name('home');


// #1 USERS
Route::get('/users', 'UserController@index')->name('users');
Route::get('/user/{id}', 'UserController@show');
Route::get('/user/{id}/edit', 'UserController@edit')->name('user-edit');
Route::post('/user/{id}/edit', 'UserController@update')->name('user-update');
Route::get('/user/{id}/delete', 'UserController@confirmDelete')->name('users.confirmDelete');
Route::delete('/users/{id}', 'UserController@destroy')->name('users.destroy');


// #2 LEKY
Route::get('/leky', 'LekyController@index')->name('leky');
Route::get('/leky/{id}', 'LekyController@show')->name('ukazlek');
Route::get('/leky-na-pobocce-{id}', 'LekyController@lekyNaPobocce')->name('leky-na-pobocce');
Route::get('/leky-na-pobocce', 'LekyController@lekyNaPobocceUser')->name('leky-na-pobocce');


// #3 POBOCKY
Route::resource('pobocky', 'PobockyController');
Route::get('/pobocky/{id}/confirm-delete', 'PobockyController@confirmDelete')->name('pobocky.confirmDelete');


// #4 DODAVATELE
Route::resource('dodavatele', 'DodavateliaController');
Route::get('/dodavatele/{id}/confirm-delete', 'DodavateliaController@confirmDelete')->name('dodavatele.confirmDelete');


// #5 PREDPISY
Route::get('/predpisy', 'PredpisyController@index')->name('predpisy');


// #6 REZERVACE
Route::resource('rezervace', 'RezervaceController');


// #7 POISTOVNY
Route::resource('poistovny', 'PoistovnyController');
Route::get('/poistovny/{id}/confirm-delete', 'PoistovnyController@confirmDelete')->name('poistovny.confirmDelete');

// HELP
Route::get(
	'/help',
	function () {
		return view('help.help');
	}
);


// ABOUT
Route::get(
	'/about',
	function () {
		return view('about.about');
	}
);
