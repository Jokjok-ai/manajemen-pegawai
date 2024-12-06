<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PegawaiController;

Route::get('/pegawai', function () {
    return view('welcome');
});

// Route untuk Pegawai
Route::get('/pegawai/create', [PegawaiController::class, 'create'])->name('pegawai.create');
Route::post('/pegawai/store', [PegawaiController::class, 'store'])->name('pegawai.store');
Route::get('/pegawai/{id}', [PegawaiController::class, 'show'])->name('pegawai.show');
Route::post('/pegawai/upload', [PegawaiController::class, 'upload'])->name('pegawai.upload');

Route::resource('pegawai', PegawaiController::class);
