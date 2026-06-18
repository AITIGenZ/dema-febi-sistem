<?php

namespace App\Livewire\Keuangan;

use App\Models\KasSetting;
use App\Models\PembayaranKas;
use App\Models\User;
use App\Services\KasService; // ✅ Kas model tidak perlu lagi
use Livewire\Component;
use Livewire\WithPagination;

class MonitoringKeuangan extends Component
{
    use WithPagination;

    public int $tahun;
    public string $search = '';
    public string $filterStatus = 'semua'; // semua | belum | lunas | libur
    public ?int $kasSettingId = null;

    public function mount(): void
    {
        $this->tahun = now()->year;
        $setting = KasSetting::aktif()->bulanan()->first();
        $this->kasSettingId = $setting?->id;
    }

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }
    public function updatingTahun(): void { $this->resetPage(); }
    public function updatingKasSettingId(): void { $this->resetPage(); }

    public function bayar(int $userId, int $bulan): void
    {
        if (! auth()->user()->hasAnyRole(['bendahara', 'admin', 'ketua'])) {
            $this->notify('danger', 'Anda tidak punya akses untuk ini.');
            return;
        }

        $kasSetting = KasSetting::findOrFail($this->kasSettingId);
        $user = User::findOrFail($userId);
        app(KasService::class)->bayar($user, $kasSetting, $bulan, $this->tahun);
    }

    public function getKasSettingsProperty()
    {
        return KasSetting::aktif()->bulanan()->get();
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

    // ✅ Bug 16 — pakai KasService::getRingkasan(), hapus logic duplikat
    public function getCardsProperty(): array
    {
        $ringkasan = app(KasService::class)->getRingkasan($this->tahun);

        $totalAnggota = User::role(['pengurus', 'bendahara', 'sekretaris', 'ketua'])->count();

        $sudahBayarBulanIni = 0;
        if ($this->kasSettingId) {
            $sudahBayarBulanIni = PembayaranKas::where('kas_setting_id', $this->kasSettingId)
                ->where('bulan', now()->month)
                ->where('tahun', $this->tahun)
                ->where('status', 'lunas')
                ->count();
        }

        return [
            'kas_bulanan'   => $ringkasan['kas_bulanan'],
            'semua_kas'     => $ringkasan['kas_bulanan']
                                + $ringkasan['iuran']
                                + $ringkasan['dana_kampus']
                                + $ringkasan['saldo_awal'],
            'sudah_bayar'   => $sudahBayarBulanIni,
            'total_anggota' => $totalAnggota,
        ];
    }

    public function getDataMonitoringProperty()
    {
        if (!$this->kasSettingId) return collect();

        $kasService = app(KasService::class);

        $users = User::role(['pengurus', 'bendahara', 'sekretaris', 'ketua'])
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"))
            ->get();

        $bulanAktif = $this->bulanAktif;

        $data = $users->map(function ($user) use ($kasService, $bulanAktif) {
            $statusBulan = [];
            foreach ($bulanAktif as $bulan) {
                $statusBulan[$bulan] = $kasService->getStatus($user, $this->kasSetting, $bulan, $this->tahun);
            }
            return ['data_user' => $user, 'bulan' => $statusBulan];
        });

        // ✅ Bug 14 — handle semua status, bukan cuma 'belum'
        if ($this->filterStatus !== 'semua') {
            $data = $data->filter(function ($row) {
                return collect($row['bulan'])->contains($this->filterStatus);
            });
        }

        return $data->values();
    }

    public function render()
    {
        return view('livewire.keuangan.monitoring-keuangan', [
            'cards'          => $this->cards,
            'kasSettings'    => $this->kasSettings,
            'bulanAktif'     => $this->bulanAktif,
            'dataMonitoring' => $this->dataMonitoring,
        ]);
    }
}