<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Kegiatan;
use App\Observers\KegiatanObserver;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // ✅ DAFTARKAN OBSERVER
        Kegiatan::observe(KegiatanObserver::class);
    }
}