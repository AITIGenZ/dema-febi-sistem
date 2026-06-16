<?php

namespace App\Livewire\Keuangan;

use App\Models\KasSetting;
use App\Models\PembayaranKas;
use App\Models\User;
use App\Models\Kas;
use App\Services\KasService;
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
        $kasSetting = KasSetting::findOrFail($this->kasSettingId);
        $user = User::findOrFail($userId);
        app(KasService::class)->bayar($user, $kasSetting, $bulan, $this->tahun);
        $this->dispatch('kas-updated');
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

        $sudahBayarBulanIni = 0;
        if ($this->kasSettingId) {
            $sudahBayarBulanIni = PembayaranKas::where('kas_setting_id', $this->kasSettingId)
                ->where('bulan', now()->month)
                ->where('tahun', $this->tahun)
                ->where('status', 'lunas')
                ->count();
        }

        return [
            'kas_bulanan'   => $kasBulanan,
            'semua_kas'     => $semuaKas,
            'sudah_bayar'   => $sudahBayarBulanIni,
            'total_anggota' => $totalAnggota,
        ];