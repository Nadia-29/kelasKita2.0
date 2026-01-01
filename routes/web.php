<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\LaporanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Grouping Route khusus Admin
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/kelola-kelas', [KelasController::class, 'index'])->name('admin.kelola.kelas');
    Route::get('/kelola-report', [ReportController::class, 'index'])->name('admin.kelola.report');
    Route::get('/kelola-laporan', [LaporanController::class, 'index'])->name('admin.kelola.laporan');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    // Login Routes
    Route::get('/login', [AdminController::class, 'loginForm'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'authenticate'])->name('admin.auth.submit');
});
