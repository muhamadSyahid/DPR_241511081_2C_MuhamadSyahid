<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KomponenGajiController;
use App\Http\Controllers\PenggajianController;
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
    Route::resource('penggajian', PenggajianController::class)->parameters([
        'penggajian' => 'anggota',
    ])->except(['destroy']);
    
    Route::middleware(['check.admin'])->group(function () {
        Route::resource('komponen-gaji', KomponenGajiController::class)->parameters([
            'komponen-gaji' => 'komponen_gaji',
        ]);
        
        Route::delete('penggajian/{anggota}/component/{komponen_gaji}', [PenggajianController::class, 'destroy'])
            ->name('penggajian.destroy');
        Route::delete('penggajian/{anggota}/all', [PenggajianController::class, 'destroyAll'])
            ->name('penggajian.destroy-all');
    });
});
