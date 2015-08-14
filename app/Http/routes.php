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



Route::group(['middleware' => 'auth'], function(){
    Route::get('/', function () {
        return redirect('dashboard');
    });

    Route::get('dashboard', function () {
        return view('dashboard');
    });

    Route::group(['prefix' => 'users'], function(){
        Route::controller('user', 'UserController', ['user' => 'getIndex']);
        Route::controller('role', 'RoleController', ['role' => 'getIndex']);
    });
    Route::group(['prefix' => 'settings'], function(){
        Route::controller('application', 'Setting\ApplicationController', ['application' => 'getIndex']);
        Route::controller('email', 'Setting\EmailController', ['email' => 'getIndex']);
    });
});


Route::controller('auth', 'AuthController');
