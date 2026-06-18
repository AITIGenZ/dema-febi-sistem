<?php

namespace App\Services;

use App\Models\Kas;
use App\Models\KasLibur;
use App\Models\KasSetting;
use App\Models\PembayaranKas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KasService
{
    public function bayar(User $user, KasSetting $kasSetting, int $bulan, int $tahun): PembayaranKas
    {
        $existing = PembayaranKas::where('user_id', $user->id)
            ->where('kas_setting_id', $kasSetting->id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        if ($existing) {
            return $existing;
        }

        return DB::transaction(function () use ($user, $kasSetting, $bulan, $tahun) {

            $kas = Kas::create([
            'jenis'      => 'masuk',
            'nominal'    => $kasSetting->nominal,
            'keterangan' => $kasSetting->tipe === 'bulanan'
                ? "Kas bulanan {$user->name} - " . $this->namaBulan($bulan) . " {$tahun}"
                : "Iuran {$kasSetting->nama} - {$user->name}",
            'tanggal'    => now(),
            'created_by' => Auth::id(),
        ]);

            $pembayaran = PembayaranKas::create([
            'user_id'        => $user->id,
            'kas_setting_id' => $kasSetting->id,
            'kas_id'         => $kas->id,
            'bulan'          => $bulan,
            'tahun'          => $tahun,
            'nominal'        => $kasSetting->nominal,
            'status'         => 'lunas',
            'tgl_bayar'      => now(),
            'created_by'     => Auth::id(),
        ]);

            return $pembayaran;
        });
    }

    public function isLibur(int $bulan, int $tahun): bool
    {
        return KasLibur::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();
    }

    public function getStatus(User $user, KasSetting $kasSetting, int $bulan, int $tahun): string
    {
        if ($this->isLibur($bulan, $tahun)) {
            return 'libur';
        }

        $pembayaran = PembayaranKas::where('user_id', $user->id)
            ->where('kas_setting_id', $kasSetting->id)
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->first();

        return $pembayaran?->status ?? 'belum';
    }

    public function getRingkasan(int $tahun): array
    {
        $kasBulanan = Kas::where('jenis', 'masuk')
            ->where('sumber', 'kas_bulanan')
            ->whereYear('tanggal', $tahun)
            ->sum('nominal');

        $iuran = Kas::where('jenis', 'masuk')
            ->where('sumber', 'iuran')
            ->whereYear('tanggal', $tahun)
            ->sum('nominal');

        $danaKampus = Kas::where('jenis', 'masuk')
            ->where('sumber', 'dana_kampus')
            ->whereYear('tanggal', $tahun)
            ->sum('nominal');

        $saldoAwal = Kas::where('jenis', 'masuk')
            ->where('sumber', 'saldo_awal')
            ->whereYear('tanggal', $tahun)
            ->sum('nominal');

        $pengeluaran = Kas::where('jenis', 'keluar')
            ->whereYear('tanggal', $tahun)
            ->sum('nominal');

        $saldoAkhir = $kasBulanan + $iuran + $danaKampus + $saldoAwal - $pengeluaran;

        return [
            'kas_bulanan'  => $kasBulanan,
            'iuran'        => $iuran,
            'dana_kampus'  => $danaKampus,
            'saldo_awal'   => $saldoAwal,
            'pengeluaran'  => $pengeluaran,
            'saldo_akhir'  => $saldoAkhir,
        ];
    }

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
    public function getDataMonitoring(int $tahun): array
{
    $users = User::with([])->where('status', 'aktif')->get();

    // 1 query ambil semua pembayaran tahun ini
    $semuaPembayaran = PembayaranKas::where('tahun', $tahun)
        ->get()
        ->groupBy(fn ($p) => $p->user_id . '-' . $p->bulan);

    $bulanList = ['Januari','Februari','Maret','April','Mei','Juni',
                'Juli','Agustus','September','Oktober','November','Desember'];

    $result = [];

    foreach ($users as $user) {
        $row = ['nama' => $user->name];

        foreach ($bulanList as $bulan) {
            $key = $user->id . '-' . $bulan;
            $pembayaran = $semuaPembayaran->get($key)?->first();

            $row[$bulan] = $pembayaran?->status ?? 'belum';
        }

        $result[] = $row;
    }

    return $result;
}

    public function getBulanAktif(KasSetting $kasSetting, int $tahun): array
    {
        if ($kasSetting->tipe === 'temporal') {
            return [];
        }

        $mulai = $kasSetting->berlaku_mulai
            ? (int) $kasSetting->berlaku_mulai->format('m')
            : 1;

        return range($mulai, 12);
    }

    public function namaBulan(int $bulan): string
    {
        $nama = [
            1  => 'Januari',  2  => 'Februari', 3  => 'Maret',
            4  => 'April',    5  => 'Mei',       6  => 'Juni',
            7  => 'Juli',     8  => 'Agustus',   9  => 'September',
            10 => 'Oktober',  11 => 'November',  12 => 'Desember',
        ];

        return $nama[$bulan] ?? '-';
    }
}