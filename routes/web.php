<?php

use App\Http\Controllers\DevController;
use App\Http\Controllers\GroupAdminController;
use App\Http\Controllers\GroupController;
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

    // Groups
    Route::post('/group/switch', [GroupController::class, 'switchGroup'])->name('group.switch');
    Route::get('/group/new-or-enter', [GroupController::class, 'addGroupShow'])->name('group.new.show');
    Route::post('/group/enter', [GroupController::class, 'enterGroup'])->name('group.enter');
    Route::post('/group/new/create', [GroupController::class, 'createGroup'])->name('group.new.create');

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
    Route::get('/admin', [GroupAdminController::class, 'show'])->name('group-admin');
    Route::patch('/admin/save-settings', [GroupAdminController::class, 'saveSettings'])->name('group-admin.save-settings');
    Route::patch('/admin/invite-code-change', [GroupAdminController::class, 'changeInviteCode'])->name('group-admin.change-invite-code');
    Route::put('/admin/user/add-role', [GroupAdminController::class, 'addRoleToUser'])->name('group-admin.users.add-role');
    Route::delete('/admin/user/delete-role', [GroupAdminController::class, 'removeRoleFromUser'])->name('group-admin.users.delete-role');
    Route::put('/admin/roles/create', [GroupAdminController::class, 'createRole'])->name('group-admin.roles.create');
    Route::patch('/admin/roles/save', [GroupAdminController::class, 'saveRoles'])->name('group-admin.roles.save');
    Route::delete('/admin/roles/delete', [GroupAdminController::class, 'deleteRole'])->name('group-admin.roles.delete');
    Route::delete('/admin/user/kick', [GroupAdminController::class, 'kickUser'])->name('group-admin.users.kick');

    // Dev Routes
    Route::get('/dev', [DevController::class, 'show'])->name('dev');
    Route::post('/dev/loginasuser', [DevController::class, 'loginAsUser'])->name('dev.login_as_user');
    Route::get('/dev/loginasuser/back', [DevController::class, 'logBack'])->name('dev.login_as_user.back');
    Route::get('/dev/switch/tipp_mode', [DevController::class, 'switchTippMode'])->name('dev.switch_tipp_mode');

});

Auth::routes(['register' => Setting::get("register_enabled", true)]);
