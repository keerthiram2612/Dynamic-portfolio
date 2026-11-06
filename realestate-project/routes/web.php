<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ProfileController;

Route::prefix('admin')->group(function () {
    Route::middleware('guest')->group(function () {
        Route::get('login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('login', [AuthController::class, 'login'])->name('admin.login.submit');
    });

    Route::middleware('auth')->group(function () {
        Route::get('/', fn () => redirect()->route('admin.profile.edit'));
        Route::get('profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('admin.profile.update');
        Route::post('logout', [AuthController::class, 'logout'])->name('admin.logout');
    });
});


