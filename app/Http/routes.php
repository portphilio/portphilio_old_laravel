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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', function () {
        $user = Portphilio\User::first()->toJson();

        return view('dashboard', ['u' => $user]);
    });
    Route::get('users/profile', 'UserController@profile');
    Route::resource('users', 'UserController');
    Route::get('artifacts/json', 'ArtifactController@json');
    Route::resource('artifacts', 'ArtifactController');
});

Route::controller('oauth', 'OauthController');
Route::controller('', 'AccountController');
