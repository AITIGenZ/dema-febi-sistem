<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PdfController;

// Landing Page Publik — bisa diakses tanpa login
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/kalender-data', [LandingController::class, 'kalender'])->name('kalender.data');
Route::get('/kegiatan/{id}', [LandingController::class, 'detailKegiatan'])->name('kegiatan.detail');

// Export PDF — hanya untuk yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/export/absensi/{id}', [PdfController::class, 'absensi'])->name('export.absensi');
    Route::get('/export/keuangan', [PdfController::class, 'keuangan'])->name('export.keuangan');
});

// Route bawaan Laravel Breeze
require __DIR__ . '/auth.php';