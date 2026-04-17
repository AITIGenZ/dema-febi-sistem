# Dokumentasi Sistem Notifikasi

## Ikhtisar

Sistem notifikasi telah diintegrasikan penuh ke dalam aplikasi Laravel Dema Febi Sistem. Notifikasi dapat dikirim melalui berbagai channel: email, database, dan broadcast.

## Fitur Notifikasi

### 1. **Notifikasi Password Update** (`PasswordUpdatedNotification`)
- **Channel**: Database
- **Trigger**: Ketika user mengubah password
- **Data Tersimpan**:
  - `title`: "Kata sandi berhasil diperbarui"
  - `message`: Pesan verifikasi keamanan
  - `type`: "success"
  - `icon`: "✅"

### 2. **Notifikasi Event** (`EventNotification`)
- **Channel**: Email, Database
- **Trigger**: Event dibuat atau diupdate
- **Data Tersimpan**:
  - Event ID, title, status
  - Waktu event
  - Lokasi event
  - Action URL untuk tindakan lanjutan
- **Attachment**: File iCalendar (.ics)

### 3. **Notifikasi Program Kerja** (`ProkerNotification`)
- **Channel**: Email, Database
- **Trigger**: Proker dibuat atau diupdate
- **Data Tersimpan**:
  - Proker ID, kegiatan, divisi
  - Tanggal mulai dan selesai
  - Status proker
  - Action URL untuk melihat detail

### 4. **Notifikasi Pendaftaran** (`PendaftaranNotification`)
- **Channel**: Email, Database
- **Trigger**: Pendaftaran dikirim, diterima, atau ditolak
- **Data Tersimpan**:
  - Pendaftaran ID, kegiatan, user
  - Status pendaftaran
  - Catatan pendaftaran (jika ada)
  - Action URL untuk melihat detail

### 5. **Notifikasi Absensi** (`AbsensiNotification`)
- **Channel**: Email, Database
- **Trigger**: Absensi dicatat atau diverifikasi
- **Data Tersimpan**:
  - Absensi ID, event, user
  - Status kehadiran
  - Catatan absensi (jika ada)
  - Action URL untuk melihat detail

## API Endpoints

### Notifikasi List
```http
GET /api/notifications
```
**Response:**
```json
{
  "data": [
    {
      "id": "uuid",
      "type": "PasswordUpdatedNotification",
      "data": {...},
      "read": false,
      "created_at": "2024-04-13T10:30:00",
      "time_ago": "5 minutes ago"
    }
  ],
  "pagination": {
    "total": 50,
    "per_page": 15,
    "current_page": 1,
    "last_page": 4
  }
}
```

### Unread Notifications
```http
GET /api/notifications/unread
```

### Unread Count
```http
GET /api/notifications/unread-count
```
**Response:**
```json
{
  "unread_count": 5
}
```

### Mark as Read
```http
POST /api/notifications/{id}/read
```

### Mark All as Read
```http
POST /api/notifications/mark-all-as-read
```

### Delete Notification
```http
DELETE /api/notifications/{id}
```

### Delete All Notifications
```http
DELETE /api/notifications
```

## Model dan Database

### Tabel `notifications` (Laravel Default)
```sql
CREATE TABLE notifications (
  id UUID PRIMARY KEY,
  type VARCHAR(255) NOT NULL,
  notifiable_id BIGINT NOT NULL,
  notifiable_type VARCHAR(255) NOT NULL,
  data TEXT NOT NULL,
  read_at TIMESTAMP NULL,
  created_at TIMESTAMP,
  updated_at TIMESTAMP
);
```

## Penggunaan

### Mengirim Notifikasi ke User
```php
use App\Notifications\PasswordUpdatedNotification;

// Single user
$user->notify(new PasswordUpdatedNotification());

// Multiple users
use Illuminate\Support\Facades\Notification;

$users = User::where('role', 'admin')->get();
Notification::send($users, new EventNotification($event, 'created'));
```

### Mengambil Notifikasi di Controller
```php
// Get all notifications
$notifications = auth()->user()->notifications()->latest()->paginate(15);

// Get unread notifications
$unread = auth()->user()->unreadNotifications()->get();

// Get count
$unreadCount = auth()->user()->unreadNotifications()->count();
```

### Di Blade View
```blade
<!-- Display unread count -->
<span class="badge">{{ auth()->user()->unreadNotifications()->count() }}</span>

<!-- List notifications -->
@forelse(auth()->user()->notifications()->latest()->take(5)->get() as $notification)
  <div class="notification {{ $notification->read_at ? 'read' : 'unread' }}">
    <p>{{ $notification->data['message'] ?? 'New Notification' }}</p>
    <small>{{ $notification->created_at->diffForHumans() }}</small>
  </div>
@empty
  <p>No notifications</p>
@endforelse
```

## Job Queue

Semua notifikasi mengimplementasikan `ShouldQueue` untuk mengirim melalui queue. Pastikan queue worker berjalan:

```bash
php artisan queue:work
```

## Testing

Jalankan test notifikasi:
```bash
php artisan test tests/Feature/Auth/PasswordUpdateNotificationTest.php
php artisan test tests/Feature/NotificationApiTest.php
```

## Model Relations

### User Model
```php
// Get all user's notifications
public function notifications()
{
    return $this->hasMany(DatabaseNotification::class, 'notifiable_id')
        ->where('notifiable_type', self::class)
        ->orderBy('created_at', 'desc');
}

// Get unread notifications only
public function unreadNotifications()
{
    return $this->notifications()
        ->whereNull('read_at')
        ->orderBy('created_at', 'desc');
}
```

## Troubleshooting

### Notifikasi gagal terkirim
1. Pastikan queue worker berjalan: `php artisan queue:work`
2. Cek file `.env` untuk konfigurasi mail
3. Follow logs di `storage/logs/laravel.log`

### Notifikasi tidak tersimpan ke database
1. Pastikan migration notifications sudah berjalan
2. Cek channel notification sudah include 'database'
3. Verify `notifiable_type` harus match full class name

### Email tidak terkirim
1. Configure `.env`:
   ```
   MAIL_DRIVER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=tls
   ```

## Best Practices

1. **Always use queue jobs** - Kirim notifikasi melalui queue untuk performa
2. **Handle nullable data** - Selalu cek data sebelum mengakses
3. **Validate routes** - Pastikan action URL dalam notifikasi valid
4. **Log notifications** - Monitor pengiriman notifikasi di logs
5. **Clean old notifications** - Hapus notifikasi lama secara berkala

## Future Enhancements

- [ ] SMS Notifications via Twilio
- [ ] Slack Notifications
- [ ] Push Notifications (Web & Mobile)
- [ ] Notification Preferences per User
- [ ] Advanced Filtering & Search
- [ ] Real-time Broadcasting
