<?php

namespace App\Http\Controllers;

use App\Models\Kegiatan;
use App\Models\KalenderProker;
use App\Models\User;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    // Halaman utama landing page
    public function index()
    {
        // Ambil 6 kegiatan publik terbaru
        $kegiatan = Kegiatan::with('divisi')
            ->where('is_publik', true)
            ->orderBy('tanggal', 'desc')
            ->take(6)
            ->get();

        // Hitung statistik untuk ditampilkan
        $totalAnggota = User::where('status', 'aktif')->count();
        // Hitung semua kegiatan yang disetujui
        $totalKegiatan = Kegiatan::where('status_pengajuan', 'disetujui')->count();

        return view('landing.index', compact(
            'kegiatan',
            'totalAnggota',
            'totalKegiatan'
        ));
    }

    // Ambil data kalender dalam format JSON untuk FullCalendar
    public function kalender()
    {
        $events = KalenderProker::with(['kegiatan', 'divisi'])
            ->where('is_publik', true)
            ->get()
            ->map(function ($item) {
                return [
                    'title' => $item->kegiatan->nama_kegiatan,
                    'start' => $item->tgl_mulai->format('Y-m-d'),
                    'end' => $item->tgl_selesai
                        ? $item->tgl_selesai->format('Y-m-d')
                        : null,
                    'color' => $item->warna,
                    'description' => $item->divisi->nama_divisi ?? 'DEMA FEBI',
                ];
            });

        return response()->json($events);
    }

    // Halaman detail kegiatan
    public function detailKegiatan($id)
    {
        $kegiatan = Kegiatan::with('divisi')
            ->where('is_publik', true)
            ->findOrFail($id);

        return view('landing.detail-kegiatan', compact('kegiatan'));
    }
}