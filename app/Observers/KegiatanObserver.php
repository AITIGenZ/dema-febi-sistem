<?php

namespace App\Observers;

use App\Models\Kegiatan;
use App\Models\User;
use App\Services\WhatsAppService;

class KegiatanObserver
{
    /**
     * Saat kegiatan dibuat → kirim ke ADMIN
     */
    public function created(Kegiatan $kegiatan): void
    {
        // Ambil semua admin
        $admins = User::where('role', 'admin')->get();

        foreach ($admins as $admin) {

            // Skip kalau tidak ada nomor
            if (empty($admin->phone)) {
                continue;
            }

            $target = $this->formatPhone($admin->phone);

            $message = "📢 Pengajuan Kegiatan Baru\n\n"
                . "Judul: {$kegiatan->judul}\n"
                . "Tanggal: {$kegiatan->tanggal}\n"
                . "Pengaju: {$kegiatan->user->name}\n\n"
                . "Segera lakukan approval di sistem.";

            WhatsAppService::send($target, $message);
        }
    }

    /**
     * Saat update status → kirim ke pemohon
     */
    public function updated(Kegiatan $kegiatan): void
    {
        if (!$kegiatan->isDirty('status_pengajuan')) {
            return;
        }

        $user = $kegiatan->user;

        if (!$user || empty($user->phone)) {
            return;
        }

        $target = $this->formatPhone($user->phone);

        // APPROVED
        if ($kegiatan->status_pengajuan === 'disetujui') {

            $message = "✅ Kegiatan Disetujui\n\n"
                . "Judul: {$kegiatan->judul}\n"
                . "Tanggal: {$kegiatan->tanggal}\n\n"
                . "Silakan lanjutkan.";

            WhatsAppService::send($target, $message);
        }

        // REJECTED
        if ($kegiatan->status_pengajuan === 'ditolak') {

            $message = "❌ Kegiatan Ditolak\n\n"
                . "Judul: {$kegiatan->judul}\n"
                . "Tanggal: {$kegiatan->tanggal}\n\n"
                . "Silakan perbaiki.";

            WhatsAppService::send($target, $message);
        }
    }

    /**
     * Helper format nomor
     */
    private function formatPhone($phone)
    {
        if (str_starts_with($phone, '08')) {
            return '628' . substr($phone, 2);
        }

        return $phone;
    }
}