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


/*
This create a private route group. The function is revoke that route, acces or
resources to unauthorized users
*/
Route::group(['middleware' => 'auth'], function () {

  Route::get('/home', 'HomeController@index');

  Route::get('/list', function()
  {
    return "helllo";
  });

});
Route::auth();
