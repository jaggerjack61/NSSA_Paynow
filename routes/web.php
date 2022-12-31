<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
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


Route::controller(MainController::class)->group(function(){
   Route::get('/','index')->name('home');
   Route::get('/SSN','getSSN');
   Route::get('/test','test');
   Route::get('/policy','showPolicy');
   Route::get('/dashboard','dashboard')->name('dashboard')->middleware('auth');
   Route::get('/settings','showSettings')->name('settings')->middleware('auth');
   Route::post('/settings','setSettings')->name('save-settings')->middleware('auth');
   Route::get('/reports','showReports')->name('reports')->middleware('auth');
   Route::get('/registrations','showRegistrations')->name('registrations')->middleware('auth');
    Route::get('/register/{id}','register')->name('register')->middleware('auth');
    Route::get('/unregister/{id}','unregister')->name('unregister')->middleware('auth');
});
Route::controller(AuthController::class)->group(function(){
   Route::post('/','login')->name('login');
   Route::get('/logout','logout')->name('logout');
});
