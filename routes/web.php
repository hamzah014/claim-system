<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/file/download/{uuid}', [\App\Http\Controllers\FileController::class, 'downloadFile'])->name('file.download');
Route::get('/file/delete/{uuid}', [\App\Http\Controllers\FileController::class, 'deleteFile'])->name('file.delete');

require __DIR__ . '/admin.php';
require __DIR__ . '/staff.php';