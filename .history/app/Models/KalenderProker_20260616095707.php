<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Kegiatan;
use App\Models\Divisi;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Auth;

class KalenderProker extends Model
{
    use HasFactory;
    // use Notifiable; // OPSIONAL: Jika model ini yang menerima notifikasi

    protected $fillable = [
        'kegiatan_id',
        'divisi_id',
        'tgl_mulai',
        'tgl_selesai',
        'warna',
        'is_publik',
        // TAMBAHAN: Field baru yang berguna
        'status',
        'reminder_at',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'tgl_mulai' => 'datetime', // UBAH: dari 'date' ke 'datetime'
        'tgl_selesai' => 'datetime', // UBAH: dari 'date' ke 'datetime'
        'is_publik' => 'boolean',
        'reminder_at' => 'datetime', // TAMBAHAN
    ];

    // ========== RELASI (SUDAH ADA) ==========
    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }

    public function divisi()
    {
        return $this->belongsTo(Divisi::class);
    }

    // ========== TAMBAHAN: Relasi Baru ==========
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }


    public function getTitle()
    {
        // Ambil judul dari relasi kegiatan
        return $this->kegiatan ? $this->kegiatan->nama_kegiatan : 'Kegiatan Tanpa Nama';
    }

    public function isAllDay()
    {
        // Cek apakah event sepanjang hari
        if (! $this->tgl_mulai || ! $this->tgl_selesai) {
            return false;
        }

        return $this->tgl_mulai->format('H:i') === '00:00' &&
               $this->tgl_selesai->format('H:i') === '23:59';
    }

    public function getStart()
    {
        return $this->tgl_mulai;
    }

    public function getEnd()
    {
        return $this->tgl_selesai;
    }

    public function getEventOptions()
    {
        // Konfigurasi tampilan di kalender
        return [
            'color' => $this->warna ?? '#3788d8',
            'textColor' => $this->getContrastColor($this->warna ?? '#3788d8'),
            'borderColor' => $this->warna ?? '#3788d8',
            'className' => $this->is_publik ? 'event-publik' : 'event-private',
            'extendedProps' => [
                'kegiatan_id' => $this->kegiatan_id,
                'divisi' => $this->divisi ? $this->divisi->nama_divisi : null,
                'deskripsi' => $this->kegiatan ? $this->kegiatan->deskripsi : null,
                'is_publik' => $this->is_publik,
                'status' => $this->status ?? 'scheduled',
            ]
        ];
    }

    // ========== TAMBAHAN: Helper Methods ==========
    
    /**
     * Mendapatkan warna teks yang kontras dengan background
     */
    protected function getContrastColor($hexColor)
    {
        // Hapus # jika ada
        $hexColor = ltrim($hexColor, '#');
        
        // Konversi ke RGB
        $r = hexdec(substr($hexColor, 0, 2));
        $g = hexdec(substr($hexColor, 2, 2));
        $b = hexdec(substr($hexColor, 4, 2));
        
        // Hitung luminance
        $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
        
        return $luminance > 0.5 ? '#000000' : '#ffffff';
    }

    /**
     * Scope untuk filter event yang akan datang
     */
    public function scopeUpcoming($query)
    {
        return $query->where('tgl_mulai', '>=', now());
    }

    /**
     * Scope untuk filter event publik
     */
    public function scopePublic($query)
    {
        return $query->where('is_publik', true);
    }

    /**
     * Scope untuk filter per divisi
     */
    public function scopeByDivision($query, $divisiId)
    {
        return $query->where('divisi_id', $divisiId);
    }

    /**
     * Scope untuk filter berdasarkan tanggal
     */
    public function scopeBetweenDates($query, $start, $end)
    {
        return $query->where(function ($q) use ($start, $end) {
            $q->whereBetween('tgl_mulai', [$start, $end])
              ->orWhereBetween('tgl_selesai', [$start, $end])
              ->orWhere(function ($q) use ($start, $end) {
                $q->where('tgl_mulai', '<=', $start)
                    ->where('tgl_selesai', '>=', $end);
            });
        });
    }

    /**
     * Cek apakah event sedang berlangsung
     */
    public function isOngoing()
    {
        return now()->between($this->tgl_mulai, $this->tgl_selesai);
    }

    /**
     * Cek apakah event sudah selesai
     */
    public function isFinished()
    {
        return now()->gt($this->tgl_selesai);
    }

    /**
     * Mendapatkan durasi event dalam hari
     */
    public function getDurationInDays()
    {
        return $this->tgl_mulai->diffInDays($this->tgl_selesai) + 1;
    }

    /**
     * Mendapatkan status dalam bahasa Indonesia
     */
    public function getStatusLabel()
    {
        if ($this->isFinished()) {
            return 'Selesai';
        } elseif ($this->isOngoing()) {
            return 'Sedang Berlangsung';
        } else {
            return 'Akan Datang';
        }
    }

    // ========== TAMBAHAN: Boot Method untuk Event Handling ==========
    protected static function boot()
    {
        parent::boot();

        // Set created_by dan updated_by otomatis
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
                $model->updated_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });

        // Trigger notifikasi setelah event dibuat
        static::created(function ($event) {
            // Load relationships for notification
            $event->load('kegiatan', 'divisi');
            
            // Kirim notifikasi ke divisi terkait atau semua user
            if ($event->divisi) {
                $users = User::where('divisi_id', $event->divisi_id)->where('status', 'aktif')->get();
            } else {
                // Jika tidak ada divisi, kirim ke semua user aktif
                $users = User::where('status', 'aktif')->get();
            }
            
            if ($users->count() > 0) {
                try {
                    Notification::send($users, new \App\Notifications\ProkerNotification($event, 'created'));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim notifikasi ProkerNotification: ' . $e->getMessage());
                }
            }
        });

        // Trigger notifikasi setelah event diupdate
        static::updated(function ($event) {
            // Load relationships for notification
            $event->load('kegiatan', 'divisi');
            
            // Kirim notifikasi ke divisi terkait atau semua user
            if ($event->divisi) {
                $users = User::where('divisi_id', $event->divisi_id)->where('status', 'aktif')->get();
            } else {
                // Jika tidak ada divisi, kirim ke semua user aktif
                $users = User::where('status', 'aktif')->get();
            }
            
            if ($users->count() > 0) {
                try {
                    Notification::send($users, new \App\Notifications\ProkerNotification($event, 'updated'));
                } catch (\Exception $e) {
                    Log::error('Gagal mengirim notifikasi ProkerNotification: ' . $e->getMessage());
                }
            }
        });
    }
}