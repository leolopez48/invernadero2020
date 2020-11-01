<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Users;

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

//Views
Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/suscriptions', function(){
    return view('subscriptions');
})->name('suscriptions');

Route::get('/nosotros', function () {
    return view('about');
});

Route::get('/home', 'HomeController@index')->name('home');

//Records
Route::post('/api/add/', 'RecordController@add');
Route::get('/api/get/{id}', 'RecordController@get');
Route::post('/api/filter', 'RecordController@filterRecords')->name('filterRecords');

//Stations
Route::post('/api/stations/get/', 'StationController@index');
Route::post('/api/stations/edit', 'StationController@edit');
Route::post('/api/stations/delete', 'StationController@delete');
Route::post('/api/stations/add', 'StationController@add');

//Users
Route::post('/api/users/get/', 'UserController@findUser');
Route::post('/api/users/addStation/', 'UserController@addStationUser');
Route::post('/api/users/getSuscribed/', 'UserController@getUsersSuscribed');
Route::post('/api/users/deleteSuscription/', 'UserController@deleteUserSuscription');
Route::get('/user', 'UserController@user');

//Notifications
Route::get('/api/notifications/get', 'NotificationController@get');

// Route::group(['middleware'=>'web'], function () {
    //Admin
    Route::get('/admin', function(){
        return view('admin');
    });
// });

//Auth
Auth::routes(['register' => true], ['password.request' => false]);
