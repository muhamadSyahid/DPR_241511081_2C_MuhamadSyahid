<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('auth');

Route::middleware(['web'])->group(function () {
    Route::get('/berhasil', [AuthController::class, 'berhasil'])->name('berhasil');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::resource('anggota', AnggotaController::class)->parameters([
        'anggota' => 'anggota',
    ]);
});
