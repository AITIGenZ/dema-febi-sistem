<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    // Export daftar hadir per kegiatan
    public function absensi($kegiatanId)
    {
        // Ambil data kegiatan beserta relasi divisi
        $kegiatan = Kegiatan::with('dinas')->findOrFail($kegiatanId);

        // Ambil semua absensi kegiatan ini beserta data user dan divisinya
        $absensis = Absensi::with(['user.dinas'])
            ->where('kegiatan_id', $kegiatanId)
            ->get();

        // Load template blade dan kirim data ke dalamnya
        $pdf = Pdf::loadView('pdf.absensi', [
            'kegiatan' => $kegiatan,
            'absensis' => $absensis,
        ]);

        // Set ukuran kertas A4 portrait
        $pdf->setPaper('A4', 'portrait');

        // Download file PDF dengan nama yang deskriptif
        $namaFile = 'Daftar-Hadir-' . str_replace(' ', '-', $kegiatan->nama_kegiatan) . '.pdf';

        return $pdf->download($namaFile);
    }

    // Export laporan keuangan
    public function keuangan()
    {
        $kas = \App\Models\Kas::with('createdBy')
            ->orderBy('tanggal', 'desc')
            ->get();

        $totalMasuk = $kas->where('jenis', 'masuk')->sum('nominal');
        $totalKeluar = $kas->where('jenis', 'keluar')->sum('nominal');
        $saldo = $totalMasuk - $totalKeluar;

        $pdf = Pdf::loadView('pdf.keuangan', [
            'kas' => $kas,
            'totalMasuk' => $totalMasuk,
            'totalKeluar' => $totalKeluar,
            'saldo' => $saldo,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download('Laporan-Keuangan-DEMA-FEBI.pdf');
    }
}