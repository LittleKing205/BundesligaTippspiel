<?php

use App\Http\Controllers\DevController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\TippController;
use App\Http\Controllers\TreasurerController;
use App\Models\Setting;
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
    Route::get('/regeln', [RulesController::class, 'show'])->name('rules');

    Route::get('/statistiken', [StatisticsController::class, 'show'])->name('statistics');
    Route::post('/statistiken/pay', [StatisticsController::class, 'pay'])->name('statistics.pay');

    Route::get('/kassenwart', [TreasurerController::class, 'show'])->name('treasurer');
    Route::patch('/kassenwart', [TreasurerController::class, 'rejectPayment'])->name('treasurer.reject_payment');
    Route::get('/kassenwart/validate/{bill:id}/{validate?}', [TreasurerController::class, 'validatePayment'])->name('treasurer.validate_payment');

    Route::get('/profil', [ProfileController::class, 'show'])->name('profile');
    Route::patch('/profil/save', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profil/updateButtonColors', [ProfileController::class, 'updateColors'])->name('profile.updateColors');

    // Tipps
    Route::get('/tipp/bl{league}/{day?}', [TippController::class, 'show'])->name('tipps');
    Route::post('/tipp/save', [TippController::class, 'store'])->name('tippStore');

    // WebPush Benachrichtigungen
    Route::post('/profil/storeWebPush', [ProfileController::class, 'storeWebPush'])->name('profile.storeWebPush');
    Route::delete('/profil/deleteWebPush', [ProfileController::class, 'deleteWebPush'])->name('profile.deleteWebPush');

    // SMS Tokens
    Route::post('/profil/getSmsToken', [ProfileController::class, 'getSmsToken'])->name('profile.getSmsToken');
    Route::post('/profil/storeNumber', [ProfileController::class, 'storeNumber'])->name('profile.storeNumber');
    Route::delete('/profil/deleteNumber', [ProfileController::class, 'deleteNumber'])->name('profile.deleteNumber');

    // Join Benachrichtigungen
    Route::post('/profil/storeJoin', [ProfileController::class, 'storeJoin'])->name('profile.storeJoin');
    Route::delete('/profil/deleteJoin', [ProfileController::class, 'deleteJoin'])->name('profile.deleteJoin');

    // Admin Routes

    // Dev Routes
    Route::get('/dev', [DevController::class, 'show'])->name('dev');
    Route::post('/dev/loginasuser', [DevController::class, 'loginAsUser'])->name('dev.login_as_user');
    Route::get('/dev/loginasuser/back', [DevController::class, 'logBack'])->name('dev.login_as_user.back');
    Route::get('/dev/switch/tipp_mode', [DevController::class, 'switchTippMode'])->name('dev.switch_tipp_mode');

});

Auth::routes(['register' => Setting::get("register_enabled", true)]);
