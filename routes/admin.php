<?php

use App\Http\Controllers\Admin\AdminController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\KelasController;

// Rute Login (Bisa diakses tanpa login)
Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.auth.submit');

// Grup Rute yang Dilindungi (Wajib Login)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/kelola-kelas', [KelasController::class, 'index'])->name('admin.kelola.kelas');
});