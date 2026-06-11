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
    /**
     * Proses pembayaran kas anggota.
     * Dipanggil saat tombol merah diklik di MonitoringKeuangan.
     */
    public function bayar(User $user, KasSetting $kasSetting, int $bulan, int $tahun): PembayaranKas
    {
        return DB::transaction(function () use ($user, $kasSetting, $bulan, $tahun) {

            // 1. Buat transaksi di tabel kas
            $kas = Kas::create([
                'jenis'      => 'masuk',
                'sumber'     => $kasSetting->tipe === 'bulanan' ? 'kas_bulanan' : 'iuran',
                'nominal'    => $kasSetting->nominal,
                'keterangan' => $kasSetting->tipe === 'bulanan'
                    ? "Kas bulanan {$user->name} - " . $this->namaBulan($bulan) . " {$tahun}"
                    : "Iuran {$kasSetting->nama} - {$user->name}",
                'tanggal'    => now(),
                'created_by' => Auth::id(),
            ]);

            // 2. Buat record pembayaran
            $pembayaran = PembayaranKas::create([
                'user_id'       => $user->id,
                'kas_setting_id'=> $kasSetting->id,
                'kas_id'        => $kas->id,
                'bulan'         => $bulan,
                'tahun'         => $tahun,
                'nominal'       => $kasSetting->nominal,
                'status'        => 'lunas',
                'tgl_bayar'     => now(),
                'created_by'    => Auth::id(),
            ]);

            return $pembayaran;
        });
    }

    /**
     * Cek apakah bulan tertentu adalah bulan libur.
     */
    public function isLibur(int $bulan, int $tahun): bool
    {
        return KasLibur::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->exists();
    }

    /**
     * Cek status pembayaran user untuk bulan & setting tertentu.
     * Return: 'lunas' | 'libur' | 'belum'
     */
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

    /**
     * Hitung ringkasan keuangan untuk dashboard.
     */
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

    /**
     * Ambil data monitoring: anggota vs bulan.
     */
    public function getDataMonitoring(KasSetting $kasSetting, int $tahun): array
    {
        $users = User::role(['pengurus', 'bendahara', 'sekretaris', 'ketua'])->get();
        $bulanAktif = $this->getBulanAktif($kasSetting, $tahun);
        $data = [];

        foreach ($users as $user) {
            $row = ['user' => $user, 'bulan' => []];

            foreach ($bulanAktif as $bulan) {
                $row['bulan'][$bulan] = $this->getStatus($user, $kasSetting, $bulan, $tahun);
            }

            $data[] = $row;
        }

        return $data;
    }

    /**
     * Ambil bulan yang aktif berdasarkan KasSetting.
     */
    public function getBulanAktif(KasSetting $kasSetting, int $tahun): array
    {
        if ($kasSetting->tipe === 'temporal') {
            return []; // temporal tidak pakai bulan
        }

        $mulai = $kasSetting->berlaku_mulai
            ? (int) $kasSetting->berlaku_mulai->format('m')
            : 1;

        return range($mulai, 12);
    }

    /**
     * Helper: nama bulan dalam Bahasa Indonesia.
     */
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