<?php

use Illuminate\Support\Facades\Route;

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

Route::match(['get', 'post'], '/botman', 'BotManController@handle');
Route::get('/botman', 'BotManController@tinker');
Route::get('/test', 'BotManController@test');

// Route::get('/botman', function () {
//     return view('botman');
// });

// Route::post('/botman', function(){
// 	app('botman')->listen();
// });