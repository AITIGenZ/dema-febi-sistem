<?php

namespace App\Filament\Widgets;

use App\Models\Kegiatan;
use Filament\Widgets\ChartWidget;

class KegiatanChart extends ChartWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasRole('pimpinan');
    }

    protected static ?string $heading = 'Kegiatan Sepanjang Tahun';
    protected static ?string $description = 'Jumlah kegiatan DEMA FEBI per bulan tahun ini';
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $namaBulan = [
            1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',
            7=>'Jul',8=>'Agu',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des',
        ];

        $data = Kegiatan::selectRaw('MONTH(tanggal) as bulan, COUNT(*) as total')
            ->whereYear('tanggal', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        $chartData = [];
        for ($i = 1; $i <= 12; $i++) {
            $chartData[] = $data[$i] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Kegiatan',
                    'data' => $chartData,
                    'borderColor' => 'rgba(99, 102, 241, 1)',
                    'backgroundColor' => 'rgba(99, 102, 241, 0.15)',
                    'pointBackgroundColor' => 'rgba(139, 92, 246, 1)',
                    'pointBorderColor' => '#fff',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 5,
                    'fill' => true,
                    'tension' => 0.4,
                ],
            ],
            'labels' => array_values($namaBulan),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}