<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
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

    // Hanya user aktif yang bisa akses panel Filament
    // Pimpinan dan Pengurus bisa akses panel Filament
    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === 'aktif' &&
            $this->hasAnyRole(['pimpinan', 'pengurus']);
    }

    // Relasi ke tabel divisi
    public function dinas()
    {
        return $this->belongsTo(Dinas::class, 'dinas_id');
    }

    // Relasi ke Laravel Notifications
    public function notifications()
    {
        return $this->hasMany(
            'Illuminate\Notifications\DatabaseNotification',
            'notifiable_id'
        )->where('notifiable_type', self::class)
            ->orderBy('created_at', 'desc');
    }

    // Relasi ke notifikasi yang belum dibaca
    public function unreadNotifications()
    {
        return $this->notifications()
            ->whereNull('read_at')
            ->orderBy('created_at', 'desc');
    }
}