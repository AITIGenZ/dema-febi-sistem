<?php

namespace App\Filament\Widgets;

use App\Models\User;
use App\Models\Kegiatan;
use App\Models\Iuran;
use App\Models\Pendaftaran;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasAnyRole(['pimpinan', 'pengurus']);
    }
    protected function getStats(): array
    {
        // Hitung total anggota aktif
        $totalAnggota = User::where('status', 'aktif')->count();

        // Hitung kegiatan bulan ini
        $kegiatanBulanIni = Kegiatan::whereMonth('tanggal', now()->month)
            ->whereYear('tanggal', now()->year)
            ->count();

        // Hitung iuran yang belum lunas
        $iuranBelumLunas = Iuran::where('status', 'belum')->count();

        // Hitung pendaftaran yang masih pending
        $pendaftaranPending = Pendaftaran::where('status', 'pending')->count();

        return [
            // Stat 1 — Total anggota aktif
            Stat::make('Total Anggota Aktif', $totalAnggota)
                ->description('Anggota DEMA FEBI aktif')
                ->descriptionIcon('heroicon-o-users')
                ->color('success')
                ->chart([7, 5, 10, 8, 12, 9, $totalAnggota]),

            // Stat 2 — Kegiatan bulan ini
            Stat::make('Kegiatan Bulan Ini', $kegiatanBulanIni)
                ->description('Total kegiatan ' . now()->translatedFormat('F Y'))
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('info')
                ->chart([2, 4, 3, 5, 2, 4, $kegiatanBulanIni]),

            // Stat 3 — Iuran belum lunas
            Stat::make('Iuran Belum Lunas', $iuranBelumLunas)
                ->description('Anggota belum bayar iuran')
                ->descriptionIcon('heroicon-o-exclamation-circle')
                ->color($iuranBelumLunas > 0 ? 'danger' : 'success'),

            // Stat 4 — Pendaftaran pending
            Stat::make('Pendaftaran Pending', $pendaftaranPending)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-o-clock')
                ->color($pendaftaranPending > 0 ? 'warning' : 'success'),
        ];
    }
}