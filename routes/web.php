<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// Route export PDF — hanya bisa diakses user yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/export/absensi/{id}', [PdfController::class, 'absensi'])
        ->name('export.absensi');
    Route::get('/export/keuangan', [PdfController::class, 'keuangan'])
        ->name('export.keuangan');
});