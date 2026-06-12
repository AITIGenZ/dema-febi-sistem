<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasAvatar;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser, HasAvatar
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'nim',
        'email',
        'phone',
        'photo',
        'avatar_url',
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

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->status === 'aktif' &&
            $this->hasAnyRole(['pimpinan', 'pengurus']);
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::url($this->avatar_url) : null;
    }

    public function dinas()
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