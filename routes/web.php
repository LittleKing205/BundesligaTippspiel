<?php

use App\Http\Controllers\WebNotificationController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
App::setLocale('de');
Route::redirect('/', '/dashboard')->name('home');
Route::redirect('/home', '/dashboard');

Route::middleware('auth')->group(function () {
    //Sites
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::view('/regeln', 'rules')->name('rules');
    Route::get('/profil', 'App\Http\Controllers\ProfileController@show')->name('profile');

    // Tipps
    Route::get('/tipp/bl{league}', 'App\Http\Controllers\TippController@redictToDay')->name('tippsWithoutDay');
    Route::get('/tipp/bl{league}/{day?}', 'App\Http\Controllers\TippController@show')->name('tipps');
    Route::post('/tipp/save', 'App\Http\Controllers\TippController@store')->name('tippStore');

    // SMS Tokens
    Route::post('/profil/getSmsToken', 'App\Http\Controllers\ProfileController@getSmsToken')->name('profile.getSmsToken');
    Route::post('/profil/storeNumber', 'App\Http\Controllers\ProfileController@storeNumber')->name('profile.storeNumber');
    Route::delete('/profil/deleteNumber', 'App\Http\Controllers\ProfileController@deleteNumber')->name('profile.deleteNumber');
});

Route::get('/push-notificaiton', [WebNotificationController::class, 'index'])->name('push-notificaiton');
Route::post('/store-token', [WebNotificationController::class, 'storeToken'])->name('store.token');
Route::post('/send-web-notification', [WebNotificationController::class, 'sendWebNotification'])->name('send.web-notification');

Auth::routes();
