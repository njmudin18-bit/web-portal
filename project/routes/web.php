<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AppsController;

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


Route::get('/login', 'App\Http\Controllers\LoginController@index')->name('login');
Route::post('/login', 'App\Http\Controllers\LoginController@check_login')->name('login.check_login');

Route::post('/apps-list', 'App\Http\Controllers\AppsController@list')->name('apps.list');


Route::group(['middleware' => 'revalidate'], function () {
  Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard');
    Route::get('/logout', 'App\Http\Controllers\DashboardController@logout')->name('dashboard.logout');

    Route::get('/users', 'App\Http\Controllers\UserController@index')->name('users');
    Route::get('/users-data', 'App\Http\Controllers\UserController@dataTable')->name('users.data');

    Route::get('/apps-data', 'App\Http\Controllers\AppsController@dataTable')->name('apps.data');
    Route::post('/apps-simpan', 'App\Http\Controllers\AppsController@save')->name('apps.simpan');
    Route::post('/apps-edit', 'App\Http\Controllers\AppsController@edit')->name('apps.edit');
    Route::post('/apps-hapus', 'App\Http\Controllers\AppsController@hapus')->name('apps.hapus');
    Route::post('/apps-update', 'App\Http\Controllers\AppsController@update')->name('apps.update');

    Route::post('/save-to-logs', 'App\Http\Controllers\LogsController@save')->name('logs.save');
  });
});
