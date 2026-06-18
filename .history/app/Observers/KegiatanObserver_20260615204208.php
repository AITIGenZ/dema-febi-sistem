<?php

namespace App\Observers;

use App\Models\Kegiatan;
use App\Models\KalenderProker;
use App\Models\User;
use App\Services\WhatsAppService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class KegiatanObserver
{
    /**
     * Saat kegiatan dibuat → kirim notif ke KETUA / SEKRETARIS / BENDAHARA
     */
    public function created(Kegiatan $kegiatan): void
    {
        // Ambil nama pengaju dengan aman — relasi createdBy() bukan user()
        $pengaju = $kegiatan->createdBy?->name ?? 'Tidak diketahui';

        $admins = User::role(['ketua', 'sekretaris', 'bendahara'])->get();

        foreach ($admins as $admin) {
            if (empty($admin->phone)) {
                continue;
            }

            $message = "📢 *Pengajuan Kegiatan Baru*\n\n"
                . "Nama Kegiatan : {$kegiatan->nama_kegiatan}\n"
                . "Tanggal       : {$kegiatan->tanggal}\n"
                . "Pengaju       : {$pengaju}\n\n"
                . "Segera lakukan approval di sistem.";

            $this->sendWhatsApp($admin->phone, $message);
        }
    }

    /**
     * Saat status_pengajuan berubah → kirim notif ke pemohon + auto-create kalender
     */
    public function updated(Kegiatan $kegiatan): void
    {
        // Hanya proses kalau status_pengajuan yang berubah
        if (! $kegiatan->isDirty('status_pengajuan')) {
            return;
        }

        $status = $kegiatan->status_pengajuan;

        // Auto-create KalenderProker saat disetujui
        if ($status === 'disetujui') {
            $this->createKalenderProker($kegiatan);
        }

        // Kirim notif ke pengaju
        $pengaju = $kegiatan->createdBy;

        if (! $pengaju || empty($pengaju->phone)) {
            return;
        }

        $message = match ($status) {
            'disetujui' => "✅ *Kegiatan Disetujui*\n\n"
                . "Nama Kegiatan : {$kegiatan->nama_kegiatan}\n"
                . "Tanggal       : {$kegiatan->tanggal}\n\n"
                . "Kegiatan kamu telah disetujui. Silakan lanjutkan persiapan.",

            'ditolak'   => "❌ *Kegiatan Ditolak*\n\n"
                . "Nama Kegiatan : {$kegiatan->nama_kegiatan}\n"
                . "Tanggal       : {$kegiatan->tanggal}\n\n"
                . "Kegiatan kamu ditolak. Silakan perbaiki dan ajukan kembali.",

            default     => null,
        };

        if ($message) {
            $this->sendWhatsApp($pengaju->phone, $message);
        }
    }

    // =========================================================================
    // PRIVATE HELPERS
    // =========================================================================

    /**
     * Auto-create KalenderProker saat kegiatan disetujui.
     * Idempotent — skip kalau sudah ada.
     */
    private function createKalenderProker(Kegiatan $kegiatan): void
    {
        $exists = KalenderProker::where('kegiatan_id', $kegiatan->id)->exists();

        if ($exists) {
            return;
        }

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

    /**
     * Kirim WhatsApp dengan error handling.
     * Observer tidak boleh crash hanya karena WA gagal kirim.
     */
    private function sendWhatsApp(string $phone, string $message): void
    {
        try {
            $target = $this->formatPhone($phone);
            WhatsAppService::send($target, $message);
        } catch (\Throwable $e) {
            // Log error tapi jangan propagate — kegiatan tetap tersimpan
            Log::error('KegiatanObserver: Gagal kirim WhatsApp', [
                'phone'   => $phone,
                'error'   => $e->getMessage(),
            ]);
        }
    }

    private function formatPhone(string $phone): string
    {
        // Hapus semua karakter non-digit
        $phone = preg_replace('/\D/', '', $phone);

        if (str_starts_with($phone, '628')) {
            return $phone;
        }

        if (str_starts_with($phone, '08')) {
            return '62' . substr($phone, 1);
        }

        if (str_starts_with($phone, '8')) {
            return '62' . $phone;
        }

        return $phone;
    }
}