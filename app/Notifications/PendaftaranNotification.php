<?php

namespace App\Notifications;

use App\Models\Pendaftaran;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendaftaranNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pendaftaran;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(Pendaftaran $pendaftaran, $action = 'submitted')
    {
        $this->pendaftaran = $pendaftaran;
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
        $actionText = $this->getActionText();
        $userName = $notifiable->name ?? 'Pengguna';

        $mailMessage = (new MailMessage)
            ->subject('📝 Pendaftaran ' . $actionText . ': ' . $this->pendaftaran->kegiatan->nama_kegiatan)
            ->greeting('Halo ' . $userName . '!')
            ->line('Pendaftaran Anda telah **' . $actionText . '**.')
            ->line('📌 **Detail Pendaftaran:**')
            ->line('• Kegiatan: **' . $this->pendaftaran->kegiatan->nama_kegiatan . '**')
            ->line('• Peserta: ' . $this->pendaftaran->user->name)
            ->line('• Tanggal Daftar: ' . $this->pendaftaran->created_at->format('d M Y, H:i'))
            ->line('• Status: ' . $this->getStatusBadge());

        if ($this->pendaftaran->catatan) {
            $mailMessage->line('• Catatan: ' . $this->pendaftaran->catatan);
        }

        $mailMessage->action('📋 Lihat Detail', route('pendaftaran.show', $this->pendaftaran->id));

        return $mailMessage->line('Terima kasih telah berpartisipasi!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'pendaftaran_id' => $this->pendaftaran->id,
            'kegiatan' => $this->pendaftaran->kegiatan->nama_kegiatan,
            'user' => $this->pendaftaran->user->name,
            'action' => $this->action,
            'message' => 'Pendaftaran Anda untuk "' . $this->pendaftaran->kegiatan->nama_kegiatan . '" telah ' . $this->getActionText(),
            'icon' => $this->getIcon(),
            'url' => route('pendaftaran.show', $this->pendaftaran->id),
            'status' => $this->pendaftaran->status,
            'time' => now()->toDateTimeString(),
        ];
    }

    /**
     * Get status badge untuk email
     */
    protected function getStatusBadge(): string
    {
        $statuses = [
            'pending' => '🟡 Menunggu Verifikasi',
            'approved' => '🟢 Diterima',
            'rejected' => '🔴 Ditolak',
            'completed' => '✅ Selesai',
        ];

        return $statuses[$this->pendaftaran->status] ?? '⚪ ' . $this->pendaftaran->status;
    }

    /**
     * Get action text
     */
    protected function getActionText(): string
    {
        $actions = [
            'submitted' => 'Dikirim',
            'approved' => 'Diterima',
            'rejected' => 'Ditolak',
            'completed' => 'Diselesaikan',
            'updated' => 'Diperbarui',
        ];

        return $actions[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get icon untuk notifikasi
     */
    protected function getIcon(): string
    {
        $icons = [
            'submitted' => '📝',
            'approved' => '✅',
            'rejected' => '❌',
            'completed' => '🏆',
            'updated' => '✏️',
        ];

        return $icons[$this->action] ?? '📌';
    }
}
