<?php

namespace App\Filament\Widgets;

use App\Models\Dinas;
use Filament\Widgets\ChartWidget;

class AnggotaChart extends ChartWidget
{
    public static function canView(): bool
    {
        return auth()->user()->hasRole('pimpinan');
    }
    protected static ?string $heading = 'Anggota per Dinas';
    protected static ?string $description = 'Jumlah anggota aktif di setiap dinas DEMA FEBI';
    protected static ?int $sort = 2;
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $dinas = Dinas::withCount([
            'users' => fn($query) => $query->where('status', 'aktif')
        ])->get();

        $labels = $dinas->pluck('nama_dinas')->toArray();
        $data = $dinas->pluck('users_count')->toArray();

        $colors = [
         'rgba(26, 122, 122, 0.8)',
         'rgba(42, 191, 191, 0.8)',
         'rgba(15, 88, 88, 0.8)',
         'rgba(26, 160, 160, 0.8)',
         'rgba(100, 210, 210, 0.8)',
         'rgba(10, 60, 60, 0.8)',
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