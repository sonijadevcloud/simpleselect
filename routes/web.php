<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\RoleController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/settings', [UserController::class, 'settings'])->name('settings')->middleware('auth');
Route::post('/settings', [UserController::class, 'updateSettings'])->middleware('auth');
Route::post('/settings/change-password', [UserController::class, 'changePassword'])->name('user.change.password')->middleware('auth');
Route::post('/settings/verify-2fa', [UserController::class, 'verifyTwoFactor'])->name('settings.verify-2fa')->middleware('auth');
Route::post('/settings/disable-2fa', [UserController::class, 'disableTwoFactor'])->name('settings.disable-2fa')->middleware('auth');

Route::get('/2fa', [TwoFactorController::class, 'index'])->name('2fa.index');
Route::post('/2fa', [TwoFactorController::class, 'verify'])->name('2fa.verify');


// ADMIN ROUTES
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
});
