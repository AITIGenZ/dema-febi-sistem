<?php

namespace App\Filament\Widgets;

use App\Models\Kegiatan;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class KegiatanChart extends ChartWidget
{
    protected static ?string $heading = 'Statistik Kegiatan';

    protected function getData(): array
    {
        $year = now()->year;

        $data = Kegiatan::query()
            ->select(
                DB::raw('MONTH(tanggal) as bulan'), // ✅ FIX DI SINI
                DB::raw('COUNT(*) as total')
            )
            ->whereYear('tanggal', $year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Isi semua bulan (1-12)
        $result = [];
        for ($i = 1; $i <= 12; $i++) {
            $result[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kegiatan',
                    'data' => $result,
                ],
            ],
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}