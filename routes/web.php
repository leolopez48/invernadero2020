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

Auth::routes(['register' => false], ['password.request' => false]);

Route::get('/home', 'HomeController@index')->name('home');

//Registros 
Route::post('/api/add/', 'RegistroController@add');
Route::get('/api/get/{id}', 'RegistroController@get');

//Admin
Route::get('/admin', function(){
    return view('admin');
});