<?php

use Illuminate\Support\Facades\Route;


Route::get('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])->name('login.auth');


Route::middleware(['auth','staff'])->group(function () {
    
    Route::post('logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('dashboard', [\App\Http\Controllers\Staff\DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('claims')->name('claims.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Staff\ClaimController::class, 'index'])->name('index');
        Route::get('/create', [\App\Http\Controllers\Staff\ClaimController::class, 'create'])->name('create');
        Route::post('/store', [\App\Http\Controllers\Staff\ClaimController::class, 'store'])->name('store');
        Route::get('/edit/{claim}', [\App\Http\Controllers\Staff\ClaimController::class, 'edit'])->name('edit');
        Route::post('/update/{claim}', [\App\Http\Controllers\Staff\ClaimController::class, 'update'])->name('update');
        Route::get('/delete/{claim}', [\App\Http\Controllers\Staff\ClaimController::class, 'delete'])->name('delete');
    });

    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Staff\ProfileController::class, 'index'])->name('index');
        Route::post('/update/{user}', [\App\Http\Controllers\Staff\ProfileController::class, 'update'])->name('update');
        Route::post('/update/{user}/password', [\App\Http\Controllers\Staff\ProfileController::class, 'update_password'])->name('update.password');
    });
    
});