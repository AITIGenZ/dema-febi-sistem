# 📅 Sistem Kalender Proker & Notifikasi Email

## 📋 Daftar Isi
1. [Overview](#overview)
2. [Instalasi & Setup](#instalasi--setup)
3. [API Documentation](#api-documentation)
4. [Database Schema](#database-schema)
5. [Notifikasi System](#notifikasi-system)
6. [Integration Guide](#integration-guide)
7. [Troubleshooting](#troubleshooting)

---

## Overview

Sistem ini memungkinkan:
- ✅ Membuat & manage program kerja di kalender
- ✅ Mengirim email notifikasi otomatis saat event dibuat/diupdate
- ✅ Tracking event status (scheduled, ongoing, completed, cancelled)
- ✅ Melihat notifikasi di database dan melalui API
- ✅ Filter events by divisi, tanggal, status
- ✅ FullCalendar integration
- ✅ User audit trail (siapa yang membuat/edit)

---

## Instalasi & Setup

### 1. Run Migration
```bash
php artisan migrate
```

Migration baru akan menambahkan fields:
- `status` - Event status
- `reminder_at` - Pengingat event
- `created_by` - User ID yang membuat
- `updated_by` - User ID yang mengubah

### 2. Configure Email (di `.env`)
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="Dema Febi"
```

### 3. Queue Setup (untuk pengiriman email)
```bash
# Set queue driver
# Di .env: QUEUE_CONNECTION=database

php artisan queue:table
php artisan migrate

# Jalankan queue worker
php artisan queue:work
```

---

## API Documentation

### Public Endpoints (tanpa login)

#### Get Calendar Events (FullCalendar format)
```
GET /api/kalender/events
```

**Params:**
- `divisi_id` (optional) - Filter by divisi
- `start_date` (optional) - Filter start date (YYYY-MM-DD)
- `end_date` (optional) - Filter end date (YYYY-MM-DD)

**Response:**
```json
{
  "success": true,
  "message": "Event kalender berhasil diambil",
  "data": [
    {
      "id": 1,
      "title": "Rapat Koordinasi",
      "start": "2026-04-20",
      "end": "2026-04-21",
      "allDay": false,
      "color": "#3B82F6",
      "textColor": "#ffffff",
      "extendedProps": {
        "kegiatan_id": 1,
        "divisi": "Divisi Internal",
        "status": "scheduled"
      }
    }
  ]
}
```

#### Get Event Detail
```
GET /api/kalender/{id}
```

---

### Protected Endpoints (hanya login)

#### List All Calendar Events
```
GET /api/kalender?page=1&per_page=15&divisi_id=1&status=scheduled
```

**Filter Params:**
- `page` - Halaman (default: 1)
- `per_page` - Per halaman (default: 15)
- `divisi_id` - Filter by divisi
- `start_date` - Filter start date
- `end_date` - Filter end date
- `status` - Filter by status (scheduled, ongoing, completed, cancelled)
- `publik_only` - Hanya publik (true/false)

**Response:**
```json
{
  "success": true,
  "message": "Data kalender proker berhasil diambil",
  "data": [
    {
      "id": 1,
      "kegiatan": {
        "id": 1,
        "nama": "Rapat Koordinasi",
        "deskripsi": "..."
      },
      "divisi": {
        "id": 1,
        "nama": "Divisi Internal"
      },
      "tgl_mulai": "2026-04-20",
      "tgl_mulai_formatted": "20 Apr 2026",
      "tgl_selesai": "2026-04-21",
      "tgl_selesai_formatted": "21 Apr 2026",
      "warna": "#3B82F6",
      "is_publik": true,
      "status": "scheduled",
      "status_label": "Akan Datang",
      "duration_days": 2,
      "is_ongoing": false,
      "is_finished": false,
      "is_upcoming": true,
      "created_by": {
        "id": 1,
        "name": "Admin"
      },
      "updated_by": {
        "id": 1,
        "name": "Admin"
      },
      "created_at": "2026-04-17 10:00:00",
      "updated_at": "2026-04-17 10:00:00"
    }
  ],
  "pagination": {
    "current_page": 1,
    "per_page": 15,
    "total": 50,
    "last_page": 4
  }
}
```

#### Create New Calendar Event
```
POST /api/kalender
Content-Type: application/json

{
  "kegiatan_id": 1,
  "divisi_id": 1,
  "tgl_mulai": "2026-04-20",
  "tgl_selesai": "2026-04-21",
  "warna": "#3B82F6",
  "is_publik": true,
  "status": "scheduled",
  "reminder_at": "2026-04-19 09:00:00"
}
```

**Validation Rules:**
- `kegiatan_id` - Required, must exist in kegiatans table
- `divisi_id` - Optional
- `tgl_mulai` - Required, date format YYYY-MM-DD
- `tgl_selesai` - Optional, must be after tgl_mulai
- `warna` - Optional, hex color format (#RRGGBB)
- `is_publik` - Boolean
- `status` - One of: scheduled, ongoing, completed, cancelled
- `reminder_at` - Optional, datetime format Y-m-d H:i:s

**Notification Trigger:** 
🔔 Email akan dikirim otomatis ke semua user dalam divisi yang sama

---

#### Update Calendar Event
```
PUT /api/kalender/{id}
Content-Type: application/json

{
  "kegiatan_id": 1,
  "tgl_mulai": "2026-04-22",
  "status": "ongoing"
}
```

**Notification Trigger:** 
🔔 Email akan dikirim otomatis tentang update event

---

#### Change Event Status

**Mark as Ongoing:**
```
POST /api/kalender/{id}/mark-ongoing
```

**Mark as Completed:**
```
POST /api/kalender/{id}/mark-completed
```

**Mark as Cancelled:**
```
POST /api/kalender/{id}/mark-cancelled
```

**Bulk Update Status:**
```
POST /api/kalender/bulk-update-status
Content-Type: application/json

{
  "ids": [1, 2, 3],
  "status": "completed"
}
```

---

#### Delete Calendar Event
```
DELETE /api/kalender/{id}
```

---

### Notification Endpoints
Lihat dokumentasi di [NOTIFIKASI.md](NOTIFIKASI.md)

---

## Database Schema

### Table: kalender_prokers

| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| kegiatan_id | bigint | FK to kegiatans |
| divisi_id | bigint | FK to divisis (nullable) |
| tgl_mulai | date | Start date |
| tgl_selesai | date | End date (nullable) |
| warna | string | Hex color code |
| is_publik | boolean | Public visibility |
| status | string | scheduled/ongoing/completed/cancelled |
| reminder_at | datetime | Reminder time (nullable) |
| created_by | bigint | FK to users (who created) |
| updated_by | bigint | FK to users (who updated) |
| created_at | timestamp | |
| updated_at | timestamp | |

### Relationships

**KalenderProker Model:**
```php
// Belongs to
$kalender->kegiatan()  // Kegiatan model
$kalender->divisi()    // Divisi model
$kalender->creator()   // User model (created_by)
$kalender->updater()   // User model (updated_by)
```

---

## Notifikasi System

### Auto Trigger Notifikasi

**Saat Event Dibuat:**
✅ Kirim email ke semua user di divisi yang sama
✅ Simpan ke database notifications

**Saat Event Diupdate:**
✅ Kirim email ke semua user di divisi yang sama
✅ Simpan ke database notifications

### Email Template

Subject: 📋 Program Kerja `{action}`: `{nama_kegiatan}`

Content:
```
Halo {user_name}!

Sebuah program kerja telah {dibuat/diperbarui} dalam sistem.

📌 Detail Program Kerja:
• Kegiatan: {nama_kegiatan}
• Divisi: {nama_divisi}
• Tanggal Mulai: {tanggal_mulai}
• Tanggal Selesai: {tanggal_selesai}
• Status: {status_badge}
• Deskripsi: {deskripsi}

[Tombol Lihat Detail Program Kerja]

Terima kasih telah menggunakan aplikasi kami!
```

### Database Notifications

Users dapat melihat notifikasi mereka via API:

```
GET /api/notifications
GET /api/notifications/unread
GET /api/notifications/unread-count
POST /api/notifications/{id}/read
POST /api/notifications/mark-all-as-read
DELETE /api/notifications/{id}
DELETE /api/notifications
```

---

## Integration Guide

### Frontend FullCalendar Integration

```javascript
// Initialize FullCalendar
const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
  initialView: 'dayGridMonth',
  headerToolbar: {
    left: 'prev,next today',
    center: 'title',
    right: 'dayGridMonth,timeGridWeek,timeGridDay'
  },
  events: '/api/kalender/events',
  eventClick: function(info) {
    // Show event detail
    fetch(`/api/kalender/${info.event.id}`)
      .then(r => r.json())
      .then(data => showEventDetail(data.data));
  }
});
```

### Laravel Queue Setup

Untuk memastikan email terkirim:

```bash
# Start queue worker
php artisan queue:work --queue=default --tries=3

# Atau gunakan supervisor
# config/supervisor/laravel-worker.conf
```

---

## Troubleshooting

### Email tidak terkirim?

1. Cek `.env` email configuration
2. Test email:
   ```bash
   php artisan tinker
   >>> Mail::raw('test', function($m) { $m->to('your@email.com'); })
   ```
3. Cek queue worker running:
   ```bash
   php artisan queue:work
   ```
4. Cek logs:
   ```bash
   tail -f storage/logs/laravel.log
   ```

### Notifikasi tidak muncul di database?

1. Cek User model punya Notifiable trait
   ```php
   use Illuminate\Notifications\Notifiable;
   class User extends Authenticatable {
       use Notifiable;
   }
   ```

2. Cek notifications table ada:
   ```bash
   php artisan migrate
   ```

3. Check dari tinker:
   ```bash
   php artisan tinker
   >>> $user = User::find(1);
   >>> $user->notifications()->count();
   ```

### Event tidak muncul di kalender?

1. Cek event sudah ada di database:
   ```bash
   php artisan tinker
   >>> \App\Models\KalenderProker::count()
   ```

2. Cek is_publik = true untuk public access
3. Cek divisi_id matches dengan filter
4. Cek dates tidak infinite (tgl_selesai >= tgl_mulai)

### Status change tidak trigger notifikasi?

Status changes hanya trigger notifikasi dari `created()` dan `updated()` hooks.
Jika ingin custom notifikasi untuk status changes, tambah di controller:

```php
public function markOngoing(KalenderProker $kalenderProker)
{
    $kalenderProker->update(['status' => 'ongoing']);
    
    // Trigger notifikasi custom
    Notification::send($users, new CustomNotification($kalenderProker));
}
```

---

## Quick Test Commands

```bash
# Test API endpoint
curl -H "Authorization: Bearer YOUR_TOKEN" http://localhost/api/kalender

# Create event
curl -X POST http://localhost/api/kalender \
  -H "Authorization: Bearer YOUR_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{
    "kegiatan_id": 1,
    "divisi_id": 1,
    "tgl_mulai": "2026-04-20",
    "tgl_selesai": "2026-04-21",
    "warna": "#3B82F6",
    "is_publik": true
  }'

# Get notifications
curl -H "Authorization: Bearer YOUR_TOKEN" http://localhost/api/notifications

# Test in Laravel Tinker
php artisan tinker
>>> Event::create(['kegiatan_id' => 1, 'divisi_id' => 1, 'tgl_mulai' => now(), 'tgl_selesai' => now()->addDay()])
>>> User::first()->notifications()->count()
```

---

## Support & Updates

Last Updated: 17 April 2026
Version: 2.0 (Dengan Kalender Proker & Email Notifications)
