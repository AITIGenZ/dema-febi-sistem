<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserNotification extends Model
{
    use HasFactory;

    /**
     * Nama tabel di database
     */
    protected $table = 'user_notifications';

    /**
     * Kolom yang bisa diisi massal
     */
    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'icon',
        'action_url',
        'metadata',
        'read_at',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'read_at' => 'datetime',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Default values
     */
    protected $attributes = [
        'type' => 'system',
        'icon' => '📌',
    ];

    // ========== RELASI ==========
    
    /**
     * Relasi ke User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ========== SCOPE QUERIES ==========
    
    /**
     * Scope: Notifikasi yang belum dibaca
     */
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Scope: Notifikasi yang sudah dibaca
     */
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    /**
     * Scope: Filter berdasarkan user
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope: Filter berdasarkan tipe notifikasi
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope: Notifikasi event/proker
     */
    public function scopeProkerNotifications($query)
    {
        return $query->whereIn('type', ['event', 'proker', 'reminder']);
    }

    /**
     * Scope: Notifikasi terbaru
     */
    public function scopeLatest($query, $limit = 10)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }

    // ========== HELPER METHODS ==========
    
    /**
     * Tandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            return $this->update(['read_at' => now()]);
        }
        return false;
    }

    /**
     * Tandai notifikasi sebagai belum dibaca
     */
    public function markAsUnread()
    {
        if (!is_null($this->read_at)) {
            return $this->update(['read_at' => null]);
        }
        return false;
    }

    /**
     * Cek apakah notifikasi sudah dibaca
     */
    public function isRead()
    {
        return !is_null($this->read_at);
    }

    /**
     * Cek apakah notifikasi belum dibaca
     */
    public function isUnread()
    {
        return is_null($this->read_at);
    }

    /**
     * Format waktu "X menit yang lalu"
     */
    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Format waktu lengkap
     */
    public function getFormattedTimeAttribute()
    {
        return $this->created_at->format('d M Y, H:i');
    }

    /**
     * Get icon berdasarkan tipe notifikasi
     */
    public function getIconAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Default icon berdasarkan tipe
        $icons = [
            'event' => '📅',
            'proker' => '📋',
            'reminder' => '⏰',
            'system' => '🔔',
            'success' => '✅',
            'warning' => '⚠️',
            'error' => '❌',
            'info' => 'ℹ️',
        ];

        return $icons[$this->type] ?? '📌';
    }

    /**
     * Get badge class untuk styling
     */
    public function getBadgeClassAttribute()
    {
        $classes = [
            'event' => 'badge-primary',
            'proker' => 'badge-info',
            'reminder' => 'badge-warning',
            'system' => 'badge-secondary',
            'success' => 'badge-success',
            'error' => 'badge-danger',
        ];

        return $classes[$this->type] ?? 'badge-light';
    }

    /**
     * Get action URL dengan fallback
     */
    public function getActionUrlAttribute($value)
    {
        if ($value) {
            return $value;
        }

        // Default URL berdasarkan tipe dan metadata
        if ($this->type === 'event' || $this->type === 'proker') {
            $prokerId = $this->metadata['proker_id'] ?? null;
            if ($prokerId) {
                return route('kalender.show', $prokerId);
            }
        }

        return '#';
    }

    /**
     * Format notifikasi untuk response JSON (API)
     */
    public function toApiFormat()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'message' => $this->message,
            'type' => $this->type,
            'icon' => $this->icon,
            'action_url' => $this->action_url,
            'metadata' => $this->metadata,
            'is_read' => $this->isRead(),
            'time_ago' => $this->time_ago,
            'formatted_time' => $this->formatted_time,
            'created_at' => $this->created_at->toISOString(),
        ];
    }

    // ========== STATIC METHODS ==========
    
    /**
     * Tandai semua notifikasi user sebagai dibaca
     */
    public static function markAllAsReadForUser($userId)
    {
        return self::where('user_id', $userId)
                   ->whereNull('read_at')
                   ->update(['read_at' => now()]);
    }

    /**
     * Hapus notifikasi lama (lebih dari X hari)
     */
    public static function cleanOldNotifications($days = 30)
    {
        return self::where('created_at', '<', now()->subDays($days))
                   ->delete();
    }

    /**
     * Buat notifikasi dari Proker
     */
    public static function createFromProker($proker, $action = 'created', $userIds = [])
    {
        $notifications = [];
        $users = empty($userIds) ? User::all() : User::whereIn('id', $userIds)->get();

        foreach ($users as $user) {
            $notifications[] = self::create([
                'user_id' => $user->id,
                'title' => 'Program Kerja ' . ucfirst($action),
                'message' => "Program kerja '{$proker->kegiatan->nama_kegiatan}' telah {$action}",
                'type' => 'proker',
                'icon' => '📋',
                'action_url' => route('kalender.show', $proker->id),
                'metadata' => [
                    'proker_id' => $proker->id,
                    'divisi' => $proker->divisi->nama_divisi ?? null,
                    'action' => $action,
                    'tgl_mulai' => $proker->tgl_mulai->format('Y-m-d'),
                    'tgl_selesai' => $proker->tgl_selesai->format('Y-m-d'),
                ],
            ]);
        }

        return $notifications;
    }

    /**
     * Hitung notifikasi belum dibaca untuk user
     */
    public static function unreadCount($userId)
    {
        return self::where('user_id', $userId)
                   ->whereNull('read_at')
                   ->count();
    }

    // ========== BOOT METHOD ==========
    
    protected static function boot()
    {
        parent::boot();

        // Auto-set icon jika tidak diisi
        static::creating(function ($notification) {
            if (empty($notification->icon)) {
                $notification->icon = $notification->getIconAttribute(null);
            }
        });

        // Broadcast event saat notifikasi dibuat (untuk real-time)
        static::created(function ($notification) {
            // Bisa trigger event broadcasting di sini
            // broadcast(new NewNotification($notification))->toOthers();
        });
    }
}