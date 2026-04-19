<?php

namespace App\Notifications;

use App\Models\KalenderProker;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProkerNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $proker;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(KalenderProker $proker, $action = 'created')
    {
        $this->proker = $proker;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $actionText = $this->action === 'created' ? 'dibuat' : 'diperbarui';
        $userName = $notifiable->name ?? 'Pengguna';

        $mailMessage = (new MailMessage)
            ->subject('📋 Program Kerja ' . ucfirst($actionText) . ': ' . $this->proker->kegiatan->nama_kegiatan)
            ->greeting('Halo ' . $userName . '!')
            ->line('Sebuah program kerja telah **' . $actionText . '** dalam sistem.')
            ->line('📌 **Detail Program Kerja:**')
            ->line('• Kegiatan: **' . $this->proker->kegiatan->nama_kegiatan . '**')
            ->line('• Divisi: ' . ($this->proker->divisi->nama_divisi ?? 'N/A'))
            ->line('• Tanggal Mulai: ' . $this->proker->tgl_mulai->format('d M Y'))
            ->line('• Tanggal Selesai: ' . $this->proker->tgl_selesai->format('d M Y'))
            ->line('• Status: ' . $this->getStatusBadge())
            ->action('📋 Lihat Detail Program Kerja', route('kalender.show', $this->proker->id));

        if ($this->proker->deskripsi) {
            $mailMessage->line('• Deskripsi: ' . substr($this->proker->deskripsi, 0, 100) . '...');
        }

        return $mailMessage->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $actionText = $this->action === 'created' ? 'membuat' : 'memperbarui';

        return [
            'proker_id' => $this->proker->id,
            'kegiatan' => $this->proker->kegiatan->nama_kegiatan,
            'divisi' => $this->proker->divisi->nama_divisi ?? 'N/A',
            'action' => $this->action,
            'message' => 'Program kerja "' . $this->proker->kegiatan->nama_kegiatan . '" telah ' . $actionText,
            'icon' => $this->getIcon(),
            'url' => route('kalender.show', $this->proker->id),
            'time' => now()->toDateTimeString(),
            'tgl_mulai' => $this->proker->tgl_mulai->format('Y-m-d'),
            'tgl_selesai' => $this->proker->tgl_selesai->format('Y-m-d'),
        ];
    }

    /**
     * Get status badge untuk email
     */
    protected function getStatusBadge(): string
    {
        $statuses = [
            'planning' => '🔵 Perencanaan',
            'ongoing' => '🟡 Sedang Berlangsung',
            'completed' => '🟢 Selesai',
            'cancelled' => '🔴 Dibatalkan',
        ];

        return $statuses[$this->proker->status] ?? '⚪ ' . $this->proker->status;
    }

    /**
     * Get icon untuk notifikasi
     */
    protected function getIcon(): string
    {
        $icons = [
            'created' => '📋',
            'updated' => '✏️',
            'deleted' => '🗑️',
            'reminder' => '⏰',
        ];

        return $icons[$this->action] ?? '📌';
    }
}
