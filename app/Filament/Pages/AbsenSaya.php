<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Absensi;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AbsenSaya extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationLabel = 'Absen Saya';

    protected static ?string $navigationGroup = 'Kehadiran';

    protected static string $view = 'filament.pages.absen-saya';

    public $absensis = [];

    public function mount(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->absensis = Absensi::with(['rapat', 'kegiatan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | HAVERSINE (Hitung Jarak Meter)
    |--------------------------------------------------------------------------
    */
    public function hitungJarak($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meter

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }

    /*
    |--------------------------------------------------------------------------
    | ACTION ABSEN
    |--------------------------------------------------------------------------
    */
    public function absen($absensiId, $lat, $lon)
    {
        $absensi = Absensi::with('rapat')->findOrFail($absensiId);

        // Pastikan ini rapat
        if (!$absensi->rapat) {
            session()->flash('error', 'Data rapat tidak ditemukan.');
            return;
        }

        // Pastikan GPS rapat tersedia
        if (
            is_null($absensi->rapat->latitude) ||
            is_null($absensi->rapat->longitude)
        ) {
            session()->flash('error', 'Lokasi rapat belum diset.');
            return;
        }

        // Hitung jarak
        $jarak = $this->hitungJarak(
            $lat,
            $lon,
            $absensi->rapat->latitude,
            $absensi->rapat->longitude
        );

        // Validasi radius
        if ($jarak > $absensi->rapat->radius) {
            session()->flash('error', 'Anda berada di luar radius lokasi.');
            return;
        }

        // Update absensi
        $absensi->update([
            'status' => 'hadir',
            'checkin_at' => Carbon::now(),
            'checkin_latitude' => $lat,
            'checkin_longitude' => $lon,
        ]);

        session()->flash('success', 'Absensi berhasil.');

        // Reload data
        $this->loadData();
    }
}