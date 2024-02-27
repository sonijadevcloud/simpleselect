<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TwoFactorController;
use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\SystemSettingsController;



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
    if (Auth::check()) {
        return redirect('/home'); // Jeśli użytkownik jest zalogowany, przekieruj go do /home
    } else {
        return view('auth.login'); // Jeśli użytkownik nie jest zalogowany, zwróć widok logowania
    }
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
    Route::resource('users', UserController::class)->middleware('permissions');
    Route::get('permissions', [AdminPermissionController::class, 'index'])->name('permissions.index')->middleware('permissions');
    Route::post('permissions', [AdminPermissionController::class, 'storePermission'])->name('permissions.store');
    // Route::get('permissions/create', [AdminPermissionController::class, 'createPermissionForm'])->name('permissions.create');
    // Route::get('permissions/{permission}', [AdminPermissionController::class, 'show'])->name('permissions.show');
    // Route::get('permissions/{permission}/edit', [AdminPermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('permissions/{permission}/update', [AdminPermissionController::class, 'updatePermission'])->name('permissions.update');
    Route::delete('permissions/{permission}', [AdminPermissionController::class, 'destroyPermission'])->name('permissions.destroy');
    // Route::get('roles/create', [AdminPermissionController::class, 'createRoleForm'])->name('roles.create');
    Route::post('roles/store', [AdminPermissionController::class, 'storeRole'])->name('roles.store');
    Route::delete('roles/{role}', [AdminPermissionController::class, 'destroyRole'])->name('roles.destroy');
    Route::put('roles/{role}/update', [AdminPermissionController::class, 'updateRole'])->name('roles.update');
    Route::get('systemsettings', [SystemSettingsController::class, 'index'])->name('systemsettings.index')->middleware('permissions');
    Route::post('systemsettings', [SystemSettingsController::class, 'update'])->name('systemsettings.update');
});


