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
   Route::get('/dashboard','dashboard')->name('dashboard')->middleware('auth');
});
Route::controller(AuthController::class)->group(function(){
   Route::post('/','login')->name('login');
   Route::get('/logout','logout')->name('logout');
});
