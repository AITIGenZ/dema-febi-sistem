<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Iuran;
use App\Models\Pendaftaran;
use Illuminate\Support\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
{
    // Data kegiatan 6 bulan terakhir untuk chart
    $chartKegiatan = collect(range(5, 0))
        ->map(fn ($i) => Kegiatan::whereMonth('created_at', now()->subMonths($i)->month)
            ->whereYear('created_at', now()->subMonths($i)->year)
            ->count()
        )->toArray();

    // Data absensi 7 hari terakhir
    $chartAbsensi = collect(range(6, 0))
        ->map(fn ($i) => \App\Models\Absensi::whereDate('created_at', now()->subDays($i))
            ->count()
        )->toArray();

    return [
        Card::make('Kegiatan Bulan Ini', Kegiatan::whereMonth('created_at', now()->month)->count())
            ->chart($chartKegiatan)
            ->color('success'),

        Card::make('Total Absensi Hari Ini', \App\Models\Absensi::whereDate('created_at', today())->count())
            ->chart($chartAbsensi)
            ->color('primary'),
    ];
}