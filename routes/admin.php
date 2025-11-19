<?php

use Illuminate\Support\Facades\Route;


Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'login'])->name('login');
    Route::post('login', [\App\Http\Controllers\Auth\AdminLoginController::class, 'auth'])->name('login.auth');
    
    Route::middleware(['auth:admin'])->group(function () {
        
        Route::post('logout', [\App\Http\Controllers\Auth\AdminLoginController::class, 'logout'])->name('logout');

        Route::get('dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        // Claim Routes
        Route::prefix('claim')->name('claim.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\ClaimController::class, 'index'])->name('index');
            Route::get('/{claim}', [\App\Http\Controllers\Admin\ClaimController::class, 'view'])->name('view');
            Route::post('/update/{claim}', [\App\Http\Controllers\Admin\ClaimController::class, 'updateStatus'])->name('update.status');
        });

        // Staff
        Route::prefix('staff')->name('staff.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\StaffController::class, 'index'])->name('index');
            Route::get('/create', [\App\Http\Controllers\Admin\StaffController::class, 'create'])->name('create');
            Route::post('/store', [\App\Http\Controllers\Admin\StaffController::class, 'store'])->name('store');
            Route::get('/edit/{staff}', [\App\Http\Controllers\Admin\StaffController::class, 'edit'])->name('edit');
            Route::post('/update/{staff}', [\App\Http\Controllers\Admin\StaffController::class, 'update'])->name('update');
            Route::get('/delete/{staff}', [\App\Http\Controllers\Admin\StaffController::class, 'delete'])->name('delete');
        });

        // Setting management
        Route::prefix('department')->name('department.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\DepartmentController::class, 'index'])->name('index');
            Route::post('/store', [\App\Http\Controllers\Admin\DepartmentController::class, 'store'])->name('store');
            Route::post('/update/{department}', [\App\Http\Controllers\Admin\DepartmentController::class, 'update'])->name('update');
            Route::get('/delete/{department}', [\App\Http\Controllers\Admin\DepartmentController::class, 'delete'])->name('delete');
            Route::post('/get/data', [\App\Http\Controllers\Admin\DepartmentController::class, 'getData'])->name('data.get');
        });
        
        // Admin management
        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('index');
            Route::post('/store', [\App\Http\Controllers\Admin\AdminController::class, 'store'])->name('store');
            Route::post('/update/{admin}', [\App\Http\Controllers\Admin\AdminController::class, 'update'])->name('update');
            Route::get('/delete/{admin}', [\App\Http\Controllers\Admin\AdminController::class, 'delete'])->name('delete');
            Route::post('/get/data', [\App\Http\Controllers\Admin\AdminController::class, 'getData'])->name('data.get');
        });
        
        // Holiday
        Route::prefix('holiday')->name('holiday.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\PublicHolidayController::class, 'index'])->name('index');
            Route::post('/store', [\App\Http\Controllers\Admin\PublicHolidayController::class, 'store'])->name('store');
            Route::post('/update/{holiday}', [\App\Http\Controllers\Admin\PublicHolidayController::class, 'update'])->name('update');
            Route::get('/delete/{holiday}', [\App\Http\Controllers\Admin\PublicHolidayController::class, 'delete'])->name('delete');
            Route::post('/get/data', [\App\Http\Controllers\Admin\PublicHolidayController::class, 'getData'])->name('data.get');
        });
        
        // System Setting
        Route::prefix('setting')->name('setting.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\SystemSettingController::class, 'index'])->name('index');
            Route::post('/update/{setting}', [\App\Http\Controllers\Admin\SystemSettingController::class, 'update'])->name('update');
        });
        
        
    });

});