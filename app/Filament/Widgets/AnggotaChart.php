<?php

namespace App\Filament\Widgets;

use App\Models\Divisi;
use Filament\Widgets\ChartWidget;

class AnggotaChart extends ChartWidget
{
    protected static ?string $heading = 'Anggota per Divisi';
    protected static ?string $description = 'Jumlah anggota aktif di setiap divisi DEMA FEBI';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $divisis = Divisi::withCount([
            'users' => fn($query) => $query->where('status', 'aktif')
        ])->get();

        $labels = $divisis->pluck('nama_divisi')->toArray();
        $data = $divisis->pluck('users_count')->toArray();

        $colors = [
            'rgba(59, 130, 246, 0.8)',
            'rgba(16, 185, 129, 0.8)',
            'rgba(245, 158, 11, 0.8)',
            'rgba(239, 68, 68, 0.8)',
            'rgba(139, 92, 246, 0.8)',
            'rgba(236, 72, 153, 0.8)',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Jumlah Anggota',
                    'data' => $data,
                    'backgroundColor' => array_slice($colors, 0, count($data)),
                    'borderRadius' => 6,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}