<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PasswordUpdatedNotification extends Notification
{
    use Queueable;

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Kata sandi berhasil diperbarui',
            'message' => 'Kata sandi akun Anda telah berhasil diubah. Jika ini bukan Anda, segera hubungi administrator.',
            'type' => 'success',
            'icon' => '✅',
            'action_url' => url('/'),
            'time' => now()->toDateTimeString(),
        ];
    }
}
