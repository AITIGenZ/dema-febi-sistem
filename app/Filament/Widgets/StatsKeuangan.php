<?php

namespace App\Filament\Widgets;

use App\Models\Iuran;
use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsKeuangan extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasRole('pimpinan');
    }

    protected function getStats(): array
    {
        $iuranBelumLunas = Iuran::where('status', 'belum')->count();
        $pendaftaranPending = Pendaftaran::where('status', 'pending')->count();

        return [
            Stat::make('Iuran Belum Lunas', $iuranBelumLunas)
                ->description('Anggota belum bayar iuran')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color($iuranBelumLunas > 0 ? 'danger' : 'success'),

            Stat::make('Pendaftaran Pending', $pendaftaranPending)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendaftaranPending > 0 ? 'warning' : 'success'),
        ];
    }
}