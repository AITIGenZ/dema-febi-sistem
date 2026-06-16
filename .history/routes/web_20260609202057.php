<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\KalenderProkerController;
use App\Services\WhatsAppService;

// Landing Page Publik — bisa diakses tanpa login
Route::get('/', [LandingController::class, 'index'])->name('landing');
Route::get('/kalender-data', [LandingController::class, 'kalender'])->name('kalender.data');
Route::get('/kegiatan/{id}', [LandingController::class, 'detailKegiatan'])->name('kegiatan.detail');

// Kalender Proker Public Routes
Route::prefix('api/kalender')->name('api.kalender.')->group(function () {
    Route::get('/events', [KalenderProkerController::class, 'getCalendarEvents'])->name('events');
    Route::get('/{kalenderProker}', [KalenderProkerController::class, 'show'])->name('show');
});

// Export PDF — hanya untuk yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/export/absensi/{id}', [PdfController::class, 'absensi'])->name('export.absensi');
    Route::get('/export/keuangan', [PdfController::class, 'keuangan'])->name('export.keuangan');
});

// Kalender Proker Protected Routes — hanya untuk yang sudah login
Route::middleware(['auth'])->prefix('api/kalender')->name('api.kalender.')->group(function () {
    Route::get('/', [KalenderProkerController::class, 'index'])->name('index');
    Route::post('/', [KalenderProkerController::class, 'store'])->name('store');
    Route::get('/create', [KalenderProkerController::class, 'create'])->name('create');
    Route::get('/{kalenderProker}/edit', [KalenderProkerController::class, 'edit'])->name('edit');
    Route::put('/{kalenderProker}', [KalenderProkerController::class, 'update'])->name('update');
    Route::delete('/{kalenderProker}', [KalenderProkerController::class, 'destroy'])->name('destroy');
    
    // Status endpoints
    Route::post('/{kalenderProker}/mark-ongoing', [KalenderProkerController::class, 'markOngoing'])->name('mark-ongoing');
    Route::post('/{kalenderProker}/mark-completed', [KalenderProkerController::class, 'markCompleted'])->name('mark-completed');
    Route::post('/{kalenderProker}/mark-cancelled', [KalenderProkerController::class, 'markCancelled'])->name('mark-cancelled');
    Route::post('/bulk-update-status', [KalenderProkerController::class, 'bulkUpdateStatus'])->name('bulk-update-status');
    
    // Event options
    Route::get('/{kalenderProker}/event-options', [KalenderProkerController::class, 'getEventOptions'])->name('event-options');
});

// Notifikasi API — hanya untuk yang sudah login
Route::middleware(['auth'])->prefix('api/notifications')->name('api.notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('/unread', [NotificationController::class, 'unread'])->name('unread');
    Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
    Route::post('/{id}/read', [NotificationController::class, 'markAsRead'])->name('mark-as-read');
    Route::post('/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-as-read');
    Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
    Route::delete('/', [NotificationController::class, 'deleteAll'])->name('delete-all');
});
Route::get('/test-wa', function () {
    $response = WhatsAppService::send('62851
    ', 'Test WA dari Laravel! ✅');
    
    return $response->json();
});

// Route bawaan Laravel Breeze
require __DIR__ . '/auth.php';
