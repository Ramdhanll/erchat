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

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
// Route::get('{path}','HomeController@index')->where( 'path', '([A-z]+)?' ); // this for route in vue-route | 
Route::get('/contacts', 'ContactController@get');
Route::get('/conversation/{id}', 'ContactController@getMessagesFor');
Route::post('/conversation/send', 'ContactController@send');

Route::get('/{any}', function(){
    return view('layouts.vue');
})->where('any', '.*');