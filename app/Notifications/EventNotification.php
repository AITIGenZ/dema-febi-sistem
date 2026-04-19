<?php

namespace App\Notifications;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventNotification extends Notification implements ShouldQueue // SUDAH ADA ShouldQueue
{
    use Queueable;

    protected $event;
    protected $action;
    protected $recipientType;

    /**
     * Create a new notification instance.
     */
    public function __construct(Event $event, $action = 'created', $recipientType = 'creator')
    {
        $this->event = $event;
        $this->action = $action;
        $this->recipientType = $recipientType;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        // KIRIM KE EMAIL DAN SIMPAN DI DATABASE
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
            ->subject('📅 Event ' . ucfirst($actionText) . ': ' . $this->event->title)
            ->greeting('Halo ' . $userName . '!')
            ->line('Sebuah event telah **' . $actionText . '** dalam sistem.')
            ->line('📌 **Detail Event:**')
            ->line('• Judul: **' . $this->event->title . '**')
            ->line('• Waktu: ' . $this->event->start->format('d M Y, H:i') . ' WIB')
            ->line('• Lokasi: ' . ($this->event->location ?? 'Online/Virtual'))
            ->line('• Status: ' . $this->getStatusBadge());

        if ($this->event->description) {
            $mailMessage->line('• Deskripsi: ' . substr($this->event->description, 0, 100) . '...');
        }

        // Action button berbeda berdasarkan tipe penerima
        if ($this->recipientType === 'attendee') {
            $mailMessage->action('✅ Konfirmasi Kehadiran', route('events.confirm', $this->event->id));
            $mailMessage->line('Silakan konfirmasi kehadiran Anda sebelum ' . $this->event->start->subDay()->format('d M Y'));
        } else {
            $mailMessage->action('📋 Lihat & Kelola Event', route('events.show', $this->event->id));
        }

        // Validasi sebelum attach iCalendar
        if ($this->event && $this->event->start) {
            $mailMessage->attachData(
                $this->generateICalendar(),
                'event-' . $this->event->id . '.ics',
                ['mime' => 'text/calendar']
            );
        }

        return $mailMessage->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification (untuk database).
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $actionText = $this->action === 'created' ? 'membuat' : 'memperbarui';
        
        return [
            'event_id' => $this->event->id,
            'event_title' => $this->event->title,
            'action' => $this->action,
            'recipient_type' => $this->recipientType,
            'message' => 'Anda ' . $actionText . ' event "' . $this->event->title . '"',
            'icon' => $this->getIcon(),
            'url' => route('events.show', $this->event->id),
            'time' => now()->toDateTimeString(),
        ];
    }
    
    /**
     * Generate iCalendar file untuk attachment email
     */
    protected function generateICalendar(): string
    {
        $start = $this->event->start->format('Ymd\THis\Z');
        $end = $this->event->end 
            ? $this->event->end->format('Ymd\THis\Z')
            : $this->event->start->addHour()->format('Ymd\THis\Z');
        
        $ics = "BEGIN:VCALENDAR\r\n";
        $ics .= "VERSION:2.0\r\n";
        $ics .= "PRODID:-//YourApp//Event Management//ID\r\n";
        $ics .= "CALSCALE:GREGORIAN\r\n";
        $ics .= "METHOD:REQUEST\r\n";
        $ics .= "BEGIN:VEVENT\r\n";
        $ics .= "UID:" . md5($this->event->id . $this->event->title) . "@yourapp.com\r\n";
        $ics .= "DTSTART:" . $start . "\r\n";
        $ics .= "DTEND:" . $end . "\r\n";
        $ics .= "DTSTAMP:" . now()->format('Ymd\THis\Z') . "\r\n";
        $ics .= "SUMMARY:" . $this->escapeString($this->event->title) . "\r\n";
        
        if ($this->event->description) {
            $ics .= "DESCRIPTION:" . $this->escapeString($this->event->description) . "\r\n";
        }
        
        if ($this->event->location) {
            $ics .= "LOCATION:" . $this->escapeString($this->event->location) . "\r\n";
        }
        
        $ics .= "STATUS:CONFIRMED\r\n";
        $ics .= "SEQUENCE:0\r\n";
        $ics .= "END:VEVENT\r\n";
        $ics .= "END:VCALENDAR\r\n";
        
        return $ics;
    }
    
    /**
     * Escape string untuk iCalendar format
     */
    protected function escapeString(string $string): string
    {
        return str_replace(
            ['\\', "\r\n", "\n", ',', ';'],
            ['\\\\', '\n', '\n', '\,', '\;'],
            $string
        );
    }
    
    /**
     * Get status badge untuk email
     */
    protected function getStatusBadge(): string
    {
        $badges = [
            'scheduled' => '🔵 Terjadwal',
            'in_progress' => '🟡 Sedang Berlangsung',
            'completed' => '🟢 Selesai',
            'cancelled' => '🔴 Dibatalkan',
        ];
        
        return $badges[$this->event->status] ?? '⚪ ' . $this->event->status;
    }
    
    /**
     * Get icon untuk notifikasi database
     */
    protected function getIcon(): string
    {
        $icons = [
            'created' => '📅',
            'updated' => '✏️',
            'deleted' => '🗑️',
            'reminder' => '⏰',
        ];
        
        return $icons[$this->action] ?? '📌';
    }
}