<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsFeedController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\PricingPlanItemController;
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
   Route::get('whatsapp','showWhatsapp')->name('whatsapp');
    Route::post('/save','saveMessage')->name('save-messages');
   Route::get('/SSN','getSSN');
   Route::get('/test','test');
   Route::get('/policy','showPolicy');
   Route::get('/dashboard','dashboard')->name('dashboard')->middleware('auth');
    Route::get('/messages','showMessages')->name('show-messages')->middleware('auth');
    Route::get('/attended/{id}','attend')->name('attended')->middleware('auth');
    Route::get('/cards','showCards')->name('show-cards')->middleware('auth');
    Route::get('/finish/{id}','finish')->name('finish')->middleware('auth');
   Route::get('/settings','showSettings')->name('settings')->middleware('auth');
   Route::post('/settings','setSettings')->name('save-settings')->middleware('auth');
   Route::get('/reports','showReports')->name('reports')->middleware('auth');
   Route::get('/registrations','showRegistrations')->name('registrations')->middleware('auth');
    Route::get('/register/{id}','register')->name('register')->middleware('auth');
    Route::get('/unregister/{id}','unregister')->name('unregister')->middleware('auth');
});

Route::middleware('auth')->group(function(){
    Route::controller(NewsFeedController::class)->group(function(){
       Route::get('/news','index')->name('show-news');
       Route::post('/create-news','create')->name('create-news');
       Route::get('/delete-news/{id}','delete')->name('delete-news');
    });
    Route::controller(PricingPlanController::class)->group(function(){
        Route::get('/pricing','index')->name('show-pricing');
        Route::post('/create-pricing','store')->name('create-pricing');
        Route::get('/delete-pricing/{id}','delete')->name('delete-pricing');
    });

    Route::controller(PricingPlanItemController::class)->group(function(){
        Route::post('/create-pricing-item','store')->name('create-pricing-item');
        Route::get('/delete-pricing-item/{id}','delete')->name('delete-pricing-item');
    });
});

Route::controller(AuthController::class)->group(function(){
   Route::post('/','login')->name('login');
   Route::get('/logout','logout')->name('logout');
});
