<?php

namespace App\Filament\Widgets;

use App\Models\Absensi;
use App\Models\Kegiatan;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        // Data kegiatan 6 bulan terakhir untuk chart
        $chartKegiatan = collect(range(5, 0))
            ->map(fn ($i) => Kegiatan::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->count()
            )->toArray();

        // Data absensi 7 hari terakhir
        $chartAbsensi = collect(range(6, 0))
            ->map(fn ($i) => Absensi::whereDate('created_at', now()->subDays($i))
                ->count()
            )->toArray();

        return [
            Stat::make('Kegiatan Bulan Ini', Kegiatan::whereMonth('created_at', now()->month)->count())
                ->chart($chartKegiatan)
                ->color('success')
                ->description('6 bulan terakhir'),

            Stat::make('Absensi Hari Ini', Absensi::whereDate('created_at', today())->count())
                ->chart($chartAbsensi)
                ->color('primary')
                ->description('7 hari terakhir'),
        ];
    }
}