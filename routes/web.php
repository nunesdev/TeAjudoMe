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


Route::prefix('api')->group(function () {
  Route::post('/',['uses'=>'UserController@save']);
  Route::post('/saveStore',['uses'=>'UserController@saveStore']);
  Route::get('/',['uses'=>'UserController@all']);

  Route::prefix('campaign')->group(function(){
    Route::get('/',['uses'=>'UserController@allByCampaign']);
  });
});

Route::get('/movimento117', function(){
  return redirect('/#/movimento117');
});
