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
    return view('auth/login');
});


/*
This create a private route group. The function is revoke that route, acces or
resources to unauthorized users
*/
Route::group(['middleware' => 'auth'], function () {

  Route::get('/', 'HomeController@index');
  Route::get('/deleteAccount', 'UserController@deleteAccount');

  Route::get('/list', function()
  {
    return "helllo";
  });

  Route::get('/home', 'HomeController@index');
  Route::get('/video', 'VideoController@index');
  // download video
  Route::post('/video', 'VideoController@index');
  // Route::get('/download/{location}', function($location)
  // {
  //   $file = $location;
  //   return Response::download($file,'video.mp4',
  //   ['Content-Type','application/mp4']);
  // });  //Route::post('/download/{location}', 'VideoController@download');
  Route::post('/download/', 'VideoController@download');

});
Route::auth();
