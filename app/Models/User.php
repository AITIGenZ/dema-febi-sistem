<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'phone',
        'photo',
        'dinas_id',
        'status',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Logika pencarian file foto untuk Avatar Topbar Filament
     */
    public function getFilamentAvatarUrl(): ?string
    {
        // Jika data kolom photo di database kosong/null, tampilkan inisial (KF)
        if (! $this->photo) {
            return null;
        }

        // 1. Jika path di database berupa URL lengkap (http:// atau https://)
        if (str_starts_with($this->photo, 'http://') || str_starts_with($this->photo, 'https://')) {
            return $this->photo;
        }

        // 2. Jika foto ditaruh langsung di folder public/images/nama_file.png
        if (file_exists(public_path('images/' . $this->photo))) {
            return asset('images/' . $this->photo);
        }

        // 3. Jika menggunakan sistem upload bawaan Laravel Storage (storage/app/public)
        return Storage::url($this->photo);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === 'aktif' &&
            $this->hasAnyRole(['pimpinan', 'pengurus', 'super_admin']);
    }

<<<<<<< HEAD
    // Relasi ke tabel divisi
    public function dinas()
=======
    public function divisi()
>>>>>>> 6b08088 (fitur: memindahkan logo ke topbar, kustomisasi avatar profil, dan penyesuaian halaman admin)
    {
        return $this->belongsTo(Dinas::class, 'dinas_id');
    }

    public function notifications()
    {
        return $this->hasMany(
            'Illuminate\Notifications\DatabaseNotification',
            'notifiable_id'
        )->where('notifiable_type', self::class)
            ->orderBy('created_at', 'desc');
    }

    public function unreadNotifications()
    {
        return $this->notifications()
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc');
    }
}