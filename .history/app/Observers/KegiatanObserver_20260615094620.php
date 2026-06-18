<?php

namespace App\Observers;

use App\Models\Kegiatan;
use App\Models\KalenderProker;
use App\Models\User;
use App\Services\WhatsAppService;
use Carbon\Carbon;

class KegiatanObserver
{
    /**
     * Saat kegiatan dibuat → kirim ke KETUA/SEKRETARIS/BENDAHARA
     */
    public function created(Kegiatan $kegiatan): void
    {
        $admins = User::role(['ketua', 'sekretaris', 'bendahara'])->get();

        foreach ($admins as $admin) {

            if (empty($admin->phone)) {
                continue;
            }

            $target = $this->formatPhone($admin->phone);

            $message = "📢 Pengajuan Kegiatan Baru\n\n"
                . "Nama Kegiatan: {$kegiatan->nama_kegiatan}\n"
                . "Tanggal: {$kegiatan->tanggal}\n"
                . "Pengaju: {$kegiatan->createdBy?->name ?? 'N/A'}\n\n"
                . "Segera lakukan approval di sistem.";

            WhatsAppService::send($target, $message);
        }
    }

    /**
     * Saat update status → kirim ke pemohon + auto-create kalender
     */
    public function updated(Kegiatan $kegiatan): void
    {
        if (!$kegiatan->isDirty('status_pengajuan')) {
            return;
        }

        // Auto-create KalenderProker saat disetujui
        if ($kegiatan->status_pengajuan === 'disetujui') {
            $exists = KalenderProker::where('kegiatan_id', $kegiatan->id)->exists();

            if (!$exists) {
                $tglMulai = Carbon::parse($kegiatan->tanggal);

                KalenderProker::create([
                    'kegiatan_id' => $kegiatan->id,
                    'divisi_id'   => $kegiatan->divisi_id,
                    'tgl_mulai'   => $tglMulai->toDateString(),
                    'tgl_selesai' => $tglMulai->toDateString(),
                    'status'      => 'scheduled',
                    'is_publik'   => $kegiatan->is_publik ?? true,
                ]);
            }
        }

        $user = $kegiatan->user;

        if (!$user || empty($user->phone)) {
            return;
        }

        $target = $this->formatPhone($user->phone);

        // APPROVED
        if ($kegiatan->status_pengajuan === 'disetujui') {

            $message = "✅ Kegiatan Disetujui\n\n"
                . "Nama Kegiatan: {$kegiatan->nama_kegiatan}\n"
                . "Tanggal: {$kegiatan->tanggal}\n\n"
                . "Silakan lanjutkan.";

            WhatsAppService::send($target, $message);
        }

        // REJECTED
        if ($kegiatan->status_pengajuan === 'ditolak') {

            $message = "❌ Kegiatan Ditolak\n\n"
                . "Nama Kegiatan: {$kegiatan->nama_kegiatan}\n"
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