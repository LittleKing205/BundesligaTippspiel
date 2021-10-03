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
    Route::get('/statistiken', 'App\Http\Controllers\StatisticsController@show')->name('statistics');
    Route::get('/profil', 'App\Http\Controllers\ProfileController@show')->name('profile');
    Route::patch('/profil/save', 'App\Http\Controllers\ProfileController@update')->name('profile.update');

    // Tipps
    Route::get('/tipp/bl{league}', 'App\Http\Controllers\TippController@redictToDay')->name('tippsWithoutDay');
    Route::get('/tipp/bl{league}/{day?}', 'App\Http\Controllers\TippController@show')->name('tipps');
    Route::post('/tipp/save', 'App\Http\Controllers\TippController@store')->name('tippStore');

    // WebPush Benachrichtigungen
    Route::post('/profil/storeWebPush', 'App\Http\Controllers\ProfileController@storeWebPush')->name('profile.storeWebPush');
    Route::delete('/profil/deleteWebPush', 'App\Http\Controllers\ProfileController@deleteWebPush')->name('profile.deleteWebPush');

    // SMS Tokens
    Route::post('/profil/getSmsToken', 'App\Http\Controllers\ProfileController@getSmsToken')->name('profile.getSmsToken');
    Route::post('/profil/storeNumber', 'App\Http\Controllers\ProfileController@storeNumber')->name('profile.storeNumber');
    Route::delete('/profil/deleteNumber', 'App\Http\Controllers\ProfileController@deleteNumber')->name('profile.deleteNumber');

    // Join Benachrichtigungen
    Route::post('/profil/storeJoin', 'App\Http\Controllers\ProfileController@storeJoin')->name('profile.storeJoin');
    Route::delete('/profil/deleteJoin', 'App\Http\Controllers\ProfileController@deleteJoin')->name('profile.deleteJoin');

    // Admin Routes
    Route::get('/admin/switch/tipp_mode', 'App\Http\Controllers\AdminController@switchTippMode')->name('admin.switch_tipp_mode');
});

Auth::routes();
