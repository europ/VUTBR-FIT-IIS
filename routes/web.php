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
    return view('home');
});

// Route::get('/{pattern}/{example}', function ($pattern, $example) {
//     return view('patternfly.'.$pattern.'.'.$example);
// });

Route::get('/home', 'HomeController@index');

Auth::routes();

Route::get('/users', 'UserController@index')->name('users');
Route::get('/user/{id}', 'UserController@show');
Route::get('/user/{id}/edit', 'UserController@edit')->name('user-edit');
Route::post('/user/{id}/edit', 'UserController@update')->name('user-update');

