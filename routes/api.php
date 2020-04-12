<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Auth::routes(['verify' => true]);

Route::get('/user', function() {
    return Auth::user();
})->name('user');

Route::post('/password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('/password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('/user/{id}', 'HomeController@update');
Route::post('/user/{id}/upload', 'HomeController@upload');
// Route::post('/user/{id}', function() {
//     dd(request()->all());
// });

Route::get('/home', 'HomeController@index');

Route::post('/register', 'Auth\RegisterController@register')->name('register');
Route::post('/login', 'Auth\LoginController@login')->name('login');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

// Route::resource('items', 'ItemController');
Route::get('/items', 'ItemController@index')->name('items.index');
Route::get('/items/{id}', 'ItemController@show')->name('items.show');
Route::post('/items', 'ItemController@store');
Route::post('/items/{id}/comments', 'ItemController@storeComment')->name('items.comment');

Route::put('/items/{id}/like', 'ItemController@like')->name('items.like');
Route::delete('/items/{id}/like', 'ItemController@unlike');