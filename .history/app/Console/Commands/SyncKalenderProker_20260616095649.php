<?php

namespace App\Console\Commands;

use App\Models\Kegiatan;
use App\Models\KalenderProker;
use Illuminate\Console\Command;

class SyncKalenderProker extends Command
{
    protected $signature = 'kalender:sync';
    protected $description = 'Sync KalenderProker dari kegiatan yang sudah disetujui';

    public function handle(): void
    {
        $kegiatans = Kegiatan::where('status_pengajuan', 'disetujui')
            ->whereDoesntHave('kalenderProker')
            ->get();

        if ($kegiatans->isEmpty()) {
            $this->info('Semua kegiatan sudah punya KalenderProker.');
            return;
        }

        foreach ($kegiatans as $kegiatan) {
            KalenderProker::create([
                'kegiatan_id' => $kegiatan->id,
                'divisi_id'   => $kegiatan->divisi_id,
                'tgl_mulai'   => $kegiatan->tanggal,
                'tgl_selesai' => $kegiatan->tanggal,
                'is_publik'   => $kegiatan->is_publik,
                'status'      => 'scheduled',
                'warna'       => '#3B82F6',
                'created_by'  => $kegiatan->created_by,
            ]);

            $this->info("✅ Sync: {$kegiatan->nama_kegiatan}");
        }

        $this->info("Selesai. {$kegiatans->count()} kegiatan di-sync.");
    }
}