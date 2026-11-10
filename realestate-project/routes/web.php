<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MenuItemController;

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('admin.login.submit');
    });

    Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.profiles.index'));
    Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::name('admin.')->group(function () {
        Route::resource('profiles', ProfileController::class)->except('show');
        Route::resource('menus', MenuController::class)->except('show');

        Route::scopeBindings()->group(function () {
            Route::resource('menus.items', MenuItemController::class)->except('show');
        });
    });
});
});