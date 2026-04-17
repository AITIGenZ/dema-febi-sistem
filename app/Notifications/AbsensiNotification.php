<?php

namespace App\Notifications;

use App\Models\Absensi;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AbsensiNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $absensi;
    protected $action;

    /**
     * Create a new notification instance.
     */
    public function __construct(Absensi $absensi, $action = 'recorded')
    {
        $this->absensi = $absensi;
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
            ->subject('📊 Absensi ' . $actionText . ': ' . $this->absensi->event->title)
            ->greeting('Halo ' . $userName . '!')
            ->line('Absensi Anda telah **' . $actionText . '**.')
            ->line('📌 **Detail Absensi:**')
            ->line('• Event: **' . $this->absensi->event->title . '**')
            ->line('• Tanggal Event: ' . $this->absensi->event->start->format('d M Y, H:i'))
            ->line('• Peserta: ' . $this->absensi->user->name)
            ->line('• Status Kehadiran: ' . $this->getAttendanceBadge())
            ->line('• Waktu Absensi: ' . $this->absensi->created_at->format('d M Y, H:i'));

        if ($this->absensi->catatan) {
            $mailMessage->line('• Catatan: ' . $this->absensi->catatan);
        }

        $mailMessage->action('📋 Lihat Detail Absensi', route('absensi.show', $this->absensi->id));

        return $mailMessage->line('Terima kasih telah menghadiri acara kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'absensi_id' => $this->absensi->id,
            'event' => $this->absensi->event->title,
            'user' => $this->absensi->user->name,
            'action' => $this->action,
            'message' => 'Absensi Anda untuk event "' . $this->absensi->event->title . '" telah ' . $this->getActionText(),
            'icon' => $this->getIcon(),
            'url' => route('absensi.show', $this->absensi->id),
            'status' => $this->absensi->status,
            'time' => now()->toDateTimeString(),
        ];
    }

    /**
     * Get attendance badge
     */
    protected function getAttendanceBadge(): string
    {
        $statuses = [
            'present' => '✅ Hadir',
            'absent' => '❌ Tidak Hadir',
            'late' => '🟡 Terlambat',
            'excuse' => '📋 Izin',
            'pending' => '⏳ Menunggu Verifikasi',
        ];

        return $statuses[$this->absensi->status] ?? '⚪ ' . $this->absensi->status;
    }

    /**
     * Get action text
     */
    protected function getActionText(): string
    {
        $actions = [
            'recorded' => 'Tercatat',
            'verified' => 'Diverifikasi',
            'updated' => 'Diperbarui',
            'completed' => 'Selesai',
        ];

        return $actions[$this->action] ?? ucfirst($this->action);
    }

    /**
     * Get icon untuk notifikasi
     */
    protected function getIcon(): string
    {
        $icons = [
            'recorded' => '📊',
            'verified' => '✅',
            'updated' => '✏️',
            'completed' => '🏆',
        ];

        return $icons[$this->action] ?? '📌';
    }
}
