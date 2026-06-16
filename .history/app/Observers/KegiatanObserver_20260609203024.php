<?php

namespace App\Observers;

use App\Models\Kegiatan;
use App\Services\WhatsAppService;

class KegiatanObserver
{
    public function updated(Kegiatan $kegiatan): void
    {
        // Cek apakah status berubah
        if ($kegiatan->isDirty('status_pengajuan')) {

            // Ambil user (pemohon)
            $user = $kegiatan->user; // pastikan relasi ada

            if (!$user || !$user->phone) {
                return; // skip kalau tidak ada nomor
            }

            // Format nomor
            $target = $user->phone;

            // APPROVED
            if ($kegiatan->status_pengajuan === 'disetujui') {

                $message = "✅ *Kegiatan Disetujui*\n\n"
                    . "Judul: {$kegiatan->judul}\n"
                    . "Tanggal: {$kegiatan->tanggal}\n\n"
                    . "Silakan lanjutkan pelaksanaan.";

                WhatsAppService::send($target, $message);
            }

            // REJECTED
            if ($kegiatan->status_pengajuan === 'ditolak') {

                $message = "❌ *Kegiatan Ditolak*\n\n"
                    . "Judul: {$kegiatan->judul}\n"
                    . "Tanggal: {$kegiatan->tanggal}\n\n"
                    . "Silakan perbaiki dan ajukan kembali.";

                WhatsAppService::send($target, $message);
            }
        }
    }
}