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

Route::get('/nosotros', function () {
    return view('about');
});

Auth::routes(['register' => true], ['password.request' => false]);

Route::get('/home', 'HomeController@index')->name('home');

//Records
Route::post('/api/add/', 'RecordController@add');
Route::get('/api/get/{id}', 'RecordController@get');
//Stations
Route::post('/api/stations/get/', 'StationController@index');
Route::post('/api/stations/edit', 'StationController@edit');
Route::post('/api/stations/delete', 'StationController@delete');
Route::post('/api/stations/add', 'StationController@add');

//Admin
Route::get('/admin', function(){
    return view('admin');
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
