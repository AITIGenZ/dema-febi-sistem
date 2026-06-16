<?php

namespace App\Filament\Pages;

use App\Models\Kas;
use App\Models\KasSetting;
use App\Models\PembayaranKas;
use App\Models\User;
use App\Services\KasService;
use Filament\Pages\Page;
use Livewire\Attributes\Computed;

class MonitoringKeuangan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Monitoring Keuangan';
    protected static ?string $navigationGroup = 'Keuangan';
    protected static ?string $title = 'Monitoring Keuangan';
    protected static string $view = 'filament.pages.monitoring-keuangan';

    public int $tahun;
    public string $search = '';
    public string $filterStatus = 'semua';
    public ?int $kasSettingId = null;

    public function mount(): void
    {
        $this->tahun = now()->year;
        $setting = KasSetting::where('is_active', true)->where('tipe', 'bulanan')->first();
        $this->kasSettingId = $setting?->id;
    }


    public function bayar(int $userId, int $bulan): void
    {
        $kasSetting = KasSetting::findOrFail($this->kasSettingId);
        $user = User::findOrFail($userId);
        app(KasService::class)->bayar($user, $kasSetting, $bulan, $this->tahun);
    }

    public function getKasSettingsProperty()
    {
        return KasSetting::where('is_active', true)->where('tipe', 'bulanan')->get();
    }

    public function getKasSettingProperty()
    {
        return $this->kasSettingId ? KasSetting::find($this->kasSettingId) : null;
    }

    public function getBulanAktifProperty(): array
    {
        if (!$this->kasSetting) return range(1, 12);
        return app(KasService::class)->getBulanAktif($this->kasSetting, $this->tahun);
    }

    public function getCardsProperty(): array
    {
        $kasBulanan = Kas::where('jenis', 'masuk')
            ->where('sumber', 'kas_bulanan')
            ->whereYear('tanggal', $this->tahun)
            ->sum('nominal');

        $semuaKas = Kas::where('jenis', 'masuk')
            ->whereYear('tanggal', $this->tahun)
            ->sum('nominal');

        $totalAnggota = User::role(['pengurus', 'bendahara', 'sekretaris', 'ketua'])->count();

        $sudahBayar = 0;
        if ($this->kasSettingId) {
            $sudahBayar = PembayaranKas::where('kas_setting_id', $this->kasSettingId)
                ->where('bulan', now()->month)
                ->where('tahun', $this->tahun)
                ->where('status', 'lunas')
                ->count();
        }

        return [
            'kas_bulanan'   => $kasBulanan,
            'semua_kas'     => $semuaKas,
            'sudah_bayar'   => $sudahBayar,
            'total_anggota' => $totalAnggota,
            'belum_bayar'   => $totalAnggota - $sudahBayar,
        ];
    }

    public function getDataMonitoringProperty()
    {
        if (!$this->kasSettingId) return collect();

        $kasService = app(KasService::class);
        $bulanAktif = $this->bulanAktif;

        $users = User::role(['pengurus', 'bendahara', 'sekretaris', 'ketua'])
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->get();

        $data = $users->map(function ($user) use ($kasService, $bulanAktif) {
            $statusBulan = [];
            foreach ($bulanAktif as $bulan) {
                $statusBulan[$bulan] = $kasService->getStatus($user, $this->kasSetting, $bulan, $this->tahun);
            }
            return ['user' => $user, 'bulan' => $statusBulan];
        });

        if ($this->filterStatus === 'belum') {
            $data = $data->filter(fn($row) => collect($row['bulan'])->contains('belum'));
        }

        return $data->values();
    }

    protected function getViewData(): array
    {
        return [
            'cards'          => $this->cards,
            'kasSettings'    => $this->kasSettings,
            'bulanAktif'     => $this->bulanAktif,
            'dataMonitoring' => $this->dataMonitoring,
        ];
    }
}